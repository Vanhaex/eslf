<?php

namespace Framework;

use mysqli;
use ReflectionClass;

require('../config/database.config.php');

class Database
{

  /**
  * @var \mysqli
  */
  private $mysqli;

  /**
  * Database connection credentials
  */
  private $host;
  private $port;
  private $user;
  private $password;
  private $database;

  private $db_exceptions = true;
  private $transaction = true;
  private $result_object = true;
  private $row_count; // Number of rows
  private $affected_rows;
  private $last_id;

  private $err_code;
  private $err_string;

  public function __construct()
  {
    $this->init();
    $this->connect();

    if ($this->transaction == true) {
      $this->autocommit();
    }
  }

  public function init()
  {
    $this->host = CONFIG_DATABASE_HOST;
    $this->port = CONFIG_DATABASE_PORT;
    $this->user = CONFIG_DATABASE_USER;
    $this->password = CONFIG_DATABASE_PASSWORD;
    $this->database = CONFIG_DATABASE_DATABASE;
  }

  public function connect()
  {
    if (empty($this->host) || empty($this->port) || empty($this->user) || empty($this->password) || empty($this->database)) {
      printf("Database connection error : Missing informations");
      exit();
    }

    if (is_null($this->mysqli)) {
      $this->mysqli = new mysqli();
      $this->mysqli->init(); // Initialize MySQLi
    }
    elseif (!is_null($this->mysqli)) {
      $this->close();
    }

    if($this->db_exceptions == true){
      mysqli_report(MYSQLI_REPORT_ERROR || MYSQLI_REPORT_STRICT); // Adding exceptions
    }

    // Connecting to database if it's ok
    $connect = $this->mysqli->real_connect($this->host, $this->user, $this->password, $this->database, $this->port);

    if ($connect == false) {
      $this->err_code = $this->mysqli->errno;
      $this->$err_string = $this->mysqli->error;
      printf("Database connection error : Incorrect informations");
      exit();
    }

    return $connect;
  }

  public function reconnect()
  {
    return $this->mysqli->ping();
  }

  public function disconnect()
  {
    if (is_null($this->mysqli)) {
      return true;
    }

    $this->mysqli->close();
    $this->mysqli = null; // Destroy mysqli object

    return true;
  }

  public function query(string $query)
  {
    $this->reset_mysqli(); // Empty the variables

    trim($query); // Remove spaces

    $exec_query = $this->mysqli->real_query($query);

    if ($exec_query = true) {
      if ($this->mysqli->field_count) {

        $result = $this->mysqli->store_result();

        if ($this->result_object = true) {
          while ($data = $result->fetch_object()) {
            array_push($this->result, $data);
          }
        }
        else {
          while ($data = $result->fetch_assoc()) {
            array_push($this->result, $data);
          }
        }

        $this->row_count = $result->num_rows; // Getting the number of rows

        $result->free(); // Free memory
      }
      else{
        $this->affected_rows = $this->mysqli->affected_rows;
        $this->last_id = $this->mysqli->insert_id;
      }
    }
    else {
      $this->err_code = $this->mysqli->errno;
      $this->err_string = $this->mysqli->error;
      printf("An error occured during the execution of query");
      exit();
    }
  }

  public function preparedQuery(string $prepared_query, string $bind_param, ...$bind_data)
  {
    $this->reset_mysqli(); // Empty the variables

    $prepared_query = trim($prepared_query); // Remove spaces

    $stmt = $this->mysqli->prepare($prepared_query);

    if (is_array($bind_data[0])) {
      $bind_data = $bind_data[0];
    }

    foreach (array_keys($bind_data) as $i) {
      $refs_bind_data[] = &$bind_data[$i];
    }

    $bind_params = array_merge(array($bind_param), $refs_bind_data);

    $ref = new ReflectionClass('mysqli_stmt');
    $ref->getMethod("bind_param")->invokeArgs($stmt, $bind_params);

    $result_execute = $stmt->execute();

    if ($result_execute) {

      $meta = $stmt->result_metadata();

      if ($meta != false) {

        $result = $stmt->get_result();

        if ($this->result_object = true) {
          while ($data = $result->fetch_object()) {
            array_push($this->result, $data);
          }
        }
        else {
          while ($data = $result->fetch_assoc()) {
            array_push($this->result, $data);
          }
        }

        $this->row_count = $result->num_rows;
        $meta->free();
      }
      else{
        $this->affected_rows = $this->mysqli->affected_rows;
        $this->last_id = $stmt->insert_id;
      }
    }
    else {
      $this->err_code = $stmt->errno;
      $this->err_string = $stmt->error;
      printf("An error occured during the execution of prepared query");
      exit();
    }

    $stmt->close();
  }

  public function getAllResults()
  {
    return $this->result;
  }

  public function getNextResult()
  {
    $next_result = current($this->result);
    next($this->result);

    if (!is_array($next_result) && !is_object($next_result)) {
      return null;
    }

    return $next_result;
  }

  public function getNumberResults()
  {
    return $this->row_count;
  }

  public function getLastID()
  {
    return $this->insert_id;
  }

  public function getErrorCode()
  {
    return $this->err_code;
  }

  public function getErrorString()
  {
    return $this->err_string;
  }

  public function reset_mysqli()
  {
      // Let's clean the variables
      $this->err_code = 0;
      $this->err_string = null;
      $this->result_store = 0;
      $this->insert_id = 0;
      $this->affected_rows = 0;
      $this->row_count = 0;
      $this->result = [];
  }

  /**** Transaction options ****/

  public function commit()
  {
    if ($this->transaction == true) {
      return $this->mysqli->commit();
    }
  }

  public function rollback()
  {
    if ($this->transaction == true) {
      return $this->mysqli->rollback();
    }
  }

  public function autocommit()
  {
    if ($this->transaction == true) {
      return $this->mysqli->autocommit(true);
    }
    else {
      return $this->mysqli->autocommit(false);
    }
  }
}

?>

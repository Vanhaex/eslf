<?php

namespace App;

use Framework\InputUtility;
use Framework\Controller;
use Framework\Database;

class HomeController extends Controller
{

  public function index()
  {
    $this->view('home.tpl');
  }

  public function bzipbzip()
  {
    $this->view('home.tpl');
  }

  public function test($id)
  {
    echo "Le ID est égal à : " . $id;
  }

  public function database()
  {
    $this->view('database.tpl', $params);
  }

  public function database_prepared()
  {
    $name = InputUtility::post('name');

    $database = new Database();

    $database->preparedQuery("SELECT id, name FROM test_table WHERE name = ?", "s", $name);

    $result = $database->getNextResult();

    $number = $database->getNumberResults();

    if ($number == 0) {
      echo "Y'a rien du tout !";
    }
    else {
      echo "Il y a une entrée : " . $result->name;
    }
  }
}



?>

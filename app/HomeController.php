<?php

namespace App;

use Framework\InputUtility;
use Framework\Controller;

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

  public function testdb()
  {
    $this->esdbaccess->querySelect("test_table", null, "LIMIT 1");

    $resultat = $this->esdbaccess->thisResult();

    var_dump($resultat->nom);

    $params = [
        "resultat" => $resultat
    ];

    $this->view('database_prep.tpl', $params);
  }

}



?>

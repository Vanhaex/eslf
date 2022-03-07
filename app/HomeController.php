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

  public function test()
  {
    $this->view('test.tpl');
  }

  public function testpost()
  {
    $value = InputUtility::post("nom");

    $params = [
        "afficher_nom" => $value
    ];

    $this->view('resultattest.tpl', $params);
  }

}



?>

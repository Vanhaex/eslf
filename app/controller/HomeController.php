<?php

namespace App\controller;

use Framework\InputUtility;
use Framework\Controller;
use Framework\AlertMessage\AlertMessage;

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

  public function testalerte()
  {
    $value = "Bonjour, je suis une alerte";

    $alert = new AlertMessage();

    $alert->addAlertMessage($value, "danger");

    $this->view('resultattest.tpl');
  }

}



?>

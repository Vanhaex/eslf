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
}



?>

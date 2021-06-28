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
}



?>

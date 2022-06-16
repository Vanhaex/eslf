<?php

namespace App\controller;

use Framework\Controller;
use App\model\Home;

class HomeController extends Controller
{
  public function index()
  {
    $res = new Home();

    $res = $res->getSome(5);

    $this->view('home.tpl', ['res' => $res]);
  }
}



?>

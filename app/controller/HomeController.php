<?php

namespace App\controller;

use Framework\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home.tpl');
    }
}

?>
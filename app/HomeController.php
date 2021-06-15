<?php

namespace App;

use Framework\InputUtility;
use Framework\Controller;

class HomeController extends Controller
{
  public function index()
  {
    echo $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'views' .  DIRECTORY_SEPARATOR;
  }

  public function bzibzi()
  {
    echo "bzibzibizizizizizizizi";
  }
}



?>

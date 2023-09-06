<?php

namespace App\controllers;

use Core\Controller;

class HomeController extends ContainerController
{
  
  public function index()
  {
    $this->view([
      'title' => 'Home'
    ], 'home');
  }
}

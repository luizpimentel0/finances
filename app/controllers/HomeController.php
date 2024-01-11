<?php

namespace App\controllers;

class HomeController extends ContainerController
{

  public function index(): void
  {
    $this->view([
      'title' => 'Home'
    ], 'home');
  }
}

<?php

namespace Core;

use App\classes\Uri;
use App\exceptions\ControllerNotExistException;

class Controller
{
  private $uri;

  private $folders = ['App\controllers', 'App\controllers\user', 'App\controllers\finance'];
  private $namespace;
  private $controller;

  public function __construct()
  {
    $this->uri = Uri::uri();
  }

  public function loadController()
  {
    if($this->isHomePage()) {
      return $this->homeController();
    }

    return $this->isNotHomeController();
  }

  private function homeController(): mixed
  {
    if(!$this->controllerExists('HomeController')) {
      throw new ControllerNotExistException('O controller não existe');
    }

    return $this->instantiateController();
  }

  private function isNotHomeController()
  {
    $controller = $this->getIsNotHomeController();
    // UserController

    if (!$this->controllerExists($controller)) {
      throw new ControllerNotExistException('A paǵina não existe');
    }

    return $this->instantiateController();
  }

  private function getIsNotHomeController(): string
  {
    if (substr_count($this->uri, '/') > 1) {
      list($controller) = array_values(array_filter(explode('/', $this->uri)));
      return ucfirst($controller) . 'Controller';
    }

    return ucfirst(ltrim($this->uri, '/')) . 'Controller';
  }

  private function isHomePage(): bool
  {
    return $this->uri == '/';
  }

  private function controllerExists(string $controllerName): bool
  {
    $controllerExists = false;

    foreach($this->folders as $folder) {
      if (class_exists($folder . '\\' . $controllerName)) {
        $controllerExists = true;
        $this->namespace = $folder;
        $this->controller = $controllerName;
      }
    }
    return $controllerExists;
  }

  private function instantiateController()
  {
    $controller = $this->namespace . '\\' . $this->controller;
    return new $controller;
  }
}

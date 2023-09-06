<?php

use Core\Controller;
use Core\Method;
use Core\Parameters;

require '../bootstrap.php';

try {
  $controller = new Controller;
  $controller = $controller->loadController();

  $method = new Method;
  $method = $method->loadMethod($controller);

  $parameters = new Parameters;
  $parameters = $parameters->loadParameters();

  $controller->$method($parameters);

} catch (Exception $error) {
  debug($error->getMessage());
}



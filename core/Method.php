<?php

namespace Core;

use App\classes\Uri;
use App\exceptions\MethodNotExistException;

class Method
{
  private $uri;

  public function __construct()
  {
    $this->uri = Uri::uri();
  }

  public function loadMethod($controller): string
  {
    $method = $this->getMethod();

    if (!method_exists($controller, $method)) {
      throw new MethodNotExistException('A página não existe: ' . $method);
    }

    return $method;
  }

  private function getMethod(): string
  {
    if(substr_count($this->uri, '/') > 1) {
      list($controller, $method) = array_values(array_filter(explode('/', $this->uri)));

      if(!$method) {
        return 'index';
      }

      return $method;
    }

    return 'index';
  }
}

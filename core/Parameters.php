<?php

namespace Core;

use App\classes\Uri;

class Parameters
{
  private $uri;

  public function __construct()
  {
    $this->uri = Uri::uri();
  }

  public function loadParameters()
  {
    return $this->getParameter();
  }

  private function getParameter()
  {
    if (substr_count($this->uri, '/') > 2) {
      $parameter = array_values(array_filter(explode('/', $this->uri)));

      return (object) [
        'parameter' => filter_var($parameter[2], FILTER_SANITIZE_STRING)
      ];
    }
  }
}

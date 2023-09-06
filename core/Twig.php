<?php

namespace Core;

class Twig
{
  private $twig;
  private $functions = [];

  public function loadTwig()
  {
    $this->twig = new \Twig\Environment($this->loadViews(), [
      'auto_reload' => true,
      'debug' => true,
    ]);

    $this->twig->addGlobal('session', $_SESSION);

    return $this->twig;
  }

  private function loadViews()
  {
    return new \Twig\Loader\FilesystemLoader([
      __DIR__ . '/../app/views/',
    ]);
  }

  private function functionsToView($name, \Closure $callback)
  {
    return new \Twig\TwigFunction($name, $callback);
  }
}

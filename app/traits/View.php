<?php

namespace App\traits;

use Core\Twig;

trait View
{

  private function twig()
  {
    $twig = new Twig;
    return $twig->loadTwig();
  }

  public function view(array $data,  string $viewPath)
  {
    $template = $this->twig()->load(str_replace('.', '/', $viewPath) . '.html');

    return $template->display($data);
  }
}

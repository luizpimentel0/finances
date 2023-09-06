<?php

namespace App\controllers\user;
use App\controllers\ContainerController;
use App\models\user\User;

class UserController extends ContainerController
{

  private $errors = [];

  public function register()
  {
    if ($_SESSION['user']) {
      header("Location: /finance");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = $_POST['username'] ?? null;
      $email    = $_POST['email'] ?? null;
      $password = $_POST['password'] ?? null;

      if (($username == null) || ($username == '')) {
        $this->errors[] = "O campo usuário é obrigatório";
      }
      
      if (($email == null) || ($email == '')) {
        $this->errors[] = "O campo email é obrigatório";
      }

      if (($password == null) || ($password == '')) {
        $this->errors[] = "O campo senha é obrigatório";
      }
    
      $user = new User;

      $values = [
        'username' => $username,
        'email'    => $email,
        'password' => $password
      ];

      $user = $user->insert($values);

      if ($user) {
        $_SESSION['user']   = $username;
        $_SESSION['userId'] = $user;

        header('Location: /finance');
      }
    }

    {
      $this->view([
        'title' => 'Registro',
        'user' => 'Register',
      ], 'user.register');
    }
  }

  public function login()
  {
    if ($_SESSION['user']) {
      header("Location: /finance");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email    = $_POST['email'] ?? null;
      $password = $_POST['password'] ?? null;

      if (($email == null) || ($email == '')) {
        $this->errors[] = "O campo email é obrigatório";
      }

      if (($password == null) || ($password == '')) {
        $this->errors[] = "O campo senha é obrigatório";
      }

      $user = new User();
      $userLogin = $user->login($email, $password);
      if (!array_key_exists('error', $userLogin)) {
        $_SESSION['user'] = $userLogin['username'];
        $_SESSION['userId'] = $userLogin['id'];
        header('Location: /finance');
      }
      return $this->view([
        'error' => $userLogin['error'],
        'email' => $email
      ], 'user.login');

    } else {
      $this->view([
        '',
      ], 'user.login');
    }
  }

  public function logout()
  {
    session_destroy();
    header('Location: /');
  }
}

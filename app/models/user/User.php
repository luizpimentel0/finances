<?php

namespace App\models\user;

use App\models\Model;

class User extends Model
{
  protected $table = "users";

  public function login(string $email, string $password)
  {
    $sql = "select * from {$this->table} where email = '{$email}' and password = '{$password}'";
    $statement = $this->connection->query($sql);
    $statement->execute();

    if (!$statement->rowCount() > 0) {
      return ['error' => 'Email ou senha incorretos', 'email' => $email];
    }

    return (array) $statement->fetch();
  }
}

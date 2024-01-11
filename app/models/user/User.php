<?php

namespace App\models\user;

use App\models\Model;

class User extends Model
{
  protected $table = "users";

  public function index(): void
  {
    $createTable = "CREATE TABLE IF NOT EXISTS {$this->table} (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(100) NOT NULL,
      `password` varchar(20) NOT NULL,
      `email` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    )";

    $statement = $this->connection->query($createTable);
    $statement->execute();
  }

  public function login(string $email, string $password): array
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

<?php

namespace App\models\finance;

use App\models\Model;

class Finance extends Model
{
  protected $table = "user_finances";

  public function index(): void
  {
    $createTable = "CREATE TABLE IF NOT EXISTS
    `{$this->table}` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `category` varchar(10) NOT NULL,
      `description` varchar(100) NOT NULL,
      `value` float NOT NULL,
      `user_id` int(11) NOT NULL,
      `date` date NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    )";
    $statement = $this->connection->query($createTable);
    $statement->execute();
  }
}

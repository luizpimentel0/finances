<?php

namespace App\models;

use PDO;

class Connection
{
  const HOST     = 'localhost';
  const DBNAME   = 'finances';
  const USERNAME = 'YOUR_USERNAME';
  const PASSWORD = 'YOUR_PASSWORD';

  private static function createDatabase(): void
  {
    try {
      $pdo = new PDO("mysql:host=" . self::HOST, self::USERNAME, self::PASSWORD);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query = "CREATE DATABASE IF NOT EXISTS finances";
      $pdo->exec($query);
    } catch (\PDOException $error) {
      debug('ERROR: ' . $error->getMessage());
    }
  }

  public static function connect(): PDO
  {

    try {
      self::createDatabase();

      $pdo = new PDO("mysql:host=" . self::HOST.";dbname=". self::DBNAME, self::USERNAME, self::PASSWORD);

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    } catch (\PDOException $error) {
      debug('ERROR: ' . $error->getMessage());
    }

    return $pdo;
  }
}

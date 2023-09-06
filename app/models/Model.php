<?php

namespace App\models;

abstract class Model
{
  protected $connection;

  public function __construct()
  {
    $this->connection = Connection::connect();
  }


  public function all()
  {
    $sql = "select * from {$this->table}";
    $list = $this->connection->query($sql);
    $list->execute();

    return $list->fetchAll();
  }

  public function getById(string $field, string $fieldValue)
  {
    $query = "select * from {$this->table} WHERE {$field} = {$fieldValue}";
    $statement = $this->connection->query($query);

    try {
      $statement->execute();
      return $statement->fetchAll();
    } catch (\PDOException $error) {
      return 'Error: ' . $error->getMessage();
    }
  }

  public function insert(array $values)
  {
    $query = "INSERT INTO {$this->table} (" . implode(',',  array_keys($values)) . ") VALUES (" . implode(',', (array_fill(0, count($values), '?'))) . ")";
    $statement = $this->connection->prepare($query);

    try {
      $statement->execute(array_values($values));

      if ($statement->rowCount() > 0) {
        return $this->connection->lastInsertId();
      }
    }catch(\PDOException $error) {
      return 'Error: '. $error->getMessage();
    }
  }

  public function edit(array $values, int $id): bool|\PDOException
  {
    $query = "UPDATE {$this->table} SET " . implode('=?,', array_keys($values)) . "=? WHERE id = {$id}";
    $statement = $this->connection->prepare($query);

    try {
      $statement->execute(array_values($values));

      return true;
    }catch(\PDOException $error) {
      return 'Error: '. $error->getMessage();
    }
  }

  public function delete(int $id): bool|\PDOException
  {
    $query = "DELETE FROM {$this->table} WHERE id = ?";
    $statement = $this->connection->prepare($query);

    try {
      $statement->execute([$id]);

      if ($statement->rowCount() > 0) {
        return true;
      }
    } catch (\PDOException $error) {
      return 'Error: ' . $error->getMessage();
    }
  }
}

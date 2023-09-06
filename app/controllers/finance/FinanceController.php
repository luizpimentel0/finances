<?php

namespace App\controllers\finance;

use App\controllers\ContainerController;
use App\models\finance\Finance;
use DateTime;

class FinanceController extends ContainerController
{
  public function index()
  {
    if (!$_SESSION['userId']) header('Location: /user/login');

    $finance = new Finance;

    $userFinances = $finance->getById('user_id', $_SESSION['userId']);

    $income = 0;
    $outflow = 0;
    $balance = 0;

    $userFinancesArray = [];

    foreach ($userFinances as $userFinance) {

      $date = new DateTime($userFinance->date);
      $dateFormated = $date->format('d/m/Y');
        
      $userFinancesArray[] = [
        'id'          => $userFinance->id,
        'date'        => $dateFormated,
        'description' => $userFinance->description,
        'category'    => $userFinance->category == 'income' ? 'Entrada' : 'Saída',
        'categoryClass' => $userFinance->category,
        'value'       => number_format($userFinance->value, 2, ',', '.')
      ];

      if ($userFinance->category == 'income') {
        $income += $userFinance->value;
      } else {
        $outflow += $userFinance->value;
      }
    }

    $balance = number_format($income - $outflow, 2, ',', '.');

    $this->view([
      'userFinances' => $userFinancesArray,
      'income'  => number_format($income, 2, ',', '.'),
      'outflow' => number_format($outflow, 2, ',', '.'),
      'balance' => $balance,

    ], 'finance.finances');

    $_SESSION['success'] = false;
  }

  public function register()
  {

    if (!$_SESSION['userId']) header('Location: /user/login');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $description = $_POST['description'] ?? null;
      $value       = $_POST['value'] ?? null;
      $date        = $_POST['date'] ?? null;
      $category    = $_POST['category'] ?? null;

      $finance = new Finance();

      $values = [
        'description' => $description,
        'value'       => $value,
        'date'        => $date,
        'category'    => $category,
        'user_id'     => $_SESSION['userId']
      ];

      $insertFinance = $finance->insert($values);

      if (!$insertFinance) {
        header('Location: /finance');
      }
      $_SESSION['success'] = true;
      $_SESSION['message'] = 'Registro adicionado com sucesso!';
      header('Location: /finance');
    }
  }

  public function show($request)
  {
    if (!$_SESSION['userId']) header('Location: /user/login');

    $finance = new Finance();

    $financeToEdit = $finance->getById('id', $request->parameter);

    header('Content-Type: application/json');
    http_response_code(200);

    $jsonResponse = json_encode([
      'description' => $financeToEdit[0]->description,
      'value' => $financeToEdit[0]->value,
      'date' => $financeToEdit[0]->date,
      'category' => $financeToEdit[0]->category
    ]);

    echo $jsonResponse;
  }

  public function edit($request)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $finance = new Finance();

      $description = $_POST['description'] ?? null;
      $value       = $_POST['value'] ?? null;
      $date        = $_POST['date'] ?? null;
      $category    = $_POST['category'] ?? null;

      $finance = new Finance();

      $values = [
        'description' => $description,
        'value'       => $value,
        'date'        => $date,
        'category'    => $category,
      ];


      $financeUpdate = $finance->edit($values, $request->parameter);
      debug($financeUpdate);

      $_SESSION['edit'] = true;
      $_SESSION['message'] = 'Registro alterado com sucesso!';
      header('Location: /finance');
    }
  }

  public function delete($request)
  {
    if (!$_SESSION['userId']) header('Location: /user/login');

    $finance = new Finance();
    $deleteFinance = $finance->delete($request->parameter);

    if ($deleteFinance) {
      $_SESSION['success'] = true;
      $_SESSION['message'] = 'Registro deletado com sucesso!';

      header('Location: /finance');
    }
  }
}

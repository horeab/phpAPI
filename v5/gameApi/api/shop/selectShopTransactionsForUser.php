<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeShopTransaction.php';
// echo json_encode($shopTransactionService->selectShopTransactionsForUser($_GET['userExternalId'], $_GET['accountCreationSource']));
echo json_encode($shopTransactionService->selectShopTransactionsForUser($data->userId));
?>
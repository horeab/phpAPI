<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeShopTransaction.php';
$shopTransactionService->createShopTransaction($data->userId, $data->transactionDate, $data->experienceGain, $data->coinsAmount, $data->transactionType);
?>
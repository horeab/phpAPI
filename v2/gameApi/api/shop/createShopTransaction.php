<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeShopTransaction.php';
$shopTransactionService->createShopTransaction($data->userId, $data->transactionDate, $data->experienceGain, $data->coinsAmount, $data->transactionType);
?>
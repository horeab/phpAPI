<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeShopTransaction.php';
// echo json_encode($shopTransactionService->selectShopTransactionsForUser($_GET['userExternalId'], $_GET['accountCreationSource']));
echo json_encode($shopTransactionService->selectShopTransactionsForUser($data->userId));
?>
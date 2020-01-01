<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/postHeaderWithJsonData.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/shopTransactionService.php';
// $shopTransactionService = new ShopTransactionService($_GET['gameId']);
$shopTransactionService = new ShopTransactionService();
?>
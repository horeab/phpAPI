<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUserInventory.php';
$userInventoryService->incrementColumnValueForUserId($data->userId, $data->columnName, $data->valueToIncrement);
?>
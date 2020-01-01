<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUserInventory.php';
$userInventoryService->updateColumnValueForUserId($data->userId, $data->columnName, $data->columnValue);
?>
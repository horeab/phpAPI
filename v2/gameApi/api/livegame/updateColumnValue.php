<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGameService->updateColumnValue($data->entityId, $data->columnName, $data->columnValue);
?>
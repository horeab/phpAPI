<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGameService->incrementColumnValue($data->entityId, $data->columnName);
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGameService->updateColumnValue($data->liveGameId, $data->gameInfoColumnName, $data->gameInfo);
$liveGameService->updateColumnValue($data->liveGameId, $data->gameInfoVersionColumnName, $data->gameInfoVersion);
?>
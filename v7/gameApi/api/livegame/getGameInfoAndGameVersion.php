<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeLiveGames.php';

$val1 = $liveGameService->getColumnValue($data->liveGameId, $data->gameInfoColumnName);
$val2 = $liveGameService->getColumnValue($data->liveGameId, $data->gameInfoVersionColumnName);

print_r($val1 . ":::" . $val2);
?>
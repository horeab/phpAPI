<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGameService->createLiveGame($data->user1Id, $data->user2Id, $data->question, $data->gameConfig, $data->initialUserStatus);
?>
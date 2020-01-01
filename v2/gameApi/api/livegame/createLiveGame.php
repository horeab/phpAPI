<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGameService->createLiveGame($data->user1Id, $data->user2Id, $data->gameConfig, $data->initialUserStatus);
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUserGames.php';
$userGamesService->createUserGame($data->user1Id, $data->user2Id, $data->entityCreationDate);
?>
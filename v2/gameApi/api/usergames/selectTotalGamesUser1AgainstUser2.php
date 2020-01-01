<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUserGames.php';
echo $userGamesService->selectTotalGamesUser1AgainstUser2($data->user1Id, $data->user2Id)?>
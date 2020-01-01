<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUserGames.php';
echo $userGamesService->selectTotalGamesUser1AgainstUser2($data->user1Id, $data->user2Id)?>
<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUserGames.php';
$userGamesService->createUserGame($data->user1Id, $data->user2Id, $data->entityCreationDate);
?>
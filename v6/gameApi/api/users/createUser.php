<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUser.php';

echo $userService->create($data->externalId, $data->fullName, $data->accountCreationSource, $data->lastTimeActiveDate, $data->entityCreationDate, $data->gameId);
?>
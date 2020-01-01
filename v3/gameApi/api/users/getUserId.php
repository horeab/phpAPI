<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUser.php';
echo $userService->getUserId($data->externalId, $data->accountCreationSource, $data->gameId);
?>
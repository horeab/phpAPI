<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUser.php';

$userService->create($data->externalId, $data->fullName, $data->accountCreationSource, $data->lastTimeActiveDate, $data->entityCreationDate, $data->gameId);
?>
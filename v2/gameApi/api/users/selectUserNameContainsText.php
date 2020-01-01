<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUser.php';
echo json_encode($userService->selectUserNameContainsText($data->gameId, $data->text));
?>
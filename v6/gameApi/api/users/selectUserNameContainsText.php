<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUser.php';
echo json_encode($userService->selectUserNameContainsText($data->gameId, $data->text));
?>
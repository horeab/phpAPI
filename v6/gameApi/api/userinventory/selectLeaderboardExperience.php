<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUserInventory.php';
echo json_encode($userInventoryService->selectLeaderboardExperience($data->userId, $data->gameId));
?>
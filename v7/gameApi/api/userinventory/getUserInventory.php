<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUserInventory.php';
$userInventory = $userInventoryService->getUserInventory($data->userId);
$userInventory_arr = array(
    "id" => $userInventory->id,
    "userId" => $userInventory->userId,
    "coins" => $userInventory->coins,
    "diamond" => $userInventory->diamond,
    "experience" => $userInventory->experience
);

print_r(json_encode($userInventory_arr));
?>
<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeUserInventory.php';
$userInventory = $userInventoryService->getUserInventory($data->userId);
$userInventory_arr = array(
    "id" => $userInventory->id,
    "userId" => $userInventory->userId,
    "coins" => $userInventory->coins,
    "diamond0" => $userInventory->diamond0,
    "diamond1" => $userInventory->diamond1,
    "diamond2" => $userInventory->diamond2,
    "diamond3" => $userInventory->diamond3,
    "experience" => $userInventory->experience
);

print_r(json_encode($userInventory_arr));
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUserInventory.php';
$userInventory = $userInventoryService->getUserInventory($data->userId);
$userInventory_arr = array(
    "id" => $userInventory->id,
    "userId" => $userInventory->userId,
    "coins" => $userInventory->coins,
    "diamond0" => $userInventory->diamond0,
    "diamond1" => $userInventory->diamond1,
    "diamond2" => $userInventory->diamond2
);

print_r(json_encode($userInventory_arr));
?>
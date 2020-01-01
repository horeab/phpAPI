<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeUser.php';
// $user = $userService->getUser($_GET['externalId'], $_GET['accountCreationSource'], $_GET['gameId']);
if (isset($data->userId)) {
    $user = $userService->getUserForId($data->userId);
} else {
    $user = $userService->getUser($data->externalId, $data->accountCreationSource, $data->gameId);
}
$user_arr = array(
    "id" => $user->id,
    "entityCreationDate" => $user->entityCreationDate,
    "externalId" => $user->externalId,
    "accountCreationSource" => $user->accountCreationSource,
    "fullName" => $user->fullName,
    "gameId" => $user->gameId,
    "lastTimeActiveDate" => $user->lastTimeActiveDate
);

print_r(json_encode($user_arr));
?>
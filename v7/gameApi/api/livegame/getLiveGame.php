<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGame = $liveGameService->getLiveGame($data->user1Id, $data->user2Id);
$liveGame_arr = array(
    "id" => $liveGame->id,
    "user1Id" => $liveGame->user1Id,
    "user2Id" => $liveGame->user2Id,
    "user1Status" => $liveGame->user1Status,
    "user2Status" => $liveGame->user2Status,
    "user1GameInfo" => $liveGame->user1GameInfo,
    "user2GameInfo" => $liveGame->user2GameInfo,
    "user1GameInfoVersion" => $liveGame->user1GameInfoVersion,
    "user2GameInfoVersion" => $liveGame->user2GameInfoVersion,
    "user1ActiveVersion" => $liveGame->user1ActiveVersion,
    "user2ActiveVersion" => $liveGame->user2ActiveVersion,
    "user1HasUser2GameInfoVersion" => $liveGame->user1HasUser2GameInfoVersion,
    "user2HasUser1GameInfoVersion" => $liveGame->user2HasUser1GameInfoVersion,
    "user1HasUser1GameInfoVersion" => $liveGame->user1HasUser1GameInfoVersion,
    "user2HasUser2GameInfoVersion" => $liveGame->user2HasUser2GameInfoVersion,
    "questions" => $liveGame->questions,
    "gameConfig" => $liveGame->gameConfig
);

print_r(json_encode($liveGame_arr));
?>
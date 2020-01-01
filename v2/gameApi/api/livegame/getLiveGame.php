<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeLiveGames.php';
$liveGame = $liveGameService->getLiveGame($data->user1Id, $data->user2Id);
$liveGame_arr = array(
    "id" => $liveGame->id,
    "user1Id" => $liveGame->user1Id,
    "user2Id" => $liveGame->user2Id,
    "user1Status" => $liveGame->user1Status,
    "user2Status" => $liveGame->user2Status,
    "user1GameInfo" => $liveGame->user1GameInfo,
    "user2GameInfo" => $liveGame->user2GameInfo,
    "user1GameInfoChange" => $liveGame->user1GameInfoChange,
    "user2GameInfoChange" => $liveGame->user2GameInfoChange,
    "user1ActiveChange" => $liveGame->user1ActiveChange,
    "user2ActiveChange" => $liveGame->user2ActiveChange,
    "questionId" => $liveGame->questionId,
    "gameConfig" => $liveGame->gameConfig
);

print_r(json_encode($liveGame_arr));
?>
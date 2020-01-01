<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeGameStats.php';
$gameStats = $gameStatsService->getGameStats($data->userId);
$gameStats_arr = array(
    "id" => $gameStats->id,
    "userId" => $gameStats->userId,
    "tournamentsStarted" => $gameStats->tournamentsStarted,
    "tournamentsWon" => $gameStats->tournamentsWon,
    "questionsStarted" => $gameStats->questionsStarted,
    "questionsWon" => $gameStats->questionsWon
);

print_r(json_encode($gameStats_arr));
?>
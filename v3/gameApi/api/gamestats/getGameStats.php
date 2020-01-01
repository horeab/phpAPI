<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeGameStats.php';
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
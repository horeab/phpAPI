<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeGameStats.php';
echo json_encode($gameStatsService->selectLeaderboardTournamentsWon($data->gameId));
?>
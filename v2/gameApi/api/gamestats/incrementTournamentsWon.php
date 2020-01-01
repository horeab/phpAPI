<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/serviceIncludeGameStats.php';
$gameStatsService->incrementGameStatsTournamentsWon($data->userId);
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/util/include/postHeaderWithJsonData.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/testService.php';
if (isset($data->test) && strcmp($data->test, "test123") == 0) {
    $testService = new TestService();
    $testService->clearAllTables();
}
?>
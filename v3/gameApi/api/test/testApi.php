<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/postHeaderWithJsonData.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/testService.php';
if (isset($data->test) && strcmp($data->test, "test123") == 0) {
    $testService = new TestService();
    $testService->clearAllTables();
}
?>
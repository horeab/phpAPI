<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeCampaign.php';
$campaignService->createCampaignLevel($data->userId, $data->level, $data->entityCreationDate);
?>
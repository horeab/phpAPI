<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/util/include/serviceIncludeCampaign.php';
echo json_encode($campaignService->getAllCampaignLevels($data->userId));
?>
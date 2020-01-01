<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/model/user.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/gameStatsService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/liveGameService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/shopTransactionService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/userGamesService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/userInventoryService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/campaignService.php';

class UserService extends AbstractService
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTableName()
    {
        return "users";
    }

    function selectUsersForTournament($gameId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE gameId = :gameId AND accountCreationSource <> 'INTERNAL'  ORDER BY RAND() LIMIT 8";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":gameId", $gameId);
        $stmt->execute();
        $num = $stmt->rowCount();
        $users_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user_item = array(
                    "id" => $id,
                    "entityCreationDate" => $entityCreationDate,
                    "fullName" => $fullName,
                    "externalId" => $externalId,
                    "accountCreationSource" => $accountCreationSource,
                    "lastTimeActiveDate" => $lastTimeActiveDate
                );
                array_push($users_arr, $user_item);
            }
        }
        return $users_arr;
    }

    function selectUserNameContainsText($gameId, $text)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE LOWER(fullName) LIKE '%" . $text . "%' AND gameId = :gameId ORDER BY fullName LIMIT 5 ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":gameId", $gameId);
        $stmt->execute();
        $num = $stmt->rowCount();
        $users_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user_item = array(
                    "id" => $id,
                    "entityCreationDate" => $entityCreationDate,
                    "fullName" => $fullName,
                    "externalId" => $externalId,
                    "accountCreationSource" => $accountCreationSource,
                    "lastTimeActiveDate" => $lastTimeActiveDate
                );
                array_push($users_arr, $user_item);
            }
        }
        return $users_arr;
    }

    function getUserForId($userId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $user = new User();
        $user->id = $row['id'];
        $user->entityCreationDate = $row['entityCreationDate'];
        $user->externalId = $row['externalId'];
        $user->accountCreationSource = $row['accountCreationSource'];
        $user->fullName = $row['fullName'];
        $user->gameId = $row['gameId'];
        $user->lastTimeActiveDate = $row['lastTimeActiveDate'];
        
        return $user;
    }

    function getUser($externalId, $accountCreationSource, $gameId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE externalId = ? AND accountCreationSource = ? AND gameId = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $externalId);
        $stmt->bindParam(2, $accountCreationSource);
        $stmt->bindParam(3, $gameId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $user = new User();
        $user->id = $row['id'];
        $user->entityCreationDate = $row['entityCreationDate'];
        $user->externalId = $row['externalId'];
        $user->accountCreationSource = $row['accountCreationSource'];
        $user->fullName = $row['fullName'];
        $user->gameId = $row['gameId'];
        $user->lastTimeActiveDate = $row['lastTimeActiveDate'];
        
        return $user;
    }

    function getUserId($externalId, $accountCreationSource, $gameId)
    {
        $query = "SELECT id FROM " . $this->getTableName() . " WHERE externalId = ? AND accountCreationSource = ? AND gameId = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $externalId);
        $stmt->bindParam(2, $accountCreationSource);
        $stmt->bindParam(3, $gameId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row['id']);
    }

    function create($externalId, $fullName, $accountCreationSource, $lastTimeActiveDate, $entityCreationDate, $gameId)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (externalId, fullName, accountCreationSource, lastTimeActiveDate, entityCreationDate, gameId) 
                  VALUES (:externalId, :fullName, :accountCreationSource, :lastTimeActiveDate, :entityCreationDate, :gameId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":externalId", $externalId);
        $stmt->bindParam(":fullName", $fullName);
        $stmt->bindParam(":accountCreationSource", $accountCreationSource);
        $stmt->bindParam(":lastTimeActiveDate", $lastTimeActiveDate);
        $stmt->bindParam(":entityCreationDate", $entityCreationDate);
        $stmt->bindParam(":gameId", $gameId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteEntity($entityId)
    {
        $gameStatsService = new GameStatsService();
        $liveGameService = new LiveGameService();
        $shopTransactionService = new ShopTransactionService();
        $userGamesService = new UserGamesService();
        $userInventoryService = new UserInventoryService();
        $campaignService = new CampaignService();
        
        $gameStatsService->deleteForUserId($entityId);
        $liveGameService->deleteForUserId($entityId);
        $shopTransactionService->deleteForUserId($entityId);
        $userGamesService->deleteForUserId($entityId);
        $userInventoryService->deleteForUserId($entityId);
        $campaignService->deleteForUserId($entityId);
        parent::deleteEntity($entityId);
        return false;
    }
}
?>
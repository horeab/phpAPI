<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/model/userInventory.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/gameStatsService.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/userService.php';

class UserInventoryService extends AbstractService
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTableName()
    {
        return "userinventory";
    }
    
    function selectLeaderboardExperience($currentUserId, $gameId)
    {
        $userService = new UserService();
        $gameStatsService = new GameStatsService();
        
        $userinventoryTableName = $this->getTableName();
        $userTableName = $userService->getTableName();
        $query = "SELECT * FROM " . $userinventoryTableName . " INNER JOIN " . $userTableName . " ON " . $userinventoryTableName . ".userId = " . $userTableName . ".id AND
                 " . $userTableName . ".gameId = :gameId ORDER BY " . $userinventoryTableName . ".experience DESC, " . $userTableName . ".id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":gameId", $gameId);
        $stmt->execute();
        $num = $stmt->rowCount();
        $userinventory_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user_item = array(
                    "id" => $userId,
                    "entityCreationDate" => $entityCreationDate,
                    "fullName" => $fullName,
                    "externalId" => $externalId,
                    "accountCreationSource" => $accountCreationSource,
                    "lastTimeActiveDate" => $lastTimeActiveDate
                );
                $userinventory_item = array(
                    "user" => $user_item,
                    "userId" => $userId,
                    "experience" => $experience
                );
                array_push($userinventory_arr, $userinventory_item);
            }
        }
        return $gameStatsService->getTopSixUsers($currentUserId, $userinventory_arr);
    }

    function createUserInventory($userId)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (userId, coins, diamond, experience)
                  VALUES (:userId, 0, 0, 0)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function getUserInventory($userId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $userInventory = new UserInventory();
        $userInventory->id = $row['id'];
        $userInventory->userId = $row['userId'];
        $userInventory->coins = $row['coins'];
        $userInventory->diamond = $row['diamond'];
        $userInventory->experience = $row['experience'];
        
        return $userInventory;
    }

    function incrementColumnValueForUserId($userId, $columnName, $valueToIncrement)
    {
        $query = "UPDATE " . $this->getTableName() . " SET " . $columnName . " = " . $columnName . " + " . $valueToIncrement . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
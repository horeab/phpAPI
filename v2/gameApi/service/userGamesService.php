<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/userService.php';

class UserGamesService extends AbstractService
{

    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    function getTableName()
    {
        return "usergames";
    }

    function createUserGame($user1Id, $user2Id, $entityCreationDate)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (user1Id, user2Id, entityCreationDate) VALUES (:user1Id, :user2Id, :entityCreationDate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user1Id", $user1Id);
        $stmt->bindParam(":user2Id", $user2Id);
        $stmt->bindParam(":entityCreationDate", $entityCreationDate);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function selectTotalGamesUser1AgainstUser2($user1Id, $user2Id)
    {
        $query = "SELECT COUNT(1) AS totalWins FROM " . $this->getTableName() . " WHERE user1Id = :user1Id AND user2Id = :user2Id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user1Id", $user1Id);
        $stmt->bindParam(":user2Id", $user2Id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row['totalWins']);
    }

    function deleteForUserId($userId)
    {
        $query = "DELETE FROM " . $this->getTableName() . " WHERE user1Id = :userId OR user2Id = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
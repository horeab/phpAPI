<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/model/userInventory.php';

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

    function createUserInventory($userId)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (userId, coins, diamond0, diamond1, diamond2)
                  VALUES (:userId, 0, 0, 0, 0)";
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
        $userInventory->diamond0 = $row['diamond0'];
        $userInventory->diamond1 = $row['diamond1'];
        $userInventory->diamond2 = $row['diamond2'];
        
        return $userInventory;
    }

    function getColumnValueForUserId($userId, $columnName)
    {
        $query = "SELECT " . $columnName . " FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row[$columnName]);
    }

    function updateColumnValueForUserId($userId, $columnName, $columnValue)
    {
        $query = "UPDATE " . $this->getTableName() . " SET " . $columnName . " = :columnValue WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":columnValue", $columnValue);
        if ($stmt->execute()) {
            return true;
        }
        return false;
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
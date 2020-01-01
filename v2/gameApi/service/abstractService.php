<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/config/database.php';

abstract class AbstractService
{

    protected $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    abstract function getTableName();

    function incrementColumnValue($entityId, $columnName)
    {
        $query = "UPDATE " . $this->getTableName() . " SET " . $columnName . " = " . $columnName . " + 1 WHERE id = :entityId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":entityId", $entityId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getColumnValue($entityId, $columnName)
    {
        $query = "SELECT " . $columnName . " FROM " . $this->getTableName() . " WHERE id = :entityId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":entityId", $entityId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row[$columnName]);
    }

    function updateColumnValue($entityId, $columnName, $columnValue)
    {
        $query = "UPDATE " . $this->getTableName() . " SET " . $columnName . " = :columnValue WHERE id = :entityId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":entityId", $entityId);
        $stmt->bindParam(":columnValue", $columnValue);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteEntity($entityId)
    {
        $query = "DELETE FROM " . $this->getTableName() . " WHERE id = :entityId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":entityId", $entityId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';

class CampaignService extends AbstractService
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTableName()
    {
        return "campaign";
    }

    function createCampaignLevel($userId, $level, $entityCreationDate)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (userId, level, questionAnswered, status, entityCreationDate)
                  VALUES (:userId, :level, 0, 0, :entityCreationDate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":level", $level);
        $stmt->bindParam(":entityCreationDate", $entityCreationDate);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function getAllCampaignLevels($userId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        $num = $stmt->rowCount();
        $level_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $level_item = array(
                    "userId" => $userId,
                    "level" => $level,
                    "questionAnswered" => $questionAnswered,
                    "status" => $status
                );
                array_push($level_arr, $level_item);
            }
        }
        return $level_arr;
    }

    function getColumnValueForUserIdAndLevel($userId, $level, $columnName)
    {
        $query = "SELECT " . $columnName . " FROM " . $this->getTableName() . " WHERE userId = :userId AND level = :level";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":level", $level);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row[$columnName]);
    }

    function updateColumnValueForUserIdAndLevel($userId, $level, $columnName, $columnValue)
    {
        $query = "UPDATE " . $this->getTableName() . " SET " . $columnName . " = :columnValue WHERE userId = :userId AND level = :level";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":level", $level);
        $stmt->bindParam(":columnValue", $columnValue);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
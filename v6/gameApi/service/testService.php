<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';

class TestService extends AbstractService
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTableName()
    {
        return "xxx";
    }

    function executeScript()
    {
        for ($i = 1; $i <= 10; $i ++) {
            $query = "update userinventory set experience =
                      (SELECT SUM(experienceGain) AS totalExperienceGain FROM shoptransactions WHERE userId = " . $i . ")
                      where userId = " . $i;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }
    }

    function clearAllTables()
    {
        $query = "DELETE FROM campaign";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "DELETE FROM userinventory";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "DELETE FROM livegames";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "DELETE FROM shoptransactions";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "DELETE FROM usergames";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "DELETE FROM gamestats";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "DELETE FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}
?>
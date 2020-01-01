<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/abstractService.php';

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

    function clearAllTables()
    {
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
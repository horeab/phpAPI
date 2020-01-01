<?php
 require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';

class ConstantsService extends AbstractService
{

    public function __construct()
    {
        parent::__construct();
    }

    function getTableName()
    {
        return "constants";
    }
    
    function getValue($keyname)
    {
        $query = "SELECT value FROM " . $this->getTableName() . " WHERE keyname = :keyname";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":keyname", $keyname);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row['value']);
    }
    
    
    function getAllConstants()
    {
        $query = "SELECT * FROM " . $this->getTableName() . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        $constants_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $constant_item = array(
                    "keyname" => $keyname,
                    "value" => $value
                );
                array_push($constants_arr, $constant_item);
            }
        }
        return $constants_arr;
    }
}
?>
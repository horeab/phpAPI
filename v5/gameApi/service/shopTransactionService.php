<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/userService.php';

class ShopTransactionService extends AbstractService
{

    private $userService;

    public function __construct()
    {
        parent::__construct();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/model/shopTransaction.php';
        $this->userService = new UserService();
    }

    function getTableName()
    {
        return "shoptransactions";
    }

    function createShopTransaction($userId, $transactionDate, $experienceGain, $coinsAmount, $transactionType)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (userId, transactionDate, coinsAmount, experienceGain, transactionType)
                  VALUES (:userId, :transactionDate, :coinsAmount, :experienceGain, :transactionType)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":transactionDate", $transactionDate);
        $stmt->bindParam(":experienceGain", $experienceGain);
        $stmt->bindParam(":coinsAmount", $coinsAmount);
        $stmt->bindParam(":transactionType", $transactionType);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function selectTotalExperienceGainForUser($userId)
    {
        $query = "SELECT SUM(experienceGain) AS totalExperienceGain FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row['totalExperienceGain']);
    }

    function selectTotalCoinsAmountForUser($userId, $transactionTypeList)
    {
        $query = "SELECT SUM(coinsAmount) AS totalCoinsAmount FROM " . $this->getTableName() . "  WHERE userId = :userId";
        $transactionTypeArray = json_decode(json_encode($transactionTypeList), true);
        if (! empty($transactionTypeArray)) {
            foreach ($transactionTypeArray as &$value) {
                $value = "'" . $value . "'";
            }
            $query = $query . " AND transactionType IN (" . implode(",", $transactionTypeArray) . ")";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row['totalCoinsAmount']);
    }

    function selectTotalAmountShopTransactionType($userId, $transactionTypeList)
    {
        $query = "SELECT COUNT(1) AS totalAmountShopTransactionType FROM " . $this->getTableName() . "  WHERE userId = :userId";
        $transactionTypeArray = json_decode(json_encode($transactionTypeList), true);
        foreach ($transactionTypeArray as &$value) {
            $value = "'" . $value . "'";
        }
        $query = $query . " AND transactionType IN (" . implode(",", $transactionTypeArray) . ")";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($row['totalAmountShopTransactionType']);
    }

    function selectShopTransactionsForUser($userId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        $num = $stmt->rowCount();
        $shoptransactions_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $shoptransaction_item = array(
                    "id" => $id,
                    "userId" => $userId,
                    "transactionDate" => $transactionDate,
                    "coinsAmount" => $coinsAmount,
                    "experienceGain" => $experienceGain,
                    "transactionType" => $transactionType
                );
                array_push($shoptransactions_arr, $shoptransaction_item);
            }
        }
        return $shoptransactions_arr;
    }

}
?>
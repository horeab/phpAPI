<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/userService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/model/liveGame.php';

class LiveGameService extends AbstractService
{

    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    function getTableName()
    {
        return "livegames";
    }

    function createLiveGame($user1Id, $user2Id, $questions, $gameConfig, $initialUserStatus)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (user1Id, user2Id, user1Status, user2Status, questions, gameConfig)
                  VALUES (:user1Id, :user2Id, :user1Status, :user2Status, :questions, :gameConfig)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user1Id", $user1Id);
        $stmt->bindParam(":user2Id", $user2Id);
        $stmt->bindParam(":user1Status", $initialUserStatus);
        $stmt->bindParam(":user2Status", $initialUserStatus);
        $stmt->bindParam(":questions", $questions);
        $stmt->bindParam(":gameConfig", $gameConfig);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function getLiveGame($user1Id, $user2Id)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE user1Id = ? AND user2Id = ? ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user1Id);
        $stmt->bindParam(2, $user2Id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $liveGame = new LiveGame();
        $liveGame->id = $row['id'];
        $liveGame->user1Id = $row['user1Id'];
        $liveGame->user2Id = $row['user2Id'];
        $liveGame->user1Status = $row['user1Status'];
        $liveGame->user2Status = $row['user2Status'];
        $liveGame->user1GameInfo = $row['user1GameInfo'];
        $liveGame->user2GameInfo = $row['user2GameInfo'];
        $liveGame->user1GameInfoVersion = $row['user1GameInfoVersion'];
        $liveGame->user2GameInfoVersion = $row['user2GameInfoVersion'];
        $liveGame->user1ActiveVersion = $row['user1ActiveVersion'];
        $liveGame->user2ActiveVersion = $row['user2ActiveVersion'];
        $liveGame->user1HasUser2GameInfoVersion = $row['user1HasUser2GameInfoVersion'];
        $liveGame->user2HasUser1GameInfoVersion = $row['user2HasUser1GameInfoVersion'];
        $liveGame->user1HasUser1GameInfoVersion = $row['user1HasUser1GameInfoVersion'];
        $liveGame->user2HasUser2GameInfoVersion = $row['user2HasUser2GameInfoVersion'];
        $liveGame->questions = $row['questions'];
        $liveGame->gameConfig = $row['gameConfig'];
        
        return $liveGame;
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
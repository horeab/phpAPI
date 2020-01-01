<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gameApiVersion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/service/userService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . Constants::$GAMEAPIVERSION . '/gameApi/model/gameStats.php';

class GameStatsService extends AbstractService
{

    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    function getTableName()
    {
        return "gamestats";
    }

    function getGameStats($userId)
    {
        $query = "SELECT * FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $gameStats = new GameStats();
        $gameStats->id = $row['id'];
        $gameStats->userId = $row['userId'];
        $gameStats->tournamentsStarted = $row['tournamentsStarted'];
        $gameStats->tournamentsWon = $row['tournamentsWon'];
        $gameStats->questionsStarted = $row['questionsStarted'];
        $gameStats->questionsWon = $row['questionsWon'];
        
        return $gameStats;
    }

    function selectLeaderboardTournamentsWon($gameId)
    {
        $gameStatsTableName = $this->getTableName();
        $userTableName = $this->userService->getTableName();
        $query = "SELECT * FROM " . $gameStatsTableName . " INNER JOIN " . $userTableName . " ON " . $gameStatsTableName . ".userId = " . $userTableName . ".id AND
                 " . $userTableName . ".gameId = :gameId ORDER BY " . $gameStatsTableName . ".tournamentsWon DESC, " . $userTableName . ".id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":gameId", $gameId);
        $stmt->execute();
        $num = $stmt->rowCount();
        $gameStats_arr = array();
        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $gameStats_item = array(
                    "id" => $id,
                    "userId" => $userId,
                    "tournamentsStarted" => $tournamentsStarted,
                    "tournamentsWon" => $tournamentsWon,
                    "questionsStarted" => $questionsStarted,
                    "questionsWon" => $questionsWon
                );
                array_push($gameStats_arr, $gameStats_item);
            }
        }
        return $gameStats_arr;
    }

    function createGameStats($userId)
    {
        $query = "INSERT INTO " . $this->getTableName() . " (userId, tournamentsStarted, tournamentsWon, questionsStarted, questionsWon)
                  VALUES (:userId, 0, 0, 0, 0)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function deleteForUserId($userId)
    {
        $query = "DELETE FROM " . $this->getTableName() . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function incrementGameStatsTournamentsStarted($userId)
    {
        $this->executeIncrementStatsStatement($userId, "tournamentsStarted");
    }

    function incrementGameStatsTournamentsWon($userId)
    {
        $this->executeIncrementStatsStatement($userId, "tournamentsWon");
    }

    function incrementGameStatsQuestionsStarted($userId)
    {
        $this->executeIncrementStatsStatement($userId, "questionsStarted");
    }

    function incrementGameStatsQuestionsWon($userId)
    {
        $this->executeIncrementStatsStatement($userId, "questionsWon");
    }

    function executeIncrementStatsStatement($userId, $gameStatsColumnName)
    {
        $query = "UPDATE " . $this->getTableName() . " SET " . $gameStatsColumnName . " = " . $gameStatsColumnName . " + 1 WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":userId", $userId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
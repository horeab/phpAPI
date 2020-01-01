<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/abstractService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/service/userService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . json_decode(file_get_contents("php://input"))->apiVersion . '/gameApi/model/gameStats.php';

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

    function selectLeaderboardTournamentsWon($currentUserId, $gameId)
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
                $user_item = array(
                    "id" => $userId,
                    "entityCreationDate" => $entityCreationDate,
                    "fullName" => $fullName,
                    "externalId" => $externalId,
                    "accountCreationSource" => $accountCreationSource,
                    "lastTimeActiveDate" => $lastTimeActiveDate
                );
                $gameStats_item = array(
                    "user" => $user_item,
                    "userId" => $userId,
                    "tournamentsStarted" => $tournamentsStarted,
                    "tournamentsStarted" => $tournamentsStarted,
                    "tournamentsWon" => $tournamentsWon,
                    "questionsStarted" => $questionsStarted,
                    "questionsWon" => $questionsWon
                );
                array_push($gameStats_arr, $gameStats_item);
            }
        }
        return $this->getTopSixUsers($currentUserId, $gameStats_arr);
    }

    function getTopSixUsers($userId, $gameStats_arr)
    {
        $sixUsers_arr = array();
        $rank = 0;
        $nrOfUsersToDisplay = 6;
        $currentUserRank = 0;
        foreach ($gameStats_arr as $item) {
            $user = $item["user"];
            if ($user["id"] == $userId) {
                break;
            }
            $currentUserRank ++;
        }
        $maxRank = $currentUserRank < $nrOfUsersToDisplay ? $nrOfUsersToDisplay : $nrOfUsersToDisplay / 2;
        foreach ($gameStats_arr as $item) {
            if ($rank < $maxRank) {
                $item["rank"] = $rank + 1;
                array_push($sixUsers_arr, $item);
            } else {
                break;
            }
            $rank ++;
        }
        
        if (count($sixUsers_arr) < $nrOfUsersToDisplay) {
            $firstUserIndex = $currentUserRank - 1;
            $secondUserIndex = $currentUserRank;
            $thirdUserIndex = $currentUserRank + 1;
            if ($currentUserRank == count($gameStats_arr) - 1) {
                $firstUserIndex = $currentUserRank - 2;
                $secondUserIndex = $currentUserRank - 1;
                $thirdUserIndex = $currentUserRank;
            }
            $rank = 0;
            foreach ($gameStats_arr as $item) {
                if ($rank == $firstUserIndex || $rank == $secondUserIndex || $rank == $thirdUserIndex) {
                    $item["rank"] = $rank + 1;
                    array_push($sixUsers_arr, $item);
                }
                // there is an extra entry, because there is an empty dots dots item ...
                if (count($sixUsers_arr) == $nrOfUsersToDisplay) {
                    break;
                }
                $rank ++;
            }
        }
        return $sixUsers_arr;
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
<?php
class ControllerWeb{

    public static function getGameById($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT * FROM Pieces JOIN Turn ON Pieces.CurrentGameID = Turn.GameID
                        JOIN Game_User ON Game_User.GameID = Turn.GameID
                        Join Game ON Game.GameID = Game_User.GameID WHERE CurrentGameID = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $Everything = $stmt->fetchall(PDO::FETCH_ASSOC);

	    if ($Everything) {
		    echo json_encode($Everything);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getCurrentGameIdByUserId($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT GameID FROM Game_User WHERE UserID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $response = $stmt->fetch(PDO::FETCH_ASSOC);

	        if ($response) {
		        echo json_encode($response);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getLastMoveByGameId($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT * FROM Turn WHERE GameID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $Everything = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($Everything) {
		    echo json_encode($Everything);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getLastTwoMovesByGameId($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT * FROM Turn WHERE GameID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $Everything = $stmt->fetchAll(PDO::FETCH_ASSOC);

	    if ($Everything) {
		    echo json_encode($Everything);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function postPieceById($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT PieceNumber, InitialPosition, Type, State, CurrentPosition FROM Pieces WHERE CurrentGameID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $Pieces = $stmt->fetch(PDO::FETCH_ASSOC);

            $query = 'SELECT TurnNumber, Move, MoveLegality, GameID FROM Turn WHERE GameID = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $Turn = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($Pieces) {
		    echo json_encode($Pieces);  // Return the activity data as JSON
		    echo json_encode($Turn);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } // TODO: TODO

    public static function postTurnById($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT PieceNumber, InitialPosition, Type, State, CurrentPosition FROM Pieces WHERE CurrentGameID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $Pieces = $stmt->fetch(PDO::FETCH_ASSOC);

            $query = 'SELECT TurnNumber, Move, MoveLegality, GameID FROM Turn WHERE GameID = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $Turn = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($Pieces) {
		    echo json_encode($Pieces);  // Return the activity data as JSON
		    echo json_encode($Turn);
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } // TODO: TODO

}

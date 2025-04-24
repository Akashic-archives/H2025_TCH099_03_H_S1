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

    public static function postPiece(){
        global $pdo;

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['PieceID']) || !isset($data['PieceNumber']) || !isset($data['InitialPosition']) || !isset($data['Type']) 
            || !isset($data['State']) || !isset($data['CurrentPosition']) || !isset($data['CurrentGameID'])) {
            echo json_encode(["error" => "incomplete"]);
            http_response_code(400);
            return;
        }
        try {
        $stmt = $pdo->prepare("INSERT INTO Pieces (PieceID, PieceNumber, InitialPosition, 'Type', 'State', CurrentPosition, 
        CurrentGameID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['PieceID'], $data['PieceNumber'], $data['InitialPosition'], $data['Type'], $data['State'], 
        $data['CurrentPosition'], $data['CurrentGameID']]);
        echo json_encode(['success' => true, 'message' => 'posted']);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            http_response_code(500);
        }
    }

    public static function postTurn(){
        global $pdo;

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['TurnNumber']) || !isset($data['Move']) || !isset($data['MoveLegality']) || !isset($data['GameID'])) {
            echo json_encode(["error" => "incomplete"]);
            http_response_code(400);
            return;
        }
        try {
        $stmt = $pdo->prepare("INSERT INTO Turn (TurnNumber, 'Move', MoveLegality, GameID) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['TurnNumber'], $data['Move'], $data['InitialPosition'], $data['MoveLegality']]);
        echo json_encode(['success' => true, 'message' => 'posted']);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            http_response_code(500);
        }
    }

}

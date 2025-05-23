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
    }

    public static function getUsersInGame($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$id) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT * FROM GameUser 
            JOIN User ON GameUser.UserID = User.UserID 
            WHERE GameUser.GameID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $$User = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($User) {
		    echo json_encode($User);  // Return the activity data as JSON
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getCurrentTurn($gameId, $turnNum){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$gameId) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT * FROM Turn
            WHERE GameID = :id
            AND TurnNumber = :turnNum';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $gameId, PDO::PARAM_INT);
            $stmt->bindParam(':turnNum', $turnNum, PDO::PARAM_INT);

            $stmt->execute();

            $turn = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($turn) {
		    echo json_encode($turn);  // Return the activity data as JSON
            }
             else {
                echo json_encode(['error' => 'Game or turn not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getAllGames(){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            echo json_encode($pdo->query('SELECT * from Game')->fetchALL());

	
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function getUserByEmail($email){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        if(isset($email)){

            try {
                echo json_encode($pdo->query("SELECT * FROM User WHERE Email = '$email' ")->fetchALL());
            }
            catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
        else {
            echo json_encode(['error' => "There is no account set for this email"]);
        }
    }

    public static function getUserNameFromID($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        if(isset($id)){
            try {
                echo json_encode($pdo->query("SELECT UserName FROM User WHERE UserID = $id ")->fetchALL());
            }
            catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
        else {
            echo json_encode(['error' => "There is no account set for this ID"]);
        }
    }

    

    public static function getPlayersByGameUser($id){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        if(isset($id)){
            try {
                echo json_encode($pdo->query("SELECT Player_black, Player_white FROM Game_User 
                WHERE Player_white = $id OR Player_black = $id")->fetchALL());
            
            }
            catch(PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
        else {
            echo json_encode(['error' => "There is no ID set"]);
        }
    }


    public static function getCurrentGamePieces($gameId) {
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        try {

            if (!$gameId) {
                echo json_encode(['error' => 'Game ID is required']);
                return;
            }

            $query = 'SELECT * FROM Pieces
            WHERE CurrentGameID = :id';

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $gameId, PDO::PARAM_INT);

            $stmt->execute();

            $turn = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($turn) {
		    echo json_encode($turn);  // Return the activity data as JSON
            } else {
                echo json_encode(['error' => 'Game not found']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }



    public static function postGame(){

    }
    public static function postUser(){
        global $pdo;
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['UserName']) || !isset($data['Email']) || !isset($data['Password']) || !isset($data['Name']) || !isset($data['LastName'])) {
            echo json_encode("Incomplete");
            http_response_code(400);
            return;
        }

        $email = $data['Email'];
        $exist = json_encode($pdo->query("SELECT * FROM User WHERE Email = '$email' ")->fetchALL());
        if($exist != null){
            echo json_encode(["error" => "Exists"]);
        }
        else{
            try {
            $stmt = $pdo->prepare("INSERT INTO User (UserName, Email, Password, Name, LastName) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data['UserName'], $data['Email'], $data['Password'], $data['Name'], $data['LastName']]);

            $email = $data['Email'];
            echo json_encode($pdo->query("SELECT * FROM User WHERE Email = '$email' ")->fetchALL());

            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
                http_response_code(500);
        }
        }
        
    }
    public static function postGameUser(){
        global $pdo;
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['PlayerColor'], $data['GameID'], $data['UserID'])) {
            echo json_encode(["error" => "incomplete"]);
            http_response_code(400);
            return;
        }
        try {
            $stmt = $pdo->prepare("INSERT INTO Game_User (PlayerColor,GameID,UserID) VALUES (?,?,?)");
            $stmt->execute([$data['PlayerColor'],$data['GameID'],$data['UserID']]);
            echo json_encode(['success' => true, 'message' => 'posted']);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
                http_response_code(500);
        }
    }

//Keeps track of all of the moves of all the games
    public static function postTurn(){
        global $pdo;
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['Move'], $data['MoveLegality'], $data['GameID'])) {
            echo json_encode(["error" => "incomplete"]);
            http_response_code(400);
            return;
        }
        //Do I put GameID in the insert?
        try {
            $stmt = $pdo->prepare("INSERT INTO Turn (Move,MoveLegality,GameID) VALUES (?,?,?)");
            $stmt->execute([$data['Move'],$data['MoveLegality'],$data['GameID']]);
            echo json_encode(['success' => true, 'message' => 'posted']);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Database error: " . $e->getMessage()]);
                http_response_code(500);
        }
    }

    public static function postPiece(){
        global $pdo;
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['PieceID'], $data['PieceNumber'], $data['InitialPosition'], $data['Type'],$data['State'],$data['CurrentPosition'],$data['CurrentGameID'])) {
            echo json_encode(["error" => "incomplete"]);
            http_response_code(400);
            return;
        }
        try {
        $stmt = $pdo->prepare("INSERT INTO Pieces (PieceID, PieceNumber, InitialPosition, Type,State, CurrentPosition, CurrentGameID) VALUES (?, ?, ?, ?,?,?,?)");
        $stmt->execute([$data['PieceID'], $data['PieceNumber'], $data['InitialPosition'], $data['Type'],$data['State'],$data['CurrentPosition'],$data['CurrentGameID']]);
        echo json_encode(['success' => true, 'message' => 'posted']);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            http_response_code(500);
        }
    }
//Used to modify the information on every move
    public static function putPiece($id){
        global $pdo;
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['PieceID'], $data['PieceNumber'], $data['InitialPosition'], $data['Type'],$data['State'],$data['CurrentPosition'],$data['CurrentGameID'])) {
            echo json_encode(["error" => "incomplete"]);
            http_response_code(400);
            return;
        }
        try {
            $stmt = $pdo->prepare("UPDATE Pieces (PieceID, PieceNumber, InitialPosition, Type,State, CurrentPosition, CurrentGameID) VALUES (?, ?, ?, ?,?,?,?)");
            $stmt->execute([$data['PieceID'], $data['PieceNumber'], $data['InitialPosition'], $data['Type'],$data['State'],$data['CurrentPosition'],$data['CurrentGameID']]);
            echo json_encode(['success' => true, 'message' => 'Piece updated']);
        } catch (PDOException $e) {
            echo json_encode(["error" => "Database error: " . $e->getMessage()]);
            http_response_code(500);
        }
    }
}
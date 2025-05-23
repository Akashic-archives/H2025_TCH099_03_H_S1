<?php
class ControllerMobile{

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

}

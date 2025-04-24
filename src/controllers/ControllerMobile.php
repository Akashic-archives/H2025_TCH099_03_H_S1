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

}

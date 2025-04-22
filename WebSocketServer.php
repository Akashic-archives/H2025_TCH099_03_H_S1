<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Ratchet\ConnectionInterface;
use PDO;

require dirname(__DIR__) . '/vendor/autoload.php'; // Composer autoload

class WebSocketServer implements MessageComponentInterface {
    protected $clients;
    private $db;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        // Database connection (adjust as needed)
        $this->db = new PDO('mysql:host=db;dbname=mydatabase', 'user', 'password');

	// TODO: for the db, i think about using the api??? security through obscurity
	// to see, local object in websocket php, api call
	// OR everything is send to the db directely
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove the closed connection
        $this->clients->detach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Handle incoming messages and database interaction
        // Here, you could parse the message and run SQL queries

        $stmt = $this->db->prepare("SELECT * FROM some_table WHERE column = :value");
        $stmt->execute([':value' => $msg]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Send a response to the client
        $from->send(json_encode($result));
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

$server = IoServer::factory(
    new WsServer(
        new WebSocketServer()
    ),
    8080 // WebSocket port
);

$server->run();


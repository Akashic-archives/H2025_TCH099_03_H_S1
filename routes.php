<?php

require_once __DIR__.'/router.php';

require 'config.php';
require './src/controllers/ControllerMobile.php';
require './src/controllers/ControllerWeb.php';

get('/api/game/mobile/$id', function($id) {
  ControllerMobile::getGameById($id);
});

get('/api/web/game/$id', function($id) {
  ControllerWeb::getGameById($id);
});

get('/api/web/gameId/$id', function($id) {
  ControllerWeb::getCurrentGameIdByUserId($id);
});

get('/api/web/getLastMove/$id', function($id) {
  ControllerWeb::getLastMoveByGameId($id);
});

get('/api/web/getLastTwoMoves/$id', function($id) {
  ControllerWeb::getLastTwoMovesByGameId($id);
});

post('/api/web/piece/', function() {
  ControllerWeb::postPiece();
});

post('/api/web/turn/', function() {
  ControllerWeb::postTurn();
});

any('/404', function() {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode('Error 404');
});

?>

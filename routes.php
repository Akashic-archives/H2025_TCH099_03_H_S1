<?php

require_once __DIR__.'/router.php';

require 'config.php';
require './src/controllers/ControllerMobile.php';
require './src/controllers/ControllerWeb.php';

get('/api/game/mobile/$id', function($id) {
  ControllerMobile::getGameById($id);
});

get('/api/game/web/$id', function($id) {
  ControllerWeb::getGameById($id);
});

get('/api/game/users/web/$id', function($id) {
  ControllerWeb::getUsersInGame($id);
});

get('/api/game/currentturn/web/$id', function($id) {
  ControllerWeb::getCurrentTurn($id);
});

get('/api/game/web', function() {
  ControllerWeb::getAllGames();
});

get('/api/user/$email', function($email) {
  ControllerWeb::getUserByEmail($email);
});

get('/api/game/web/pieces/$id', function($id) {
  ControllerWeb::getCurrentGamePieces($id);
});

get('/api/user/games/$id', function($id) {
  ControllerWeb::getPlayersByGameUser($id);
});

get('/api/user/id/$id', function($id) {
  ControllerWeb::getUserNameFromID($id);
});



post('/api/web/game', function(){
  ControllerWeb::postGame();
});
post('/api/web/user', function(){
  ControllerWeb::postUser();
});
post('/api/web/gameuser', function(){
  ControllerWeb::postGameUser();
});
post('/api/web/turn', function(){
  ControllerWeb::postTurn();
});
post('/api/web/piece', function(){
  ControllerWeb::postPiece();
});
put('/api/web/piece', function($id){
  ControllerWeb::putPiece($id);
});


any('/404', function() {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode('Error 404');
});

?>

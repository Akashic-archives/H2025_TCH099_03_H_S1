<?php

require_once __DIR__.'/router.php';

require 'config.php';
require './src/controllers/ControllerMobile.php';

get('/api/game/mobile/$id', function($id) {
  ControllerMobile::getGameById($id);
});

get('/api/web/web/$id', function($id) {
  ControllerWeb::getGameById($id);
});

post('/api/web/web/game', function(){
  ControllerWeb::postGame();
});
post('/api/web/web/user', function(){
  ControllerWeb::postUser();
});
post('/api/web/web/gameuser', function(){
  ControllerWeb::postGameUser();
});
post('/api/web/web/turn', function(){
  ControllerWeb::postTurn();
});
post('/api/web/web/piece', function(){
  ControllerWeb::postPiece();
});
put('/api/web/web/piece', function($id){
  ControllerWeb::putPiece($id);
});


any('/404', function() {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode('Error 404');
});

?>

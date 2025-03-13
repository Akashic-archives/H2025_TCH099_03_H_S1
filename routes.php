<?php

require_once __DIR__.'/router.php';

require 'config.php';
require './src/controllers/ControllerMobile.php';

get('/api/game/mobile/$id', function($id) {
  ControllerMobile::getGameById($id);
});

any('/404', function() {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode('Error 404');
});

?>

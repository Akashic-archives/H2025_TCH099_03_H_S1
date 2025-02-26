<?php

require_once __DIR__.'/router.php';

require 'config.php';
require './src/controllers/ControllerAcceuil.php';

get('/api/activities/random', function() { 
  ControllerAcceuil::getRandomActivities();
});

get('/api/activities/$id', function($id) {
  ControllerAcceuil::getActivitieById($id);
});

any('/404', function() {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode('Error 404');
});

?>

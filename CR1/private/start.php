<?php
  ob_start(); // output buffering is turned on


  require_once('functions.php');
  require_once('database.php');
  require_once('queries.php');
  require_once('map.php');


  $db = connect();
  $errors = [];

?>

<?php 
  session_start();
  $_SESSION['nojs'] = '1';
  header('Location: http://' . $_SERVER['SERVER_NAME'] . "/");
?>

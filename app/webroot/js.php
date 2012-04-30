<?php 
  session_start();
  $_SESSION['nojs'] = '0';
  header('Location: http://' . $_SERVER['SERVER_NAME'] . "/");
?>

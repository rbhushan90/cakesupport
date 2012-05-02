<?php 
  session_start();
  $_SESSION['nojs'] = '1';
  if(isset($_SERVER['HTTP_REFERER'])) {
    header('Location: '. $_SERVER['HTTP_REFERER']);
  } else {
    header('Location: http://' . $_SERVER['SERVER_NAME'] . "/");
  }
?>

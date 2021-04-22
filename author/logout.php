<?php
  require('../includes/functions.inc.php');
  require('../includes/database.inc.php');
  
  session_start();
  
  alert("See You Soon ".$_SESSION['AUTHOR_NAME']);

  unset($_SESSION['AUTHOR_NAME']);
  unset($_SESSION['AUTHOR_LOGGED_IN']);
  unset($_SESSION['AUTHOR_ID']);
  unset($_SESSION['AUTHOR_EMAIL']);
  
  
  redirect('../author-login.php');
?>
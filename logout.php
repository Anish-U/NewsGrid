<?php
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  
  session_start();

  alert("See You Soon ".$_SESSION['USER_NAME']);

  unset($_SESSION['USER_NAME']);
  unset($_SESSION['USER_LOGGED_IN']);
  unset($_SESSION['USER_ID']);
  unset($_SESSION['USER_EMAIL']);
  
  redirect('./user-login.php');
?>
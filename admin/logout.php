<?php
  require('../includes/functions.inc.php');
  require('../includes/database.inc.php');
  
  session_start();
  
  alert("See You Soon Admin");

  unset($_SESSION['ADMIN_LOGGED_IN']);
  unset($_SESSION['ADMIN_ID']);
  
  
  redirect('./login.php');
?>
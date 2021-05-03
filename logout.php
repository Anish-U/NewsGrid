<?php
  // Fetching all the Functions and DB Code
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  
  // Creates a session or resumes the current one based on a session identifier. 
  session_start();

  // Sending an goodbye message
  alert("See You Soon ".$_SESSION['USER_NAME']);
  
  // Unsetting all the user specific session variables
  unset($_SESSION['USER_NAME']);
  unset($_SESSION['USER_LOGGED_IN']);
  unset($_SESSION['USER_ID']);
  unset($_SESSION['USER_EMAIL']);
  
  // Redirected to login page
  redirect('./user-login.php');
?>
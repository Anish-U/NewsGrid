<?php
  require('../includes/functions.inc.php');
  require('../includes/database.inc.php');
  session_start();
  if(!isset($_SESSION['AUTHOR_LOGGED_IN'])) {
    alert("Please Login to Enter Author Portal");
    redirect('../author-login.php');
  }
    
  echo "Welcome ".$_SESSION['AUTHOR_NAME'];
?>
<br>
<a href="./add-article.php">Add Article</a>
<br>
<a href="./logout.php">Logout</a>
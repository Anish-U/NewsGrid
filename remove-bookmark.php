<?php
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  
  session_start();

  if(!isset($_GET['id'])) {
    redirect('./index.php');
  }
  elseif ($_GET['id'] == '') {
    redirect('./index.php');
  }
  else {
    $article_id = $_GET['id'];
  }
  if(!isset($_SESSION['USER_LOGGED_IN'])) {
    redirect('./user-login.php');
  }

  $articleQuery = " SELECT *
                    FROM article
                    WHERE article_id = {$article_id} 
                    AND article_active = 1";
    
  $res = mysqli_query($con, $articleQuery);
  $row = mysqli_num_rows($res);

  if($row == 0) {
    redirect('./index.php');
  }

  $bookmarkQuery = " DELETE FROM bookmark 
                    WHERE user_id = {$_SESSION['USER_ID']}
                    AND article_id = {$article_id}";
  
  $result = mysqli_query($con, $bookmarkQuery);
  
  if($result) {
    redirect('./index.php');
  }
  else {
    alert('Try Again Later');
    redirect('./index.php');
  }

?>
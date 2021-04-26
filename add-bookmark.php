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
    alert('Please log in to Add Bookmarks');
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

  $bookmarkQuery = " INSERT INTO bookmark 
                    (user_id,article_id) 
                    VALUES 
                    ('{$_SESSION['USER_ID']}', '{$article_id}')";
  
  $result = mysqli_query($con, $bookmarkQuery);
  
  if($result) {
    redirect('./bookmarks.php');
  }
  else {
    alert('Try Again Later');
    redirect('./index.php');
  }

?>
<?php
  // Fetching all the Functions and DB Code
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  
  // Creates a session or resumes the current one based on a session identifier. 
  session_start();

  // If user not logged in
  if(!isset($_SESSION['USER_LOGGED_IN'])) {
    
    // Redirected to login page along with a message
    alert('Please log in to Add Bookmarks');
    redirect('./user-login.php');
  }

  // If we dont get article_id from URL
  if(!isset($_GET['id'])) {
    
    // Redirect to home page
    redirect('./index.php');
  }

  // If we get article_id from URL and it is null
  elseif ($_GET['id'] == '') {
    
    // Redirect to home page
    redirect('./index.php');
  }
  
  // If we get article_id from URL and it is not null
  else {
    
    // Store the article_id in a variable
    $article_id = $_GET['id'];
  }

  // Article Query to fetch all the article data for respective article id
  $articleQuery = " SELECT *
                    FROM article
                    WHERE article_id = {$article_id} 
                    AND article_active = 1";
  
  // Running the Article Query
  $res = mysqli_query($con, $articleQuery);
  
  // Returns the number of rows from the result retrieved.
  $row = mysqli_num_rows($res);

  // If no article found with respective article id
  if($row == 0) {
    
    // Redirect to home page
    redirect('./index.php');
  }

  // Bookmark Query to insert bookmark record for the particular user and article
  $bookmarkQuery = " INSERT INTO bookmark 
                    (user_id,article_id) 
                    VALUES 
                    ('{$_SESSION['USER_ID']}', '{$article_id}')";
  
  // Running Bookmark Query
  $result = mysqli_query($con, $bookmarkQuery);
  
  //If Query ran successfully
  if($result) {

    // Redirected to home page along with a message
    alert("Bookmark Added Successfuly");
    redirect('./bookmarks.php');
  }

  // If the Query failed
  else {
    
    // Redirected to home page along with a message
    alert('Try Again Later');
    redirect('./index.php');
  }

?>
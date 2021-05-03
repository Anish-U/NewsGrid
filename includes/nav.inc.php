<?php
  // Fetching all the Functions and DB Code
  require('./includes/functions.inc.php');
  require('./includes/database.inc.php');
  
  // Creates a session or resumes the current one based on a session identifier. 
  session_start();

  // Getting the URI From the Web
  $uri = $_SERVER['REQUEST_URI'];

  // Variable to store the page title used in title tag
  $page_title = "";

  // Flag variables to know which Page we are at
  $home = true; 
  $login = false; 
  $bookmark = false; 
  $changePass = false; 
  $category = false; 
  $search = false;
  
  // Strpos returns the position of the search string in the main string or returns 0 (false)
  // Checking if the page is Home Page
  if(strpos($uri,"index.php") != false){
    $page_title = " Home";
  }

  // Checking if the page is Login Page
  if(strpos($uri,"login.php") != false){
    $page_title = " Login";
    $home = false;
    $login = true;
  }
  
  // Checking if the page is Bookmarks Page
  if(strpos($uri,"bookmarks.php") != false){
    $page_title = " Bookmarks";
    $home = false;
    $bookmark = true;
  }
  
  // Checking if the page is Bookmarks Page
  if(strpos($uri,"user-change-password.php") != false){
    $page_title = " Change Password";
    $home = false;
    $changePass = true;
  }
  
  // Checking if the page is Home Page
  if(strpos($uri,"categories.php") != false){
    $page_title = " Categories";
    $home = false;
    $category = true;
  }
  
  // Checking if the page is Search Page
  if(strpos($uri,"search.php") != false){
    $page_title = " Search";
    $home = false;
    $search = true;
  }
  
  // Checking if the page is Articles Page
  if(strpos($uri,"articles.php") != false){
    $home = false;
    $page_title = "All Article";
  }

  // Checking if the page is New Article Page
  if(strpos($uri,"news.php") != false){
    $home = false;
    $page_title = "News Article";
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- PARTIAL CSS INCLUSIONS -->
  <link rel="stylesheet" href="./assets/css/partials/0-fonts.css" />
  <link rel="stylesheet" href="./assets/css/partials/1-variables.css" />
  <link rel="stylesheet" href="./assets/css/partials/2-reset.css" />
  <link rel="stylesheet" href="./assets/css/partials/3-typography.css" />
  <link rel="stylesheet" href="./assets/css/partials/4-component.css" />

  <!-- CUSTOM CSS INCLUSIONS -->
  <link rel="stylesheet" href="./assets/css/style.css" />

  <!-- RESPONSIVITY CSS INCLUSIONS -->
  <link rel="stylesheet" href="./assets/css/responsivity/media-queries.css" />

  <!-- FAVICON LINK -->
  <link rel="icon" href="./assets/images/favicon.ico" type="image/x-icon" />

  <!-- TITLE OF THE PAGE -->
  <title>NewsGrid | The Official News Portal | <?php echo $page_title; ?></title>

  <!-- FONTAWESOME LINK -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
</head>

<body>

  <!-- ======== BACK TO TOP BUTTON ======== -->
  <button onclick="topFunction()" class="topNavBtn" id="topNavBtn" title="Go to top"><i
      class="fa fa-arrow-up"></i></button>


  <!-- ======== NAVBAR ======== -->
  <nav class="navbar">
    <div class="logo"><a href="./index.php"><img src="./assets/images/logo.png" /></a></div>
    <label for="btn" class="icon">
      <span class="fa fa-bars"></span>
    </label>
    <input type="checkbox" id="btn" class="input" />
    <ul class="ul">
      <!-- We ECHO class current based upon the boolean variables used in above PHP Snippet -->
      <li><a href="./index.php" <?php if($home) echo 'class="current"' ?>>Home</a></li>
      <li>
        <label for="btn-1" class="show">Categories +</label>
        <a href="./categories.php" <?php if($category) echo 'class="current"' ?>>Categories</a>
        <input type="checkbox" id="btn-1" class="input" />
        <ul>
          <?php

            // Category Query to fetch random 4 categories
            $categoryQuery= " SELECT  category_id, category_name
                              FROM category 
                              ORDER BY RAND() LIMIT 4";

            // Running Category Query
            $result = mysqli_query($con,$categoryQuery);

            // Returns the number of rows from the result retrieved.
            $row = mysqli_num_rows($result);
            
            // If query has any result (records) => If there are categories
            if($row > 0) {
              
              // Fetching the data of particular record as an Associative Array
              while($data = mysqli_fetch_assoc($result)) {
                
                // Storing the category data in variables
                $category_id = $data['category_id'];
                $category_name = $data['category_name'];
                ?>
          <li><a href="articles.php?id=<?php echo $category_id ?>"><?php echo $category_name ?></a></li>
          <?php  
              }
            }
          ?>
          <li><a href="./categories.php">More +</a></li>
        </ul>
      </li>
      <li><a href="./bookmarks.php" <?php if($bookmark) echo 'class="current"' ?>>Bookmarks</a></li>
      <?php
        if(isset($_SESSION['USER_NAME'])) {
        }else {
      ?>
      <li>
        <label for="btn-2" class="show">Login +</label>
        <a href="./user-login.php" <?php if($login) echo 'class="current"' ?>>Login</a>
        <input type="checkbox" id="btn-2" class="input" />
        <ul>
          <li><a href="./user-login.php">Reader</a></li>
          <li><a href="./author-login.php">Author</a></li>
        </ul>
      </li>
      <?php
        }
      ?>
      <li>
        <a href="./search.php" <?php if($search) echo 'class="current"' ?>>
          <span>Search</span>
          <i id="search-icon" class="fas fa-search"></i>
        </a>
      </li>
      <?php

        // If user is logged in
        if(isset($_SESSION['USER_NAME'])) {
          echo '
          <li>
            <label for="btn-2" class="show">Settings</label>
            <a href="#"';
            
            if($changePass){
              echo 'class="current" '; 
            }
          echo
            '>Settings</a>
            <input type="checkbox" id="btn-2" class="input" />
            <ul>
              <li><a href="./user-change-password.php">Change Password</a></li>
              <li><a href="./logout.php">Logout</a></li>
              </ul>
          </li>
          ';
          echo '<li><a disabled>Hello '.$_SESSION["USER_NAME"].' !</a></li>';
        }
      ?>
    </ul>
  </nav>
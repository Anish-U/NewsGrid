<?php
  require('../includes/functions.inc.php');
  require('../includes/database.inc.php');
  session_start();

  if(!isset($_SESSION['ADMIN_LOGGED_IN'])) {
    alert("Please Login to Enter Admin Panel");
    redirect('./login.php');
  }
  
  $admin_name = "Admin";

  // Getting the URI From the Web
  $uri = $_SERVER['REQUEST_URI'];

  // Variable to store the page title used in title tag
  $page_title = "";

  // Flag variables to know which Page we are at
  $home = true; 
  $pass = false; 
  $category = false; 
  $article = false;
  
  // Strpos returns the position of the search string in the main string or returns 0 (false)
  // Checking if the page is Home Page
  if(strpos($uri,"/index.php") != false){
    $page_title = " Dashboard";
  }

  if(strpos($uri,"/articles.php") != false){
    $page_title = " Articles";
    $home = false;
    $article = true;
  }

  if(strpos($uri,"/categories.php") != false){
    $page_title = " Categories";
    $home = false;
    $category = true;
  }

  if(strpos($uri,"/add-category.php") != false){
    $page_title = "Add Category";
    $category = true;
    $home = false;
  }
  
  if(strpos($uri,"/change-password.php") != false){
    $page_title = "Change Password";
    $home = false;
    $pass = true;
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NewsGrid Admin Panel | <?php echo $page_title ?></title>

  <link href="../assets/css/partials/4-component.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon" />
  <link href="../assets/css/admin/style.css" rel="stylesheet" />
  <link href="../assets/css/partials/1-variables.css" rel="stylesheet" />
</head>

<body>
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
          aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">NewsGrid </a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li <?php if($home) echo 'class="active"' ?>><a href="./index.php">Dashboard</a></li>
          <li <?php if($article) echo 'class="active"' ?>><a href="./articles.php">Articles</a></li>
          <li <?php if($category) echo 'class="active"' ?>><a href="./categories.php">Categories</a></li>
          <li <?php if($pass) echo 'class="active"' ?>><a href="./change-password.php">Change Password</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a><?php echo $admin_name ?></a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header id="header">
    <div class="container">
      <div class="row">
        <div class="col-md-10">
          <h1><?php echo $page_title ?></h1>
        </div>
        <div class="col-md-2 btn-box">
          <a href="./add-category.php" class="btn btn-warning" type="button">
            Create a new Category
          </a>
        </div>
      </div>
    </div>
  </header>
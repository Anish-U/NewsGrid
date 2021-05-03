<?php

  // Server name or IP Address
  $host = "localhost";
  
  // MySQL Username
  $user = "root";
  
  // MySQL Password
  $pass = "";

  // Default Database name
  $db = "news-portal";

  // Creating a connection to the DataBase
  $con = mysqli_connect($host,$user,$pass,$db);

  // Checking If the connection is obtained
  if(!$con){
    die("Database Connection Error");
  }

?>
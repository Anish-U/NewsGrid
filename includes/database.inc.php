<?php

  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "news-portal";

  // Creating a connection to the DataBase
  $con = mysqli_connect($host,$user,$pass,$db);

  // Checking If the connecction is obtained
  if(!$con){
    die("Database Connection Error");
  }

?>
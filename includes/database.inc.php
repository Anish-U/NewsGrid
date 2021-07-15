<?php

// Development Connection
// Server name or IP Address
// $host = "localhost";

// // MySQL Username
// $user = "root";

// // MySQL Password
// $pass = "";

// // Default Database name
// $db = "news-portal";

// // Creating a connection to the DataBase
// $con = mysqli_connect($host,$user,$pass,$db);

// Deployment Connection

$host = "sql6.freesqldatabase.com";
$user = "sql6425408";
$pass = "Gw5PIf7DQY";
$db = "sql6425408";
$port = '3306';

$con = mysqli_connect($host, $user, $pass, $db, $port);

// Checking If the connection is obtained
if (!$con) {
  die("Database Connection Error");
}
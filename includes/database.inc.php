<?php

// Development Connection
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

/* Deployment Connection

$host = "SERVER_URL";
$user = "USERNAME";
$pass = "PASSWORD";
$db = "DATABASE_NAME";
$port = 'PORT_NO';

$con = mysqli_connect($host, $user, $pass, $db, $port);
*/

// Checking If the connection is obtained
if (!$con) {
  die("Database Connection Error");
}
<?php
$servername = "db";
$username = "root";
$password = "rootPass";
$database = "LitCrit2";

session_start();

try {
    $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
  } catch(PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
  }


 
  
?>
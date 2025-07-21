<?php
$servername   = "localhost:3306";
$database = "rdrood_prodmentor";
$username = "rdrood_prodmentor";
$password = "rd123prod987_Fiq";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
  echo "Connected successfully";
?>
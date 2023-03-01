<?php
$servername = "localhost";
$usernamedb = "root";
$passworddb = "";
$database = "cibiti";

// membuat koneksi
$conn = new mysqli($servername, $usernamedb, $passworddb, $database);

// Check koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";

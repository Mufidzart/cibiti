<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cibiti";

// membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Check koneksi
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";

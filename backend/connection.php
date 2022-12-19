<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:index.php");
}
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
date_default_timezone_set('Asia/Jakarta');
$session_id_staf = $_SESSION['username'];
$id_thajaran = 4;
$semester = 1;

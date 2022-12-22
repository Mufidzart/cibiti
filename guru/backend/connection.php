<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:../index.php");
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$uri_segments = explode('/', $actual_link);
if ($uri_segments[2] == "cibiti.test") {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "cibiti";
} else {
  $servername = "localhost";
  $username = "u1671256_cibitiusr";
  $password = "cibitiusr";
  $database = "u1671256_cibiti";
}

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

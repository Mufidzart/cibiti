<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:../index.php");
}
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
date_default_timezone_set('Asia/Jakarta');
if ($_SESSION['role'] == "guru") {
  $session_id_staf = $_SESSION['username'];
} else {
  $nis_siswa = $_SESSION['username']; 
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$uri_segments = explode('/', $actual_link);
$baseurl = $uri_segments[0] . '//' . $uri_segments[2];
$id_thajaran = 4;
$semester = 1;

<?php
switch ($_GET['action']) {
  case 'login';
    // mengaktifkan session php
    session_start();

    // menghubungkan dengan koneksi
    // include 'backend/connection.php';


    // menyeleksi data admin dengan username dan password yang sesuai
    // $data = mysqli_query($koneksi, "select * from admin where username='$username' and password='$password'");

    // menghitung jumlah data yang ditemukan
    // $cek = mysqli_num_rows($data);

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $uri_segments = explode('/', $actual_link);
    $baseurl = $uri_segments[0] . '//' . $uri_segments[2];
    if ($uri_segments[2] == "cibiti.test") {
      $servername = "localhost";
      $usernamedb = "root";
      $passworddb = "";
      $database = "cibiti";
    } else {
      $servername = "localhost";
      $usernamedb = "u1671256_cibitiusr";
      $passworddb = "cibitiusr";
      $database = "u1671256_cibiti";
    }
    // membuat koneksi
    $conn = new mysqli($servername, $usernamedb, $passworddb, $database);
    // Cek data guru

    // menangkap data yang dikirim dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $getguru = mysqli_query($conn, "SELECT * FROM arf_staf WHERE nip='$username' AND publish='yes'");
    if ($getguru->num_rows !== 0) {
      $_SESSION['username'] = $username;
      $_SESSION['role'] = "guru";
      $_SESSION['status'] = "login";
      header("location:guru/kelas.php");
    } else {
      $getsiswa = mysqli_query($conn, "SELECT * FROM arf_siswa WHERE nis='$username' AND boleh_login='yes'");
      if ($getsiswa->num_rows !== 0) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = "siswa";
        $_SESSION['status'] = "login";
        header("location:siswa/dashboard.php");
      } else {
        header("location:index.php?pesan=gagal");
      }
    }

    break;

  case 'logout':
    session_start();
    session_destroy();
    header("location:index.php");
    break;
}

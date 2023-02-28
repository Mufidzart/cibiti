<?php
switch ($_GET['action']) {
  case 'login';
    // mengaktifkan session php
    session_start();

    $servername = "localhost";
    $usernamedb = "root";
    $passworddb = "";
    $database = "cibiti";
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

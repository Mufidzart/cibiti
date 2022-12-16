<?php
switch ($_GET['action']) {
  case 'login';
    // mengaktifkan session php
    session_start();

    // menghubungkan dengan koneksi
    include 'backend/connection.php';

    // menangkap data yang dikirim dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // menyeleksi data admin dengan username dan password yang sesuai
    // $data = mysqli_query($koneksi, "select * from admin where username='$username' and password='$password'");

    // menghitung jumlah data yang ditemukan
    // $cek = mysqli_num_rows($data);

    if ($username == "197211012007011009") {
      $_SESSION['username'] = $username;
      $_SESSION['status'] = "login";
      header("location:kelas.php");
    } else {
      header("location:index.php?pesan=gagal");
    }

    break;

  case 'logout':
    session_start();
    session_destroy();
    header("location:index.php");
    break;
}

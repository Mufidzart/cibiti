<?php
require 'connection.php';

switch ($_GET['action']) {
  case 'get_data':
    if ($_GET['get'] == "data_penugasan") {
      $kelas_siswa = $_POST['kelas_siswa'];
      $subkelas_siswa = $_POST['subkelas_siswa'];
      $id_staf = $_POST['id_staf'];
      $id_mapel = $_POST['id_mapel'];
      $getpenugasan = $conn->query(
        "SELECT ahp.*,asf.nama_lengkap
        FROM arf_history_penugasan ahp
        JOIN arf_staf asf ON asf.nip=ahp.id_staff
        WHERE ahp.id_staff='$id_staf' 
        AND ahp.id_mapel=$id_mapel
        AND ahp.id_kelas=$subkelas_siswa
        AND ahp.tgl_hapus IS NULL ORDER BY id DESC"
      );
      require('../views/kelas_penugasan.php');
    }
    break;
  case 'mulai_ujian':
    $id_penugasan = $_POST['id_penugasan'];
    $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
    $datapenugasan = mysqli_fetch_assoc($getpenugasan);
    $idpenugasan = $datapenugasan['id'];
    $nis = $_SESSION['username'];
    $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$idpenugasan");
    if ($getprosesujian->num_rows == 0) {
      $mulai_ujian = date("Y-m-d H:i:s");
      $query = $conn->query(
        "INSERT INTO arf_proses_ujian(id_penugasan, id_siswa, mulai_ujian) 
        VALUES('$idpenugasan','$nis','$mulai_ujian')"
      );
    }
    break;
}

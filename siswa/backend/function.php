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
    $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
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

  case 'push_jawaban':
    $id_penugasan = $_POST['id_penugasan'];
    $kode_tugas = $_POST['kode_tugas'];
    $id_soal = $_POST['id_soal'];
    $id_kunci = $_POST['id_kunci'];
    $jawaban = $_POST['jawaban'];
    $nis = $_SESSION['username'];
    $getjawaban = $conn->query(
      "SELECT * FROM arf_jawaban_siswa 
      WHERE id_siswa='$nis' 
      AND id_penugasan=$id_penugasan
      AND kode_tugas='$kode_tugas'
      AND id_soal=$id_soal
      AND tgl_hapus IS NULL"
    );
    $datajawaban = mysqli_fetch_assoc($getjawaban);
    if ($getjawaban->num_rows == 0) {
      $query = $conn->query(
        "INSERT INTO arf_jawaban_siswa(id_siswa, id_penugasan, kode_tugas, id_soal, id_jawaban, jawaban) 
        VALUES('$nis','$id_penugasan','$kode_tugas','$id_soal','$id_kunci','$jawaban')"
      );
    } else {
      $id_jawaban = $datajawaban['id'];
      $query = $conn->query("UPDATE arf_jawaban_siswa SET id_jawaban='$id_kunci', jawaban='$jawaban', WHERE id=$id_jawaban");
    }
    break;
}

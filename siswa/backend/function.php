<?php
require '../../config/lms_connection.php';
include '../../helpers/helpers.php';
include '../../helpers/tanggal_helper.php';

switch ($_GET['action']) {
  case 'get_mapel':
    $data = explode("/", $_POST['data_kelas']);
    $id_kelas_induk = $data[0];
    $id_kelas = $data[1];
    $id_thajaran = $data[2];
    // Set Session TA
    $_SESSION['id_thajaran'] = $id_thajaran;
    // End Set Session TA
    $getgurumapel = $conn->query(
      "SELECT agm.id_staf,agm.id_mapel,asf.nama_lengkap,am.nama_mapel
      FROM arf_guru_mapel agm
      JOIN arf_staf asf ON asf.nip=agm.id_staf
      JOIN arf_mapel am ON am.id=agm.id_mapel
      WHERE agm.id_kelas=$id_kelas_induk
      AND agm.id_subkelas=$id_kelas
      AND agm.id_thajaran=$id_thajaran"
    );
    require('../views/data_mapel.php');
    break;
  case 'get_data':
    if ($_GET['get'] == "data_topik") {
      $kelas_siswa = $_POST['kelas_siswa'];
      $subkelas_siswa = $_POST['subkelas_siswa'];
      $id_staf = $_POST['id_staf'];
      $id_mapel = $_POST['id_mapel'];
      $idthajaran = $_POST['id_thajaran'];
      $gettopik = $conn->query(
        "SELECT tp.*,asf.nama_lengkap
        FROM topik_pembelajaran tp
        JOIN arf_staf asf ON asf.nip=tp.id_staf
        WHERE tp.id_staf='$id_staf' 
        AND tp.id_mapel=$id_mapel
        AND tp.id_kelas=$subkelas_siswa
        AND tp.id_thajaran=$idthajaran
        AND tp.tgl_hapus IS NULL ORDER BY id DESC"
      );
      require('../views/data_topik.php');
    } elseif ($_GET['get'] == "nilai_ujian_awal") {
      $nis = $_SESSION['username'];
      $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
      $id_prosesujian = $_POST['id_proses'];
      $getprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id=$id_prosesujian AND tgl_hapus IS NULL");
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      if (empty($dataprosesujian['nilai'])) {
        $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
        $tugas = mysqli_fetch_assoc($get_tugas_penugasan);
        // UPDATE NILAI
        $getalljawaban = $conn->query(
          "SELECT * FROM jawaban_siswa js
          JOIN soal_tugas_penugasan s ON js.id_soal=s.id
          WHERE js.id_siswa='$nis' 
          AND s.id_tugas_penugasan=$id_tugas_penugasan
          AND js.tgl_hapus IS NULL"
        );
        $jawaban_benar = [];
        while ($jawaban = mysqli_fetch_assoc($getalljawaban)) {
          $id_soal_jawaban = $jawaban['id_soal'];
          $getkunci =  $conn->query("SELECT * FROM jawaban_soal_tugas_penugasan WHERE id_soal=$id_soal_jawaban AND tgl_hapus IS NULL");
          while ($kunci = mysqli_fetch_assoc($getkunci)) {
            if ($kunci['kunci'] == 1) {
              if ($kunci['jawaban'] == $jawaban['jawaban']) {
                array_push($jawaban_benar, $jawaban['jawaban']);
              }
            }
          }
        }
        $jumlah_soal =  $tugas['jumlah_soal'];
        $jumlah_benar = sizeof($jawaban_benar);
        $nilai = ($jumlah_benar / $jumlah_soal) * 100;
        $query = $conn->query("UPDATE proses_ujian SET nilai='$nilai' WHERE id=$id_prosesujian");
      }
      if (empty($dataprosesujian['selesai_ujian'])) {
        $id_proses = $dataprosesujian['id'];
        $datenow = date("Y-m-d H:i:s");
        $query = $conn->query("UPDATE proses_ujian SET selesai_ujian='$datenow' WHERE id=$id_proses");
      }
      $getnewprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id=$id_prosesujian AND tgl_hapus IS NULL");
      $datanewprosesujian = mysqli_fetch_assoc($getnewprosesujian);
      require('../views/ujian/nilai_ujian.php');
    } elseif ($_GET['get'] == "lihat_materi") {
      $id_materi = $_POST['id_materi'];
      $getmateri = mysqli_query($conn, "SELECT * FROM materi_pembelajaran WHERE id='$id_materi' AND tgl_hapus IS NULL");
      $data_materi = mysqli_fetch_assoc($getmateri);
      require('../views/materi/lihat_materi.php');
    }
    break;
  case 'mulai_ujian':
    $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
    $nis = $_SESSION['username'];
    $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
    $tugas = mysqli_fetch_assoc($get_tugas_penugasan);
    $jumlah_soal = $tugas['jumlah_soal'];
    $getsoalujian =  $conn->query("SELECT id FROM soal_tugas_penugasan WHERE id_tugas_penugasan='$id_tugas_penugasan' ORDER BY RAND() LIMIT $jumlah_soal");
    $randomsoal = [];
    while ($soal = mysqli_fetch_assoc($getsoalujian)) {
      array_push($randomsoal, $soal['id']);
    }
    $id_soal = json_encode($randomsoal);
    $getprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id_siswa='$nis' AND id_tugas_penugasan=$id_tugas_penugasan");
    if ($getprosesujian->num_rows == 0) {
      $mulai_ujian = date("Y-m-d H:i:s");
      $query = $conn->query(
        "INSERT INTO proses_ujian(id_siswa, id_tugas_penugasan, id_soal, mulai_ujian) 
        VALUES('$nis','$id_tugas_penugasan','$id_soal','$mulai_ujian')"
      );
    }
    break;
  case 'simpan_data_jawaban':
    $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
    $id_prosesujian = $_POST['id_prosesujian'];
    $nis = $_SESSION['username'];
    $get_tugas_penugasan = $conn->query("SELECT * FROM tugas_penugasan WHERE id=$id_tugas_penugasan AND tgl_hapus IS NULL");
    $data_tugas_penugasan = mysqli_fetch_assoc($get_tugas_penugasan);
    $getprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id=$id_prosesujian AND tgl_hapus IS NULL");
    $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
    $allid_soal = json_decode($dataprosesujian['id_soal']);
    if ($get_tugas_penugasan->num_rows !== 0) {
      foreach ($allid_soal as $id_soal) {
        if (isset($_POST['jawaban_' . $id_soal])) {
          $id_pilihan_siswa = $_POST['jawaban_' . $id_soal];
          $getjawaban = $conn->query(
            "SELECT * FROM jawaban_siswa 
              WHERE id_siswa='$nis'
              AND id_soal=$id_soal
              AND tgl_hapus IS NULL"
          );
          $getkunci = $conn->query("SELECT * FROM jawaban_soal_tugas_penugasan WHERE id='$id_pilihan_siswa' AND tgl_hapus IS NULL");
          $datajawaban = mysqli_fetch_assoc($getjawaban);
          $datakunci = mysqli_fetch_assoc($getkunci);
          $jawaban = $datakunci['jawaban'];
          if ($getjawaban->num_rows == 0) {
            $query = $conn->query(
              "INSERT INTO jawaban_siswa(id_siswa, id_soal, id_jawaban, jawaban) 
            VALUES('$nis','$id_soal','$id_pilihan_siswa','$jawaban')"
            );
          } else {
            $id_jawaban = $datajawaban['id'];
            $query = $conn->query("UPDATE jawaban_siswa SET id_jawaban=$id_pilihan_siswa, jawaban='$jawaban' WHERE id=$id_jawaban");
          }
        }
      }
    }
    // UPDATE NILAI
    $getalljawaban = $conn->query(
      "SELECT * FROM jawaban_siswa js
      JOIN soal_tugas_penugasan s ON js.id_soal=s.id
      WHERE js.id_siswa='$nis' 
      AND s.id_tugas_penugasan=$id_tugas_penugasan
      AND js.tgl_hapus IS NULL"
    );
    $jawaban_benar = [];
    while ($jawaban = mysqli_fetch_assoc($getalljawaban)) {
      $id_soal_jawaban = $jawaban['id_soal'];
      $getkunci =  $conn->query("SELECT * FROM jawaban_soal_tugas_penugasan WHERE id_soal=$id_soal_jawaban AND tgl_hapus IS NULL");
      while ($kunci = mysqli_fetch_assoc($getkunci)) {
        if ($kunci['kunci'] == 1) {
          if ($kunci['jawaban'] == $jawaban['jawaban']) {
            array_push($jawaban_benar, $jawaban['jawaban']);
          }
        }
      }
    }
    $jumlah_soal =  $data_tugas_penugasan['jumlah_soal'];
    $jumlah_benar = sizeof($jawaban_benar);
    $nilai = ($jumlah_benar / $jumlah_soal) * 100;
    $query = $conn->query("UPDATE proses_ujian SET nilai='$nilai' WHERE id=$id_prosesujian");
    break;
}

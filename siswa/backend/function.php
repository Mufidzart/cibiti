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
    } elseif ($_GET['get'] == "nilai_ujian_awal") {
      $nis = $_SESSION['username'];
      $id_penugasan = $_POST['id_penugasan'];
      $id_proses = $_POST['id_proses'];
      $kode_tugas = $_POST['kode_tugas'];
      $jenis_ujian = "tugas_awal";
      $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id=$id_proses");
      $getnilai = $conn->query(
        "SELECT anp.*,ahp.judul,ahp.tugas_awal FROM arf_nilai_penugasan anp
        JOIN arf_history_penugasan ahp ON ahp.id=anp.id_penugasan
        WHERE anp.id_siswa='$nis' AND anp.id_penugasan=$id_penugasan AND anp.tgl_hapus IS NULL"
      );
      $datanilai = mysqli_fetch_assoc($getnilai);
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      if ($getnilai->num_rows == 0) {
        // UPDATE NILAI
        $getalljawaban = $conn->query(
          "SELECT * FROM arf_jawaban_siswa 
            WHERE id_siswa='$nis' 
            AND id_penugasan=$id_penugasan
            AND jenis_ujian='$jenis_ujian'
            AND kode_tugas='$kode_tugas'
            AND tgl_hapus IS NULL"
        );
        $jumlah_soal =  $datapenugasan['jumlah_soal_tugas_awal'];
        $jawaban_benar = [];
        while ($jawaban = mysqli_fetch_assoc($getalljawaban)) {
          $id_soal_jawaban = $jawaban['id_soal'];
          $getkunci =  $conn->query("SELECT * FROM arf_kunci_soal WHERE id_soal=$id_soal_jawaban AND tgl_hapus IS NULL");
          while ($kunci = mysqli_fetch_assoc($getkunci)) {
            if ($kunci['kunci'] == 1) {
              if ($kunci['jawaban'] == $jawaban['jawaban']) {
                array_push($jawaban_benar, $jawaban['jawaban']);
              }
            }
          }
        }
        $jumlah_benar = sizeof($jawaban_benar);
        $nilai = ($jumlah_benar / $jumlah_soal) * 100;
        $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
        $datapenugasan = mysqli_fetch_assoc($getpenugasan);
        $id_tahunajaran = $datapenugasan['id_tahunajaran'];
        $id_mapel = $datapenugasan['id_mapel'];
        $jenis_tugas = $datapenugasan['jenis_tugas'];
        $nh_ke = $datapenugasan['nh_ke'];
        $query = $conn->query("INSERT INTO arf_nilai_penugasan(id_siswa, id_thajaran, id_penugasan, id_mapel, jenis_tugas, nh_ke, nilai_awal) VALUES('$nis','$id_tahunajaran','$id_penugasan','$id_mapel','$jenis_tugas','$nh_ke','$nilai')");
      }
      if (empty($dataprosesujian['selesai_ujian'])) {
        $datenow = date("Y-m-d H:i:s");
        $query = $conn->query("UPDATE arf_proses_ujian SET selesai_ujian='$datenow' WHERE id=$id_proses");
        $dataprosesujian['selesai_ujian'] = $datenow;
      }
      $getnewnilai = $conn->query(
        "SELECT anp.*,ahp.judul,ahp.tugas_awal FROM arf_nilai_penugasan anp
        JOIN arf_history_penugasan ahp ON ahp.id=anp.id_penugasan
        WHERE anp.id_siswa='$nis' AND anp.id_penugasan=$id_penugasan AND anp.tgl_hapus IS NULL"
      );
      $datanewnilai = mysqli_fetch_assoc($getnewnilai);
      require('../views/ujian/nilai_ujian.php');
    } elseif ($_GET['get'] == "nilai_ujian_remidi") {
      $nis = $_SESSION['username'];
      $id_penugasan = $_POST['id_penugasan'];
      $id_proses = $_POST['id_proses'];
      $kode_tugas = $_POST['kode_tugas'];
      $jenis_ujian = $_POST['jenis_ujian'];
      $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id=$id_proses");
      $getnilai = $conn->query(
        "SELECT anp.*,ahp.judul,ahp.$jenis_ujian FROM arf_nilai_penugasan anp
        JOIN arf_history_penugasan ahp ON ahp.id=anp.id_penugasan
        WHERE anp.id_siswa='$nis' AND anp.id_penugasan=$id_penugasan AND anp.tgl_hapus IS NULL"
      );
      $datanilai = mysqli_fetch_assoc($getnilai);
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      if ($getnilai->num_rows == 0) {
        // UPDATE NILAI
        $getalljawaban = $conn->query(
          "SELECT * FROM arf_jawaban_siswa 
            WHERE id_siswa='$nis' 
            AND id_penugasan=$id_penugasan
            AND jenis_ujian='$jenis_ujian'
            AND kode_tugas='$kode_tugas'
            AND tgl_hapus IS NULL"
        );
        $jumlah_soal =  $datapenugasan['jumlah_soal_' . $jenis_ujian];
        $jawaban_benar = [];
        while ($jawaban = mysqli_fetch_assoc($getalljawaban)) {
          $id_soal_jawaban = $jawaban['id_soal'];
          $getkunci =  $conn->query("SELECT * FROM arf_kunci_soal WHERE id_soal=$id_soal_jawaban AND tgl_hapus IS NULL");
          while ($kunci = mysqli_fetch_assoc($getkunci)) {
            if ($kunci['kunci'] == 1) {
              if ($kunci['jawaban'] == $jawaban['jawaban']) {
                array_push($jawaban_benar, $jawaban['jawaban']);
              }
            }
          }
        }
        $jumlah_benar = sizeof($jawaban_benar);
        $nilai = ($jumlah_benar / $jumlah_soal) * 100;
        $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
        $datapenugasan = mysqli_fetch_assoc($getpenugasan);
        $id_tahunajaran = $datapenugasan['id_tahunajaran'];
        $id_mapel = $datapenugasan['id_mapel'];
        $jenis_tugas = $datapenugasan['jenis_tugas'];
        $nh_ke = $datapenugasan['nh_ke'];
        $query = $conn->query("INSERT INTO arf_nilai_penugasan(id_siswa, id_thajaran, id_penugasan, id_mapel, jenis_tugas, nh_ke, nilai_$jenis_ujian) VALUES('$nis','$id_tahunajaran','$id_penugasan','$id_mapel','$jenis_tugas','$nh_ke','$nilai')");
      }
      if (empty($dataprosesujian['selesai_ujian'])) {
        $datenow = date("Y-m-d H:i:s");
        $query = $conn->query("UPDATE arf_proses_ujian SET selesai_ujian='$datenow' WHERE id=$id_proses");
        $dataprosesujian['selesai_ujian'] = $datenow;
      }
      $getnewnilai = $conn->query(
        "SELECT anp.*,ahp.judul,ahp.$jenis_ujian FROM arf_nilai_penugasan anp
        JOIN arf_history_penugasan ahp ON ahp.id=anp.id_penugasan
        WHERE anp.id_siswa='$nis' AND anp.id_penugasan=$id_penugasan AND anp.tgl_hapus IS NULL"
      );
      $datanewnilai = mysqli_fetch_assoc($getnewnilai);
      require('../views/remidi/nilai_ujian.php');
    }
    break;
  case 'mulai_ujian':
    $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
    $nis = $_SESSION['username'];
    $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
    $tugas = mysqli_fetch_assoc($get_tugas_penugasan);
    // $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
    // $datapenugasan = mysqli_fetch_assoc($getpenugasan);
    $jumlah_soal = $datapenugasan['jumlah_soal'];
    $getsoalujian =  $conn->query(
      "SELECT asl.id FROM arf_soal asl
        JOIN arf_tugas_cbt atc ON asl.kode_tugas=atc.kode_tugas
        JOIN arf_history_penugasan ahp ON atc.kode_tugas=ahp.tugas_awal
        WHERE ahp.id='$id_penugasan'
        ORDER BY RAND()
        LIMIT $jumlah_soal"
    );
    $randomsoal = [];
    while ($soal = mysqli_fetch_assoc($getsoalujian)) {
      array_push($randomsoal, $soal['id']);
    }
    $id_soal = json_encode($randomsoal);
    $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_siswa='$nis' AND id_penugasan=$id_penugasan AND jenis_ujian='$jenis_ujian'");
    if ($getprosesujian->num_rows == 0) {
      $mulai_ujian = date("Y-m-d H:i:s");
      $query = $conn->query(
        "INSERT INTO arf_proses_ujian(id_siswa, id_penugasan, id_soal, jenis_ujian, mulai_ujian) 
        VALUES('$nis','$id_penugasan','$id_soal','$jenis_ujian','$mulai_ujian')"
      );
    }
    break;

  case 'mulai_ujian_remidi':
    $id_penugasan = $_POST['id_penugasan'];
    $jenis_ujian = $_POST['jenis_ujian'];
    $nis = $_SESSION['username'];
    $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
    $datapenugasan = mysqli_fetch_assoc($getpenugasan);
    $jumlah_soal = $datapenugasan['jumlah_soal_' . $jenis_ujian];
    $getsoalujian =  $conn->query(
      "SELECT asl.id FROM arf_soal asl
        JOIN arf_tugas_cbt atc ON asl.kode_tugas=atc.kode_tugas
        JOIN arf_history_penugasan ahp ON atc.kode_tugas=ahp.$jenis_ujian
        WHERE ahp.id='$id_penugasan'
        ORDER BY RAND()
        LIMIT $jumlah_soal"
    );
    $randomsoal = [];
    while ($soal = mysqli_fetch_assoc($getsoalujian)) {
      array_push($randomsoal, $soal['id']);
    }
    $id_soal = json_encode($randomsoal);
    $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_siswa='$nis' AND id_penugasan=$id_penugasan AND jenis_ujian='$jenis_ujian'");
    if ($getprosesujian->num_rows == 0) {
      $mulai_ujian = date("Y-m-d H:i:s");
      $query = $conn->query(
        "INSERT INTO arf_proses_ujian(id_siswa, id_penugasan, id_soal, jenis_ujian, mulai_ujian) 
        VALUES('$nis','$id_penugasan','$id_soal','$jenis_ujian','$mulai_ujian')"
      );
    }
    break;

  case 'simpan_data_jawaban':
    $id_penugasan = $_POST['id_penugasan'];
    $id_prosesujian = $_POST['id_prosesujian'];
    $jenis_ujian = "tugas_awal";
    $nis = $_SESSION['username'];
    $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
    $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id=$id_prosesujian AND tgl_hapus IS NULL");
    $datapenugasan = mysqli_fetch_assoc($getpenugasan);
    $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
    $kode_tugas = $datapenugasan['tugas_awal'];
    $allid_soal = json_decode($dataprosesujian['id_soal']);
    if ($getpenugasan->num_rows !== 0) {
      foreach ($allid_soal as $id_soal) {
        if (isset($_POST['jawaban_' . $id_soal])) {
          $id_pilihan_siswa = $_POST['jawaban_' . $id_soal];
          $getjawaban = $conn->query(
            "SELECT * FROM arf_jawaban_siswa 
              WHERE id_siswa='$nis' 
              AND id_penugasan=$id_penugasan
              AND kode_tugas='$kode_tugas'
              AND id_soal=$id_soal
              AND tgl_hapus IS NULL"
          );
          $getkunci = $conn->query("SELECT * FROM arf_kunci_soal WHERE id='$id_pilihan_siswa' AND tgl_hapus IS NULL");
          $datajawaban = mysqli_fetch_assoc($getjawaban);
          $datakunci = mysqli_fetch_assoc($getkunci);
          $jawaban = $datakunci['jawaban'];
          if ($getjawaban->num_rows == 0) {
            $query = $conn->query(
              "INSERT INTO arf_jawaban_siswa(id_siswa, id_penugasan, jenis_ujian, kode_tugas, id_soal, id_jawaban, jawaban) 
            VALUES('$nis','$id_penugasan','$jenis_ujian','$kode_tugas','$id_soal','$id_pilihan_siswa','$jawaban')"
            );
          } else {
            $id_jawaban = $datajawaban['id'];
            $query = $conn->query("UPDATE arf_jawaban_siswa SET id_jawaban=$id_pilihan_siswa, jawaban='$jawaban' WHERE id=$id_jawaban");
          }
        }
      }
    }

    // UPDATE NILAI
    $getalljawaban = $conn->query(
      "SELECT * FROM arf_jawaban_siswa 
      WHERE id_siswa='$nis' 
      AND id_penugasan=$id_penugasan
      AND jenis_ujian='$jenis_ujian'
      AND kode_tugas='$kode_tugas'
      AND tgl_hapus IS NULL"
    );
    $jumlah_soal =  $datapenugasan['jumlah_soal_tugas_awal'];
    $jawaban_benar = [];
    while ($jawaban = mysqli_fetch_assoc($getalljawaban)) {
      $id_soal_jawaban = $jawaban['id_soal'];
      $getkunci =  $conn->query("SELECT * FROM arf_kunci_soal WHERE id_soal=$id_soal_jawaban AND tgl_hapus IS NULL");
      while ($kunci = mysqli_fetch_assoc($getkunci)) {
        if ($kunci['kunci'] == 1) {
          if ($kunci['jawaban'] == $jawaban['jawaban']) {
            array_push($jawaban_benar, $jawaban['jawaban']);
          }
        }
      }
    }
    $jumlah_benar = sizeof($jawaban_benar);
    $nilai = ($jumlah_benar / $jumlah_soal) * 100;
    $getnilai =  $conn->query("SELECT * FROM arf_nilai_penugasan WHERE id_siswa='$nis' AND id_penugasan=$id_penugasan AND tgl_hapus IS NULL");
    if ($getnilai->num_rows == 0) {
      $id_tahunajaran = $datapenugasan['id_tahunajaran'];
      $id_mapel = $datapenugasan['id_mapel'];
      $jenis_tugas = $datapenugasan['jenis_tugas'];
      $nh_ke = $datapenugasan['nh_ke'];
      $query = $conn->query("INSERT INTO arf_nilai_penugasan(id_siswa, id_thajaran, id_penugasan, id_mapel, jenis_tugas, nh_ke, nilai_awal) VALUES('$nis','$id_tahunajaran','$id_penugasan','$id_mapel','$jenis_tugas','$nh_ke','$nilai')");
    } else {
      $datanilai = mysqli_fetch_assoc($getnilai);
      $id_nilai = $datanilai['id'];
      $query = $conn->query("UPDATE arf_nilai_penugasan SET nilai_awal='$nilai' WHERE id=$id_nilai");
    }
    break;
  case 'simpan_data_jawaban_remidi':
    $id_penugasan = $_POST['id_penugasan'];
    $id_prosesujian = $_POST['id_prosesujian'];
    $jenis_ujian = $_POST['jenis_ujian'];
    $nis = $_SESSION['username'];
    $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
    $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id=$id_prosesujian AND tgl_hapus IS NULL");
    $datapenugasan = mysqli_fetch_assoc($getpenugasan);
    $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
    $kode_tugas = $datapenugasan[$jenis_ujian];
    $allid_soal = json_decode($dataprosesujian['id_soal']);
    if ($getpenugasan->num_rows !== 0) {
      foreach ($allid_soal as $id_soal) {
        if (isset($_POST['jawaban_' . $id_soal])) {
          $id_pilihan_siswa = $_POST['jawaban_' . $id_soal];
          $getjawaban = $conn->query(
            "SELECT * FROM arf_jawaban_siswa 
              WHERE id_siswa='$nis' 
              AND id_penugasan=$id_penugasan
              AND kode_tugas='$kode_tugas'
              AND id_soal=$id_soal
              AND tgl_hapus IS NULL"
          );
          $getkunci = $conn->query("SELECT * FROM arf_kunci_soal WHERE id='$id_pilihan_siswa' AND tgl_hapus IS NULL");
          $datajawaban = mysqli_fetch_assoc($getjawaban);
          $datakunci = mysqli_fetch_assoc($getkunci);
          $jawaban = $datakunci['jawaban'];
          if ($getjawaban->num_rows == 0) {
            $query = $conn->query(
              "INSERT INTO arf_jawaban_siswa(id_siswa, id_penugasan, jenis_ujian, kode_tugas, id_soal, id_jawaban, jawaban) 
            VALUES('$nis','$id_penugasan','$jenis_ujian','$kode_tugas','$id_soal','$id_pilihan_siswa','$jawaban')"
            );
          } else {
            $id_jawaban = $datajawaban['id'];
            $query = $conn->query("UPDATE arf_jawaban_siswa SET id_jawaban=$id_pilihan_siswa, jawaban='$jawaban' WHERE id=$id_jawaban");
          }
        }
      }
    }

    // UPDATE NILAI
    $getalljawaban = $conn->query(
      "SELECT * FROM arf_jawaban_siswa 
      WHERE id_siswa='$nis' 
      AND id_penugasan=$id_penugasan
      AND jenis_ujian='$jenis_ujian'
      AND kode_tugas='$kode_tugas'
      AND tgl_hapus IS NULL"
    );
    $jumlah_soal =  $datapenugasan['jumlah_soal_' . $jenis_ujian];
    $jawaban_benar = [];
    while ($jawaban = mysqli_fetch_assoc($getalljawaban)) {
      $id_soal_jawaban = $jawaban['id_soal'];
      $getkunci =  $conn->query("SELECT * FROM arf_kunci_soal WHERE id_soal=$id_soal_jawaban AND tgl_hapus IS NULL");
      while ($kunci = mysqli_fetch_assoc($getkunci)) {
        if ($kunci['kunci'] == 1) {
          if ($kunci['jawaban'] == $jawaban['jawaban']) {
            array_push($jawaban_benar, $jawaban['jawaban']);
          }
        }
      }
    }
    $jumlah_benar = sizeof($jawaban_benar);
    $nilai = ($jumlah_benar / $jumlah_soal) * 100;
    $getnilai =  $conn->query("SELECT * FROM arf_nilai_penugasan WHERE id_siswa='$nis' AND id_penugasan=$id_penugasan AND tgl_hapus IS NULL");
    if ($getnilai->num_rows == 0) {
      $id_tahunajaran = $datapenugasan['id_tahunajaran'];
      $id_mapel = $datapenugasan['id_mapel'];
      $jenis_tugas = $datapenugasan['jenis_tugas'];
      $nh_ke = $datapenugasan['nh_ke'];
      $query = $conn->query("INSERT INTO arf_nilai_penugasan(id_siswa, id_thajaran, id_penugasan, id_mapel, jenis_tugas, nh_ke, nilai_$jenis_ujian) VALUES('$nis','$id_tahunajaran','$id_penugasan','$id_mapel','$jenis_tugas','$nh_ke','$nilai')");
    } else {
      $datanilai = mysqli_fetch_assoc($getnilai);
      $id_nilai = $datanilai['id'];
      $query = $conn->query("UPDATE arf_nilai_penugasan SET nilai_$jenis_ujian='$nilai' WHERE id=$id_nilai");
    }
    break;
}

<?php
require 'connection.php';
include 'helpers.php';
switch ($_GET['action']) {
  case 'simpan_data_tugas':
    $id_staff = $session_id_staf;
    $judul = $_POST['judul-tugas'];
    $mapel = $_POST['mapel-tugas'];
    $jenis = $_POST['jenis-tugas'];
    $deskripsi = $_POST['deskripsi-tugas'];
    // Generate Kode
    $kode = strtoupper(bin2hex(random_bytes(3)));
    // Insert data
    $query = mysqli_query($conn, "INSERT INTO arf_tugas_cbt(kode_tugas, id_staff, id_mapel, judul, jenis, deskripsi) VALUES('$kode','$id_staff','$mapel','$judul', '$jenis', '$deskripsi')");
    if ($query) {
      $last_id = $conn->insert_id;
      $data = [
        "acc" => true,
        "last_id" => $last_id
      ];
      echo json_encode($data);
    } else {
      $data = [
        "acc" => false,
        "errors" => mysqli_error($conn)
      ];
      echo json_encode($data);
    }
    break;

  case 'edit_data_tugas':
    $id = $_POST['id-tugas'];
    $judul = $_POST['judul-tugas'];
    $mapel = $_POST['mapel-tugas'];
    $jenis = $_POST['jenis-tugas'];
    $deskripsi = $_POST['deskripsi-tugas'];
    $today = date("Y-m-d h:i:s");
    $query = mysqli_query($conn, "UPDATE arf_tugas_cbt SET judul='$judul', jenis='$jenis', deskripsi='$deskripsi', tgl_edit='$today' WHERE id='$id'");
    $jenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
    $html_jenis_tugas = '';
    while ($row = mysqli_fetch_assoc($jenis_tugas)) {
      $select = ($jenis == $row['jenis_tugas']) ? "selected" : "";
      $html_jenis_tugas .= '<option value="' . $row['jenis_tugas'] . '" ' . $select . '>' . $row['jenis_tugas'] . '</option>';
    }
    $getmapel = mysqli_query($conn, "SELECT distinct am.id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel WHERE agm.id_staf='$session_id_staf' AND agm.id_thajaran=4");
    $html_mapel = '';
    while ($row = mysqli_fetch_assoc($getmapel)) {
      $select = ($mapel == $row['id']) ? "selected" : "";
      $html_mapel .= '<option value="' . $row['id'] . '" ' . $select . '>' . $row['nama_mapel'] . '</option>';
    }
    $getnamamape = mysqli_query($conn, "SELECT nama_mapel FROM arf_mapel WHERE id=$mapel");
    $data = mysqli_fetch_assoc($getnamamape);
    if ($query) {
      $data = [
        "id" => $id,
        "judul" => $judul,
        "jenis" => $jenis,
        "nama_mapel" => $data['nama_mapel'],
        "deskripsi" => $deskripsi,
        "jenis_tugas" => $html_jenis_tugas,
        "mapel" => $html_mapel
      ];
      echo json_encode($data);
      die;
    } else {
      $data = "Simpan Data Gagal :" . mysqli_error($conn);
      echo json_encode($data);
    }
    break;

  case 'hapus_data_tugas';
    $id = $_POST['id-tugas'];
    $today = date("Y-m-d h:i:s");
    $query = mysqli_query($conn, "UPDATE arf_tugas_cbt SET tgl_hapus='$today' WHERE id='$id'");
    if ($query) {
      $data = "Hapus Data Sukses";
      echo json_encode($data);
    } else {
      $data = "Hapus Data Gagal: " . mysqli_error($conn);
      echo json_encode($data);
    }
    break;

  case 'simpan_data_soal':
    // Validation
    $data['errors'] = [];
    $data['success'] = [];
    if (empty($_POST['pertanyaan'])) {
      $validation = ["input" => "pertanyaan", "message" => "Pertanyaan tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "pertanyaan");
    }
    $tipe_soal = $_POST['tipe-soal'];
    // Validation
    if ($tipe_soal == "Pilihan Ganda") {
      if (empty($_POST['radio-pilihan'])) {
        $validation = ["input" => "radio-pilihan", "message" => "Pilih salahsatu pilihan sebagai kunci jawaban."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "radio-pilihan");
      }
      if (empty($_POST['pilihan-1'])) {
        $validation = ["input" => "pilihan-1", "message" => "Pilihan ke-1 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-1");
      }
      if (empty($_POST['pilihan-2'])) {
        $validation = ["input" => "pilihan-2", "message" => "Pilihan ke-2 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-2");
      }
      if (empty($_POST['pilihan-3'])) {
        $validation = ["input" => "pilihan-3", "message" => "Pilihan ke-3 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-3");
      }
      if (empty($_POST['pilihan-4'])) {
        $validation = ["input" => "pilihan-4", "message" => "Pilihan ke-4 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-4");
      }
    }
    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      // Inputan Soal
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id-mapel-soal'];
      $kode_tugas = $_POST['kode-tugas-soal'];
      $jenis_soal = $tipe_soal;
      $pertanyaan = $_POST['pertanyaan'];
      // End Inputan Soal
      // Input Soal
      $query = mysqli_query($conn, "INSERT INTO arf_soal(id_staff, id_mapel, kode_tugas, tipe_soal, pertanyaan) VALUES('$id_staff','$id_mapel','$kode_tugas','$tipe_soal', '$pertanyaan')");
      $last_id = $conn->insert_id;
      // End Input Soal
      if ($tipe_soal == "Pilihan Ganda") {
        // Inputan Kunci Jawaban
        $radio_pilih = $_POST['radio-pilihan'];
        $jawaban_1 = $_POST['pilihan-1'];
        $kunci_jawaban_1 = ($radio_pilih == 1) ? 1 : 0;
        $jawaban_2 = $_POST['pilihan-2'];
        $kunci_jawaban_2 = ($radio_pilih == 2) ? 1 : 0;
        $jawaban_3 = $_POST['pilihan-3'];
        $kunci_jawaban_3 = ($radio_pilih == 3) ? 1 : 0;
        $jawaban_4 = $_POST['pilihan-4'];
        $kunci_jawaban_4 = ($radio_pilih == 4) ? 1 : 0;
        $query = mysqli_query($conn, "INSERT INTO arf_kunci_soal(id_soal, jawaban, kunci) VALUES ('$last_id','$jawaban_1','$kunci_jawaban_1'), ('$last_id','$jawaban_2','$kunci_jawaban_2'), ('$last_id','$jawaban_3','$kunci_jawaban_3'), ('$last_id','$jawaban_4','$kunci_jawaban_4')");
        // End Inputan Kunci Jawaban
      }

      if ($query) {
        $data = [
          "acc" => true,
          "last_id" => $last_id
        ];
        echo json_encode($data);
      } else {
        $data = [
          "acc" => false,
          "errors" => mysqli_error($conn)
        ];
        echo json_encode($data);
      }
    }

    break;

  case 'get_data':
    if ($_GET['get'] == 'data_soal') {
      $kode_tugas = $_POST['kode_tugas'];
      $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
      require('../views/data_soal.php');
    } elseif ($_GET['get'] == 'data_soal_id') {
      $id_soal = $_POST['id_soal'];
      $tipe_soal = mysqli_query($conn, "SELECT * FROM arf_master_soal WHERE tgl_hapus IS NULL");
      $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE id='$id_soal' AND tgl_hapus IS NULL");
      $getjawaban = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
      require('../views/data_soal_id.php');
    } elseif ($_GET['get'] == "data_tugas") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $jenis_tugas = $_POST['jenis_tugas'];
      $getsoal = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND jenis='$jenis_tugas' AND tgl_hapus IS NULL");
      $datatugas = [];
      while ($row = mysqli_fetch_assoc($getsoal)) {
        $data_push = [
          "id" => $row['id'],
          "kode_tugas" => $row['kode_tugas'],
          "id_mapel" => $row['id_mapel'],
          "judul" => $row['judul'],
          "jenis" => $row['jenis'],
          "deskripsi" => $row['deskripsi'],
          "tgl_hapus" => $row['tgl_hapus']
        ];
        array_push($datatugas, $data_push);
      }
      echo json_encode($datatugas);
    } elseif ($_GET['get'] == "data_penugasan") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY id DESC");
      require('../views/data_penugasan.php');
    } elseif ($_GET['get'] == "data_penugasan_akanberakhir") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $datenow = date("Y-m-d H:i:s");
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY batas_tugas_awal DESC");
      require('../views/data_penugasan_akanberakhir.php');
    } elseif ($_GET['get'] == "lihat_tugas") {
      $kode_tugas = $_POST['kode_tugas'];
      $gettugas = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
      $datatugas = mysqli_fetch_assoc($gettugas);
      require('../views/lihat_tugas.php');
    } elseif ($_GET['get'] == "nilai_penugasan") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY id DESC");
      require('../views/nilai_penugasan.php');
    }
    break;

  case 'edit_data_soal':
    // Validation
    $data['errors'] = [];
    $data['success'] = [];
    if (empty($_POST['pertanyaan'])) {
      $validation = ["input" => "pertanyaan", "message" => "Pertanyaan tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "pertanyaan");
    }
    $tipe_soal = $_POST['tipe-soal'];
    // Validation
    if ($tipe_soal == "Pilihan Ganda") {
      if (empty($_POST['radio-pilihan'])) {
        $validation = ["input" => "radio-pilihan", "message" => "Pilih salahsatu pilihan sebagai kunci jawaban."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "radio-pilihan");
      }
      if (empty($_POST['pilihan-1'])) {
        $validation = ["input" => "pilihan-1", "message" => "Pilihan ke-1 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-1");
      }
      if (empty($_POST['pilihan-2'])) {
        $validation = ["input" => "pilihan-2", "message" => "Pilihan ke-2 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-2");
      }
      if (empty($_POST['pilihan-3'])) {
        $validation = ["input" => "pilihan-3", "message" => "Pilihan ke-3 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-3");
      }
      if (empty($_POST['pilihan-4'])) {
        $validation = ["input" => "pilihan-4", "message" => "Pilihan ke-4 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "pilihan-4");
      }
    }
    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      // Inputan Soal
      $id_soal = $_POST['id_soal'];
      $jenis_soal = $tipe_soal;
      $pertanyaan = $_POST['pertanyaan'];
      $today = date("Y-m-d h:i:s");
      // End Inputan Soal
      // Update Soal
      $query = mysqli_query($conn, "UPDATE arf_soal SET tipe_soal='$jenis_soal', pertanyaan='$pertanyaan', tgl_edit='$today' WHERE id='$id_soal'");
      // End Update Soal
      if ($tipe_soal == "Pilihan Ganda") {
        // Inputan Kunci Jawaban
        $delete_old_jawaban = mysqli_query($conn, "UPDATE arf_kunci_soal SET tgl_hapus='$today' WHERE id_soal='$id_soal'");
        $radio_pilih = $_POST['radio-pilihan'];
        $jawaban_1 = $_POST['pilihan-1'];
        $kunci_jawaban_1 = ($radio_pilih == 1) ? 1 : 0;
        $jawaban_2 = $_POST['pilihan-2'];
        $kunci_jawaban_2 = ($radio_pilih == 2) ? 1 : 0;
        $jawaban_3 = $_POST['pilihan-3'];
        $kunci_jawaban_3 = ($radio_pilih == 3) ? 1 : 0;
        $jawaban_4 = $_POST['pilihan-4'];
        $kunci_jawaban_4 = ($radio_pilih == 4) ? 1 : 0;
        // End Inputan Kunci Jawaban
        $query = mysqli_query($conn, "INSERT INTO arf_kunci_soal(id_soal, jawaban, kunci) VALUES ('$id_soal','$jawaban_1','$kunci_jawaban_1'), ('$id_soal','$jawaban_2','$kunci_jawaban_2'), ('$id_soal','$jawaban_3','$kunci_jawaban_3'), ('$id_soal','$jawaban_4','$kunci_jawaban_4')");
      }

      if ($query) {
        $data = [
          "acc" => true,
          "last_id" => $id_soal
        ];
        echo json_encode($data);
      } else {
        $data = [
          "acc" => false,
          "errors" => mysqli_error($conn)
        ];
        echo json_encode($data);
      }
    }

    break;

  case 'hapus_data_soal';
    $id_soal = $_POST['id-hapus-soal'];
    $today = date("Y-m-d h:i:s");
    $query = mysqli_query($conn, "UPDATE arf_soal SET tgl_hapus='$today' WHERE id='$id_soal'");
    // $query = mysqli_query($conn, "UPDATE arf_kunci_soal SET tgl_hapus='$today' WHERE id_soal='$id_soal'");
    if ($query) {
      $data = "Hapus Data Sukses";
      echo json_encode($data);
    } else {
      $data = "Hapus Data Gagal: " . mysqli_error($conn);
      echo json_encode($data);
    }
    break;

  case 'simpan_data_penugasan':
    // Validation
    $data['errors'] = [];
    $data['success'] = [];
    if (empty($_POST['mapel'])) {
      $validation = ["input" => "mapel", "message" => "Mata pelajaran tidak ditemukan."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "mapel");
    }
    if (empty($_POST['kelas'])) {
      $validation = ["input" => "kelas", "message" => "Kelas tidak ditemukan."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "kelas");
    }
    if (empty($_POST['judul-penugasan'])) {
      $validation = ["input" => "judul-penugasan", "message" => "Judul tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "judul-penugasan");
    }

    if (empty($_POST['tugas-awal'])) {
      $validation = ["input" => "tugas-awal", "message" => "Tugas awal tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "tugas-awal");
    }
    if (empty($_POST['batas-tugas-awal'])) {
      $validation = ["input" => "batas-tugas-awal", "message" => "Batas tugas awal tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "batas-tugas-awal");
    }
    if (empty($_POST['durasi-tugas-awal'])) {
      if ($_POST['durasi-tugas-awal'] == "0") {
        array_push($data['success'], "durasi-tugas-awal");
      } else {
        $validation = ["input" => "durasi-tugas-awal", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      }
    } else {
      array_push($data['success'], "durasi-tugas-awal");
    }

    if (!empty($_POST['r1'])) {
      if (empty($_POST['batas-r1'])) {
        $validation = ["input" => "batas-r1", "message" => "Batas remidi 1 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "batas-r1");
      }
      if (empty($_POST['durasi-r1'])) {
        $validation = ["input" => "durasi-r1", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "durasi-r1");
      }
    } else {
      array_push($data['success'], "r1");
      array_push($data['success'], "batas-r1");
      array_push($data['success'], "durasi-r1");
    }
    if (!empty($_POST['r2'])) {
      if (empty($_POST['batas-r2'])) {
        $validation = ["input" => "batas-r2", "message" => "Batas remidi 2 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "batas-r2");
      }
      if (empty($_POST['durasi-r2'])) {
        $validation = ["input" => "durasi-r2", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "durasi-r2");
      }
    } else {
      array_push($data['success'], "r2");
      array_push($data['success'], "batas-r2");
      array_push($data['success'], "durasi-r2");
    }
    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      // Inputan Soal
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['mapel'];
      $id_kelas = $_POST['kelas'];
      $judul = $_POST['judul-penugasan'];
      $deskripsi = $_POST['deskripsi-penugasan'];
      $tugas_awal = $_POST['tugas-awal'];
      $pecahtugasawal = explode(" - ", $_POST['batas-tugas-awal']);
      $tgl_tugasawal = date('Y-m-d', strtotime($pecahtugasawal[0]));
      $time_tugasawal = date('H:i:s', strtotime($pecahtugasawal[1]));
      $batas_tugas_awal = $tgl_tugasawal . ' ' . $time_tugasawal;
      $durasi_menit_tugas_awal = $_POST['durasi-tugas-awal'];
      if (!empty($_POST['r1'])) {
        $pecahr1 = explode(" - ", $_POST['batas-r1']);
        $tgl_r1 = date('Y-m-d', strtotime($pecahr1[0]));
        $time_r1 = date('H:i:s', strtotime($pecahr1[1]));
        $r1 = $_POST['r1'];
        $batas_r1 = $tgl_r1 . ' ' . $time_r1;
        $durasi_r1 = $_POST['durasi-r1'];
        $kolomr1 = ", r1, batas_r1, durasi_menit_r1";
        $valuer1 = ",'$r1','$batas_r1','$durasi_r1'";
      } else {
        $kolomr1 = "";
        $valuer1 = "";
      }
      if (!empty($_POST['r2'])) {
        $pecahr2 = explode(" - ", $_POST['batas-r2']);
        $tgl_r2 = date('Y-m-d', strtotime($pecahr2[0]));
        $time_r2 = date('H:i:s', strtotime($pecahr2[1]));
        $r2 = $_POST['r2'];
        $batas_r2 = $tgl_r2 . ' ' . $time_r2;
        $durasi_r2 = $_POST['durasi-r2'];
        $kolomr2 = ", r2, batas_r2, durasi_menit_r2";
        $valuer2 = ",'$r2','$batas_r2','$durasi_r2'";
      } else {
        $kolomr2 = "";
        $valuer2 = "";
      }
      // End Inputan Soal
      // Input Soal
      $query = $conn->query(
        "INSERT INTO arf_history_penugasan(id_staff, id_mapel, id_kelas, judul, deskripsi, tugas_awal, batas_tugas_awal, durasi_menit_tugas_awal $kolomr1 $kolomr2) 
      VALUES('$id_staff','$id_mapel','$id_kelas','$judul','$deskripsi','$tugas_awal','$batas_tugas_awal','$durasi_menit_tugas_awal' $valuer1 $valuer2)"
      );
      $last_id = $conn->insert_id;
      // End Input Soal

      if ($query) {
        $data = [
          "acc" => true,
          "last_id" => $last_id
        ];
        echo json_encode($data);
      } else {
        $data = [
          "acc" => false,
          "errors" => mysqli_error($conn)
        ];
        echo json_encode($data);
      }
    }
    break;
  case 'get_data_penugasan_byid':
    $id_penugasan = $_POST['id_penugasan'];
    $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id='$id_penugasan' AND tgl_hapus IS NULL");
    if ($getpenugasan->num_rows !== 0) {
      $penugasan = mysqli_fetch_assoc($getpenugasan);
      $tugas_awal = $penugasan['tugas_awal'];
      $r1 = $penugasan['r1'];
      $r2 = $penugasan['r2'];
      $gettugas = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE kode_tugas='$tugas_awal' AND tgl_hapus IS NULL");
      $datatugas = mysqli_fetch_assoc($gettugas);
      $jenis_tugas = $datatugas['jenis'];
      $gettugas_all = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE jenis='$jenis_tugas' AND tgl_hapus IS NULL");
      $getjenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
      $get_date_tugas_awal = date('Y-m-d', strtotime($penugasan['batas_tugas_awal']));
      $get_time_tugas_awal = date('H:i:s', strtotime($penugasan['batas_tugas_awal']));
      $date_tugas_awal = $get_date_tugas_awal . 'T' . $get_time_tugas_awal . 'Z';
      if (!empty($penugasan['r1'])) {
        $get_date_r1 = date('Y-m-d', strtotime($penugasan['batas_r1']));
        $get_time_r1 = date('H:i:s', strtotime($penugasan['batas_r1']));
        $date_r1 = $get_date_r1 . 'T' . $get_time_r1 . 'Z';
      } else {
        $date_r1 = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
      }
      if (!empty($penugasan['r2'])) {
        $get_date_r2 = date('Y-m-d', strtotime($penugasan['batas_r2']));
        $get_time_r2 = date('H:i:s', strtotime($penugasan['batas_r2']));
        $date_r2 = $get_date_r2 . 'T' . $get_time_r2 . 'Z';
      } else {
        $date_r2 = date('Y-m-d') . 'T' . date('H:i:s') . 'Z';
      }
      require('../views/get_data_penugasan_byid.php');
    } else {
      $data = "Gagal Mengambil Data :" . mysqli_error($conn);
      echo $data;
    }
    break;
  case 'edit_data_penugasan':
    // Validation
    $data['errors'] = [];
    $data['success'] = [];
    if (empty($_POST['judul-editpenugasan'])) {
      $validation = ["input" => "judul-editpenugasan", "message" => "Judul tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "judul-editpenugasan");
    }


    if (empty($_POST['tugas-awal-editpenugasan'])) {
      $validation = ["input" => "tugas-awal-editpenugasan", "message" => "Tugas awal tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "tugas-awal-editpenugasan");
    }
    if (empty($_POST['batas-tugas-awal-editpenugasan'])) {
      $validation = ["input" => "batas-tugas-awal-editpenugasan", "message" => "Batas tugas awal tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "batas-tugas-awal-editpenugasan");
    }
    if (empty($_POST['durasi-tugas-awal-editpenugasan'])) {
      if ($_POST['durasi-tugas-awal-editpenugasan'] == "0") {
        array_push($data['success'], "durasi-tugas-awal-editpenugasan");
      } else {
        $validation = ["input" => "durasi-tugas-awal-editpenugasan", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      }
    } else {
      array_push($data['success'], "durasi-tugas-awal-editpenugasan");
    }

    if (!empty($_POST['r1-editpenugasan'])) {
      if (empty($_POST['batas-r1-editpenugasan'])) {
        $validation = ["input" => "batas-r1-editpenugasan", "message" => "Batas remidi 1 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "batas-r1-editpenugasan");
      }
      if (empty($_POST['durasi-r1-editpenugasan'])) {
        $validation = ["input" => "durasi-r1-editpenugasan", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "durasi-r1-editpenugasan");
      }
    } else {
      array_push($data['success'], "r1-editpenugasan");
      array_push($data['success'], "batas-r1-editpenugasan");
      array_push($data['success'], "durasi-r1-editpenugasan");
    }
    if (!empty($_POST['r2-editpenugasan'])) {
      if (empty($_POST['batas-r2-editpenugasan'])) {
        $validation = ["input" => "batas-r2-editpenugasan", "message" => "Batas remidi 2 tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "batas-r2-editpenugasan");
      }
      if (empty($_POST['durasi-r2-editpenugasan'])) {
        $validation = ["input" => "durasi-r2-editpenugasan", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "durasi-r2-editpenugasan");
      }
    } else {
      array_push($data['success'], "r2-editpenugasan");
      array_push($data['success'], "batas-r2-editpenugasan");
      array_push($data['success'], "durasi-r2-editpenugasan");
    }

    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      // Inputan Soal
      $id_penugasan = $_POST['id-editpenugasan'];
      $judul = $_POST['judul-editpenugasan'];
      $deskripsi = $_POST['deskripsi-editpenugasan'];
      $tugas_awal = $_POST['tugas-awal-editpenugasan'];
      $batas_tugas_awal = $_POST['batas-tugas-awal-editpenugasan'];
      $durasi_menit_tugas_awal = $_POST['durasi-tugas-awal-editpenugasan'];
      if (!empty($_POST['r1-editpenugasan'])) {
        $r1 = $_POST['r1-editpenugasan'];
        $batas_r1 = $_POST['batas-r1-editpenugasan'];
        $durasi_r1 = $_POST['durasi-r1-editpenugasan'];
        $valuer1 = ",r1='$r1',batas_r1='$batas_r1',durasi_menit_r1='$durasi_r1'";
      } else {
        $valuer1 = ",r1=null,batas_r1=null,durasi_menit_r1=null";
      }
      if (!empty($_POST['r2-editpenugasan'])) {
        $r2 = $_POST['r2-editpenugasan'];
        $batas_r2 = $_POST['batas-r2-editpenugasan'];
        $durasi_r2 = $_POST['durasi-r2-editpenugasan'];
        $valuer2 = ",r2='$r2',batas_r2='$batas_r2',durasi_menit_r2='$durasi_r2'";
      } else {
        $valuer2 = ",r2=null,batas_r2=null,durasi_menit_r2=null";
      }
      // End Inputan Soal
      // Input Soal
      $query = mysqli_query($conn, "UPDATE arf_history_penugasan SET judul='$judul', deskripsi='$deskripsi', tugas_awal='$tugas_awal',  batas_tugas_awal='$batas_tugas_awal', durasi_menit_tugas_awal='$durasi_menit_tugas_awal' $valuer1 $valuer2 WHERE id='$id_penugasan'");
      // End Input Soal

      if ($query) {
        $data = [
          "acc" => true,
        ];
        echo json_encode($data);
      } else {
        $data = [
          "acc" => false,
          "errors" => mysqli_error($conn)
        ];
        echo json_encode($data);
      }
    }
    break;

  case 'hapus_data_penugasan';
    $id = $_POST['id-hapus-penugasan'];
    $today = date("Y-m-d h:i:s");
    $query = mysqli_query($conn, "UPDATE arf_history_penugasan SET tgl_hapus='$today' WHERE id='$id'");
    if ($query) {
      $data = "Hapus Data Sukses";
      echo json_encode($data);
    } else {
      $data = "Hapus Data Gagal: " . mysqli_error($conn);
      echo json_encode($data);
    }
    break;
}

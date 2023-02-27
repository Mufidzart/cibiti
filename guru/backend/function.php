<?php
require 'connection.php';
// Load file autoload.php
require '../../vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

include 'helpers.php';
switch ($_GET['action']) {
  case 'get_kelas':
    $id_thajaran = $_POST['id_thajaran'];
    $semester = $_POST['semester'];
    $getkelasmapel = $conn->query(
      "SELECT agm.id_kelas,agm.id_subkelas,ak.nama_kelas,ak.parent_id,am.nama_mapel 
      FROM arf_guru_mapel agm 
      JOIN arf_mapel am ON am.id=agm.id_mapel 
      JOIN arf_kelas ak ON ak.id=agm.id_subkelas 
      WHERE agm.id_staf='$session_id_staf' 
      AND agm.id_thajaran=$id_thajaran"
    );
    require('../views/data_kelas.php');
    break;
  case 'get_data':
    if ($_GET['get'] == "data_penugasan") {
      $id_staf = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staf='$id_staf' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND id_topik IS NULL AND tgl_hapus IS NULL ORDER BY id DESC");
      require('../views/penugasan/data_penugasan.php');
    } elseif ($_GET['get'] == "data_penugasan_akanberakhir") {
      $id_staf = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $datenow = date("Y-m-d H:i:s");
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staf='$id_staf' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND id_topik IS NULL AND tgl_hapus IS NULL");
      require('../views/penugasan/data_penugasan_akanberakhir.php');
    } elseif ($_GET['get'] == "nilai_penugasan") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY id DESC");
      require('../views/nilai_penugasan.php');
    }
    break;
  case 'proses_topik':
    if ($_GET['run'] == "data_topik") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $gettopik = mysqli_query($conn, "SELECT * FROM topik_pembelajaran WHERE id_staf='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY id DESC");
      require('../views/topik/data_topik.php');
    } elseif ($_GET['run'] == "tambah_topik") {
      //Validation
      $data['errors'] = [];
      $data['success'] = [];
      if (empty($_POST['id_mapel'])) {
        $validation = ["input" => "id_mapel", "message" => "Mata pelajaran tidak ditemukan."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "id_mapel");
      }
      if (empty($_POST['id_kelas'])) {
        $validation = ["input" => "id_kelas", "message" => "Kelas tidak ditemukan."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "id_kelas");
      }
      if (empty($_POST['judul-topik'])) {
        $validation = ["input" => "judul-topik", "message" => "Judul tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "judul-topik");
      }
      if (!empty($data['errors'])) {
        $data['acc'] = false;
        echo json_encode($data);
      } else {
        $id_staff = $session_id_staf;
        $id_mapel = $_POST['id_mapel'];
        $id_kelas = $_POST['id_kelas'];
        $judul = $_POST['judul-topik'];
        $deskripsi = $_POST['deskripsi-topik'];

        // Input Topik
        $query = $conn->query(
          "INSERT INTO topik_pembelajaran(id_staf, id_mapel, id_kelas, id_thajaran, judul, deskripsi) 
      VALUES('$id_staff','$id_mapel','$id_kelas','$id_thajaran','$judul','$deskripsi')"
        );
        if ($query) {
          $data = [
            "acc" => true,
            "success" => $data['success']
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
    } elseif ($_GET['run'] == "topikbyid") {
      $id_topik = $_POST['id_topik'];
      $gettopik = mysqli_query($conn, "SELECT * FROM topik_pembelajaran WHERE id='$id_topik' AND tgl_hapus IS NULL");
      if ($gettopik->num_rows !== 0) {
        $data_topik = mysqli_fetch_assoc($gettopik);
        require('../views/topik/topikbyid.php');
      } else {
        $data = "Gagal Mengambil Data :" . mysqli_error($conn);
        echo $data;
      }
    } elseif ($_GET['run'] == "update_topik") {
      //Validation
      $data['errors'] = [];
      $data['success'] = [];
      if (empty($_POST['judul-topik'])) {
        $validation = ["input" => "judul-topik", "message" => "Judul tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "judul-topik");
      }
      if (!empty($data['errors'])) {
        $data['acc'] = false;
        echo json_encode($data);
      } else {
        $id_topik = $_POST['id_topik'];
        $judul = $_POST['judul-topik'];
        $deskripsi = $_POST['deskripsi-topik'];

        // Update Topik
        $query = mysqli_query($conn, "UPDATE topik_pembelajaran SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id_topik'");
        // End Update

        if ($query) {
          $data = [
            "acc" => true,
            "success" => $data['success']
          ];
        } else {
          $data = [
            "acc" => false,
            "errors" => mysqli_error($conn)
          ];
        }
        echo json_encode($data);
      }
    } elseif ($_GET['run'] == "hapus_topik") {
      $id_topik = $_POST['id_topik'];
      $today = date("Y-m-d h:i:s");
      $query = mysqli_query($conn, "UPDATE topik_pembelajaran SET tgl_hapus='$today' WHERE id='$id_topik'");
      if ($query) {
        $data = "Hapus Data Sukses";
      } else {
        $data = "Hapus Data Gagal: " . mysqli_error($conn);
      }
      echo json_encode($data);
    }
    break;
  case 'proses_penugasan':
    if ($_GET['get'] == "lihat_penugasan") {
      $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
      $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
      $data_tugas_penugasan = mysqli_fetch_assoc($get_tugas_penugasan);
      require('../views/penugasan/lihat_tugas.php');
    } elseif ($_GET['run'] == "tambah_penugasan") {
      //Validation
      $data['errors'] = [];
      $data['success'] = [];

      if (empty($_POST['judul'])) {
        $validation = ["input" => "judul", "message" => "Judul tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "judul");
      }
      if (empty($_POST['jenis-tugas'])) {
        $validation = ["input" => "jenis-tugas", "message" => "Jenis tugas tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "jenis-tugas");
      }

      if (empty($_FILES['fileexcel-tugas']['name'])) {
        $validation = ["input" => "fileexcel-tugas", "message" => "File tugas awal tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "fileexcel-tugas");
      }
      if (empty($_POST['batas-tugas'])) {
        $validation = ["input" => "batas-tugas", "message" => "Batas tugas awal tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "batas-tugas");
      }
      if (empty($_POST['durasi-tugas'])) {
        if ($_POST['durasi-tugas'] == "0") {
          array_push($data['success'], "durasi-tugas");
        } else {
          $validation = ["input" => "durasi-tugas", "message" => "Waktu pengerjaan tidak boleh kosong."];
          array_push($data['errors'], $validation);
        }
      } else {
        array_push($data['success'], "durasi-tugas");
      }
      if (empty($_POST['jumlah-soal-tugas'])) {
        $validation = ["input" => "jumlah-soal-tugas", "message" => "Jumlah soal tidak boleh kosong atau 0."];
        array_push($data['errors'], $validation);
      } else {
        if ($_POST['jumlah-soal-tugas'] == "0") {
          $validation = ["input" => "jumlah-soal-tugas", "message" => "Jumlah soal tidak boleh kosong atau 0."];
          array_push($data['errors'], $validation);
        } else {
          array_push($data['success'], "jumlah-soal-tugas");
        }
      }

      if (empty($_POST['id_topik'])) {
        if (empty($_POST['id_mapel'])) {
          $validation = ["input" => "id_mapel", "message" => "Mata pelajaran tidak ditemukan."];
          array_push($data['errors'], $validation);
        } else {
          array_push($data['success'], "id_mapel");
        }
        if (empty($_POST['id_kelas'])) {
          $validation = ["input" => "id_kelas", "message" => "Kelas tidak ditemukan."];
          array_push($data['errors'], $validation);
        } else {
          array_push($data['success'], "id_kelas");
        }
      }

      if (!empty($data['errors'])) {
        $data['acc'] = false;
        echo json_encode($data);
      } else {
        $id_staf = $session_id_staf;
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $jenis_tugas = $_POST['jenis-tugas'];
        $pecahtugas = explode(" - ", $_POST['batas-tugas']);
        $tgl_tugas = date('Y-m-d', strtotime($pecahtugas[0]));
        $time_tugas = date('H:i:s', strtotime($pecahtugas[1]));
        $batas_tugas = $tgl_tugas . ' ' . $time_tugas;
        $durasi_menit_tugas = $_POST['durasi-tugas'];
        $jumlah_soal_tugas = $_POST['jumlah-soal-tugas'];
        // Input History Penugasan
        if (empty($_POST['id_topik'])) {
          $id_mapel = $_POST['id_mapel'];
          $id_kelas = $_POST['id_kelas'];
          $query = $conn->query(
            "INSERT INTO arf_history_penugasan(id_staf, id_mapel, id_kelas, id_thajaran, judul, deskripsi, jenis_tugas) 
          VALUES('$id_staf','$id_mapel','$id_kelas','$id_thajaran','$judul','$deskripsi','$jenis_tugas')"
          );
        } else {
          $id_topik = $_POST['id_topik'];
          $gettopik = mysqli_query($conn, "SELECT * FROM topik_pembelajaran WHERE id='$id_topik' AND tgl_hapus IS NULL");
          $data_topik = mysqli_fetch_assoc($gettopik);
          $id_mapel = $data_topik['id_mapel'];
          $id_kelas = $data_topik['id_kelas'];
          $id_thajaran = $data_topik['id_thajaran'];
          $query = $conn->query(
            "INSERT INTO arf_history_penugasan(id_staf, id_mapel, id_kelas, id_thajaran, id_topik, judul, deskripsi, jenis_tugas) 
          VALUES('$id_staf','$id_mapel','$id_kelas','$id_thajaran','$id_topik','$judul','$deskripsi','$jenis_tugas')"
          );
        }
        // End Input History Penugasan
        // Input Tugas Penugasan
        $id_penugasan = $conn->insert_id;
        $sub_tugas = "Tugas";
        $query = $conn->query(
          "INSERT INTO tugas_penugasan(id_penugasan, sub_tugas, batas_tugas, durasi_tugas, jumlah_soal) 
        VALUES('$id_penugasan','$sub_tugas','$batas_tugas','$durasi_menit_tugas','$jumlah_soal_tugas')"
        );
        $id_tugas_penugasan = $conn->insert_id;
        // End Input Tugas Penugasan

        // Input Soal Tugas Penugasan
        if (isset($_FILES['fileexcel-tugas'])) { // Jika user mengklik tombol Import
          $folder = "../tmp/";
          if (!file_exists($folder)) {
            mkdir($folder, 0777);
          }
          $file_name = $_FILES['fileexcel-tugas']['name'];
          $source       = $_FILES["fileexcel-tugas"]["tmp_name"];
          $destination  = $folder . $file_name;
          /* move the file */
          move_uploaded_file($source, $destination);
          $arr_file = explode('.', $_FILES['fileexcel-tugas']['name']);
          $extension = end($arr_file);

          if ('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
          } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
          }
          $spreadsheet = $reader->load($destination); // Load file yang tadi diupload ke folder tmp
          $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
          $last_column = $spreadsheet->getActiveSheet()->getHighestColumn();
          $count_pilihan_jawaban = (ord(strtolower($last_column)) - 96) - 3;
          $numrow = 1;
          $start_pilihan = "C";
          $tipe_soal = str_replace("Template Soal ", "", $sheet[1]['A']);
          foreach ($sheet as $row) {
            if ($numrow >= 5) {
              $soal = $row['B'];
              $kunci_jawaban = $row[$last_column];
              // Cek jika semua data tidak diisi
              if ($soal == "" && $kunci_jawaban == "") continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya
              $explode_kunci = explode(" ", $kunci_jawaban);
              $kunci = $explode_kunci[1];
              $query = mysqli_query($conn, "INSERT INTO soal_tugas_penugasan(id_tugas_penugasan, tipe_soal, pertanyaan) VALUES('$id_tugas_penugasan','$tipe_soal', '$soal')");
              $id_soal = $conn->insert_id;
              for ($i = 1; $i <= $count_pilihan_jawaban; $i++) {
                $kunci_fix = ($i == $kunci) ? 1 : 0;
                $pilihan_jawaban = $row[$start_pilihan];
                $query = mysqli_query($conn, "INSERT INTO jawaban_soal_tugas_penugasan(id_soal, jawaban, kunci) VALUE ('$id_soal','$pilihan_jawaban','$kunci_fix')");
                $start_pilihan++;
              }
            }
            $start_pilihan = "C";
            $numrow++; // Tambah 1 setiap kali looping
          }
          unlink($destination); // Hapus file excel yg telah diupload, ini agar tidak terjadi penumpukan file
        }
        // End Input Soal Tugas Penugasan

        if ($query) {
          $data = [
            "acc" => true,
            "success" => $data['success']
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
    }
    break;
  case 'edit_data_soal':
    // Validation
    var_dump($_POST);
    die;
    $data['errors'] = [];
    $data['success'] = [];
    if (empty($_POST['pertanyaan'])) {
      $validation = ["input" => "pertanyaan", "message" => "Pertanyaan tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "pertanyaan");
    }
    $id_soal = $_POST['id_soal'];
    $getsoal = mysqli_query($conn, "SELECT * FROM soal_tugas_penugasan WHERE id='$id_soal' AND tgl_hapus IS NULL");
    $soal = mysqli_fetch_assoc($getsoal);
    $tipe_soal = $soal['tipe_soal'];
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
      $pertanyaan = $_POST['pertanyaan'];
      $today = date("Y-m-d h:i:s");
      // End Inputan Soal
      // Update Soal
      $query = mysqli_query($conn, "UPDATE soal_tugas_penugasan SET tipe_soal='$tipe_soal', pertanyaan='$pertanyaan', tgl_edit='$today' WHERE id='$id_soal'");
      // End Update Soal
      if ($tipe_soal == "Pilihan Ganda") {
        // Inputan Kunci Jawaban
        $delete_old_jawaban = mysqli_query($conn, "UPDATE jawaban_soal_tugas_penugasan SET tgl_hapus='$today' WHERE id_soal='$id_soal'");
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

  case 'hapus_data_soal':
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
    if (empty($_POST['jenis-tugas'])) {
      $validation = ["input" => "jenis-tugas", "message" => "Jenis tugas tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "jenis-tugas");
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
    if (empty($_POST['jumlah_soal-tugas-awal'])) {
      $validation = ["input" => "jumlah_soal-tugas-awal", "message" => "Jumlah soal tidak boleh kosong atau 0."];
      array_push($data['errors'], $validation);
    } else {
      if ($_POST['jumlah_soal-tugas-awal'] == "0") {
        $validation = ["input" => "jumlah_soal-tugas-awal", "message" => "Jumlah soal tidak boleh kosong atau 0."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "jumlah_soal-tugas-awal");
      }
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
      if (empty($_POST['jumlah_soal-r1'])) {
        $validation = ["input" => "jumlah_soal-r1", "message" => "Jumlah soal tidak boleh kosong atau 0."];
        array_push($data['errors'], $validation);
      } else {
        if ($_POST['jumlah_soal-r1'] == "0") {
          $validation = ["input" => "jumlah_soal-r1", "message" => "Jumlah soal tidak boleh kosong atau 0."];
          array_push($data['errors'], $validation);
        } else {
          array_push($data['success'], "jumlah_soal-r1");
        }
      }
    } else {
      array_push($data['success'], "r1");
      array_push($data['success'], "batas-r1");
      array_push($data['success'], "durasi-r1");
      array_push($data['success'], "jumlah_soal-r1");
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
      if (empty($_POST['jumlah_soal-r2'])) {
        $validation = ["input" => "jumlah_soal-r2", "message" => "Jumlah soal tidak boleh kosong atau 0."];
        array_push($data['errors'], $validation);
      } else {
        if ($_POST['jumlah_soal-r2'] == "0") {
          $validation = ["input" => "jumlah_soal-r2", "message" => "Jumlah soal tidak boleh kosong atau 0."];
          array_push($data['errors'], $validation);
        } else {
          array_push($data['success'], "jumlah_soal-r2");
        }
      }
    } else {
      array_push($data['success'], "r2");
      array_push($data['success'], "batas-r2");
      array_push($data['success'], "durasi-r2");
      array_push($data['success'], "jumlah_soal-r2");
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
      $jenis_tugas = $_POST['jenis-tugas'];
      $deskripsi = $_POST['deskripsi-penugasan'];
      $tugas_awal = $_POST['tugas-awal'];
      $pecahtugasawal = explode(" - ", $_POST['batas-tugas-awal']);
      $tgl_tugasawal = date('Y-m-d', strtotime($pecahtugasawal[0]));
      $time_tugasawal = date('H:i:s', strtotime($pecahtugasawal[1]));
      $batas_tugas_awal = $tgl_tugasawal . ' ' . $time_tugasawal;
      $durasi_menit_tugas_awal = $_POST['durasi-tugas-awal'];
      $jumlah_soal_tugas_awal = $_POST['jumlah_soal-tugas-awal'];
      if ($jenis_tugas == "Tugas Harian") {
        $getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND jenis_tugas='Tugas Harian' AND id_tahunajaran='$id_thajaran' AND tgl_hapus IS NULL");
        $nh_ke = $getpenugasan->num_rows + 1;
      } else {
        $nh_ke = 0;
      }
      if (!empty($_POST['r1'])) {
        $pecahr1 = explode(" - ", $_POST['batas-r1']);
        $tgl_r1 = date('Y-m-d', strtotime($pecahr1[0]));
        $time_r1 = date('H:i:s', strtotime($pecahr1[1]));
        $r1 = $_POST['r1'];
        $batas_r1 = $tgl_r1 . ' ' . $time_r1;
        $durasi_r1 = $_POST['durasi-r1'];
        $jumlah_soal_r1 = $_POST['jumlah_soal-r1'];
        $kolomr1 = ", r1, batas_r1, durasi_menit_r1, jumlah_soal_r1";
        $valuer1 = ",'$r1','$batas_r1','$durasi_r1','$jumlah_soal_r1";
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
        $jumlah_soal_r2 = $_POST['jumlah_soal-r2'];
        $kolomr2 = ", r2, batas_r2, durasi_menit_r2, jumlah_soal_r2";
        $valuer2 = ",'$r2','$batas_r2','$durasi_r2', '$jumlah_soal_r2'";
      } else {
        $kolomr2 = "";
        $valuer2 = "";
      }
      // End Inputan Soal
      // Input Soal
      $query = $conn->query(
        "INSERT INTO arf_history_penugasan(id_staff, id_mapel, id_kelas, id_tahunajaran, judul, deskripsi, jenis_tugas, nh_ke, tugas_awal, batas_tugas_awal, durasi_menit_tugas_awal, jumlah_soal_tugas_awal $kolomr1 $kolomr2) 
      VALUES('$id_staff','$id_mapel','$id_kelas','$id_thajaran','$judul','$deskripsi','$jenis_tugas','$nh_ke','$tugas_awal','$batas_tugas_awal','$durasi_menit_tugas_awal','$jumlah_soal_tugas_awal' $valuer1 $valuer2)"
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
      $data_penugasan = mysqli_fetch_assoc($getpenugasan);
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
    if (empty($_POST['jenis-editpenugasan'])) {
      $validation = ["input" => "jenis-editpenugasan", "message" => "Jenis tugas tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "jenis-editpenugasan");
    }

    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      // Inputan
      $id_penugasan = $_POST['id-editpenugasan'];
      $judul = $_POST['judul-editpenugasan'];
      $jenis_tugas = $_POST['jenis-editpenugasan'];
      $deskripsi = $_POST['deskripsi-editpenugasan'];
      // End Inputan
      // Input
      $query = mysqli_query($conn, "UPDATE arf_history_penugasan SET judul='$judul', deskripsi='$deskripsi', jenis_tugas='$jenis_tugas' WHERE id='$id_penugasan'");
      // End Input

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

  case 'hapus_data_penugasan':
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
  case 'media_upload':
    $folder = "../uploads/";
    if (!file_exists($folder)) {
      mkdir($folder, 0777);
    }
    for ($f = 0; $f < count($_FILES["upload_file"]["tmp_name"]); $f++) {
      $filename   = uniqid() . "-" . time(); // 5dab1961e93a7-1571494241
      $extension  = pathinfo($_FILES["upload_file"]["name"][$f], PATHINFO_EXTENSION);
      $basename   = $filename . "." . $extension; // 5dab1961e93a7_1571494241.jpg
      $source       = $_FILES["upload_file"]["tmp_name"][$f];
      $destination  = $folder . $basename;

      /* move the file */
      move_uploaded_file($source, $destination);
      $query = mysqli_query($conn, "INSERT INTO arf_media_upload(nama) VALUES('$basename')");
    }
    if ($query) {
      $data = ['acc' => true];
    } else {
      $data = ['acc' => false];
    }
    echo json_encode($data);
    break;
  case 'import_soal':
    if (isset($_FILES['fileexcel'])) { // Jika user mengklik tombol Import
      $folder = "../tmp/";
      if (!file_exists($folder)) {
        mkdir($folder, 0777);
      }
      $file_name = $_FILES['fileexcel']['name'];
      $source       = $_FILES["fileexcel"]["tmp_name"];
      $destination  = $folder . $file_name;
      /* move the file */
      move_uploaded_file($source, $destination);
      $arr_file = explode('.', $_FILES['fileexcel']['name']);
      $extension = end($arr_file);

      if ('csv' == $extension) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
      } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      }
      $spreadsheet = $reader->load($destination); // Load file yang tadi diupload ke folder tmp
      $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
      $last_column = $spreadsheet->getActiveSheet()->getHighestColumn();
      $count_pilihan_jawaban = (ord(strtolower($last_column)) - 96) - 3;
      $numrow = 1;
      $start_pilihan = "C";
      $explode_pilihan = explode(":", $sheet[1]['C']);
      $explode_tipe = explode(":", $sheet[2]['C']);
      $id_penugasan = base64_decode($explode_pilihan[1]);
      $tipe_soal = $explode_tipe[1];
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE id='$id_penugasan' AND tgl_hapus IS NULL");
      $tugas = mysqli_fetch_assoc($getpenugasan);
      $id_staff = $tugas['id_staff'];
      $kode_tugas = $tugas['kode_tugas'];
      $judul_tugas = $tugas['judul'];
      $id_mapel = $tugas['id_mapel'];
      foreach ($sheet as $row) {
        if ($numrow >= 8) {
          $soal = $row['B'];
          $kunci_jawaban = $row[$last_column];
          // Cek jika semua data tidak diisi
          if ($soal == "" && $kunci_jawaban == "") continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya
          $explode_kunci = explode(" ", $kunci_jawaban);
          $kunci = $explode_kunci[1];
          $query = mysqli_query($conn, "INSERT INTO arf_soal(id_staff, id_mapel, kode_tugas, tipe_soal, pertanyaan) VALUES('$id_staff','$id_mapel','$kode_tugas','$tipe_soal', '$soal')");
          $last_id = $conn->insert_id;
          for ($i = 1; $i <= $count_pilihan_jawaban; $i++) {
            $kunci_fix = ($i == $kunci) ? 1 : 0;
            $pilihan_jawaban = $row[$start_pilihan];
            $query = mysqli_query($conn, "INSERT INTO arf_kunci_soal(id_soal, jawaban, kunci) VALUE ('$last_id','$pilihan_jawaban','$kunci_fix')");
            $start_pilihan++;
          }
        }
        $start_pilihan = "C";
        $numrow++; // Tambah 1 setiap kali looping
      }
      unlink($destination); // Hapus file excel yg telah diupload, ini agar tidak terjadi penumpukan file

    }
    if ($query) {
      $data = ['acc' => true];
    } else {
      $data = ['acc' => false];
    }
    echo json_encode($data);
    break;

  case 'tambah_penugasan':
    break;

  case 'get_nilai_penugasan':
    $id_penugasan = $_POST['id_penugasan'];
    $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id='$id_penugasan'");
    $data_penugasan = mysqli_fetch_assoc($getpenugasan);
    $id_kelas = $data_penugasan['id_kelas'];
    $getsiswa = $conn->query(
      "SELECT ask.nis,ask.nama_siswa,ask.id_kelas_induk,ak.nama_kelas
      FROM arf_siswa_kelashistory ask
      JOIN arf_kelas ak ON ak.id=ask.id_kelas
      WHERE ak.id=$id_kelas 
      AND id_thajaran=$id_thajaran 
      AND id_semester=$semester"
    );
    require('../views/nilai_penugasan.php');
    break;
  case 'tambah_tugas_topik':
    //Validation
    $data['errors'] = [];
    $data['success'] = [];
    if (empty($_POST['id_topik'])) {
      $validation = ["id_topik" => "id_topik", "message" => "Topik pembelajaran tidak ditemukan."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "id_topik");
    }
    if (empty($_FILES['fileexcel']['name'])) {
      $validation = ["input" => "fileexcel", "message" => "File tugas tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "fileexcel");
    }
    if (empty($_POST['batas-tugas'])) {
      $validation = ["input" => "batas-tugas", "message" => "Batas tugas tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "batas-tugas");
    }
    if (empty($_POST['durasi-tugas'])) {
      if ($_POST['durasi-tugas'] == "0") {
        array_push($data['success'], "durasi-tugas");
      } else {
        $validation = ["input" => "durasi-tugas", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      }
    } else {
      array_push($data['success'], "durasi-tugas");
    }
    if (empty($_POST['jumlah_soal'])) {
      $validation = ["input" => "jumlah_soal", "message" => "Jumlah soal tidak boleh kosong atau 0."];
      array_push($data['errors'], $validation);
    } else {
      if ($_POST['jumlah_soal'] == "0") {
        $validation = ["input" => "jumlah_soal", "message" => "Jumlah soal tidak boleh kosong atau 0."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "jumlah_soal");
      }
    }

    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      $id_topik = $_POST['id_topik'];
      $gettopik = mysqli_query($conn, "SELECT * FROM topik_pembelajaran WHERE id='$id_topik' AND tgl_hapus IS NULL");
      $data_topik = mysqli_fetch_assoc($gettopik);
      $id_staff = $session_id_staf;
      $id_mapel = $data_topik['id_mapel'];
      $id_kelas = $data_topik['kelas'];
      $judul = $data_topik['judul'];
      $deskripsi = $data_topik['deskripsi'];
      $sub_tugas = "Tugas Awal";
      $pecahtugasawal = explode(" - ", $_POST['batas-tugas']);
      $tgl_tugasawal = date('Y-m-d', strtotime($pecahtugasawal[0]));
      $time_tugasawal = date('H:i:s', strtotime($pecahtugasawal[1]));
      $batas_tugas_awal = $tgl_tugasawal . ' ' . $time_tugasawal;
      $durasi_menit_tugas_awal = $_POST['durasi-tugas'];
      $jumlah_soal_tugas_awal = $_POST['jumlah_soal'];
      var_dump($_POST);
      die;
      // Input History Penugasan
      $query = $conn->query(
        "INSERT INTO arf_history_penugasan(id_staff, id_mapel, id_kelas, id_tahunajaran, judul, deskripsi, jenis_tugas) 
        VALUES('$id_staff','$id_mapel','$id_kelas','$id_thajaran','$judul','$deskripsi','$jenis_tugas')"
      );
      // End Input History Penugasan
      // Input Tugas Penugasan
      $id_penugasan = $conn->insert_id;
      $query = $conn->query(
        "INSERT INTO tugas_penugasan(id_penugasan, sub_tugas, batas_tugas, durasi_tugas, jumlah_soal) 
        VALUES('$id_penugasan','$sub_tugas','$batas_tugas_awal','$durasi_menit_tugas_awal','$jumlah_soal_tugas_awal')"
      );
      $id_tugas_penugasan = $conn->insert_id;
      // End Input Tugas Penugasan

      // Input Soal Tugas Penugasan
      if (isset($_FILES['fileexcel-tugas-awal'])) { // Jika user mengklik tombol Import
        $folder = "../tmp/";
        if (!file_exists($folder)) {
          mkdir($folder, 0777);
        }
        $file_name = $_FILES['fileexcel-tugas-awal']['name'];
        $source       = $_FILES["fileexcel-tugas-awal"]["tmp_name"];
        $destination  = $folder . $file_name;
        /* move the file */
        move_uploaded_file($source, $destination);
        $arr_file = explode('.', $_FILES['fileexcel-tugas-awal']['name']);
        $extension = end($arr_file);

        if ('csv' == $extension) {
          $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
          $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $reader->load($destination); // Load file yang tadi diupload ke folder tmp
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $last_column = $spreadsheet->getActiveSheet()->getHighestColumn();
        $count_pilihan_jawaban = (ord(strtolower($last_column)) - 96) - 3;
        $numrow = 1;
        $start_pilihan = "C";
        $tipe_soal = str_replace("Template Soal ", "", $sheet[1]['A']);
        foreach ($sheet as $row) {
          if ($numrow >= 5) {
            $soal = $row['B'];
            $kunci_jawaban = $row[$last_column];
            // Cek jika semua data tidak diisi
            if ($soal == "" && $kunci_jawaban == "") continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya
            $explode_kunci = explode(" ", $kunci_jawaban);
            $kunci = $explode_kunci[1];
            $query = mysqli_query($conn, "INSERT INTO soal_tugas_penugasan(id_tugas_penugasan, tipe_soal, pertanyaan) VALUES('$id_tugas_penugasan','$tipe_soal', '$soal')");
            $id_soal = $conn->insert_id;
            for ($i = 1; $i <= $count_pilihan_jawaban; $i++) {
              $kunci_fix = ($i == $kunci) ? 1 : 0;
              $pilihan_jawaban = $row[$start_pilihan];
              $query = mysqli_query($conn, "INSERT INTO jawaban_soal_tugas_penugasan(id_soal, jawaban, kunci) VALUE ('$id_soal','$pilihan_jawaban','$kunci_fix')");
              $start_pilihan++;
            }
          }
          $start_pilihan = "C";
          $numrow++; // Tambah 1 setiap kali looping
        }
        unlink($destination); // Hapus file excel yg telah diupload, ini agar tidak terjadi penumpukan file
      }
      // End Input Soal Tugas Penugasan

      if ($query) {
        $data = [
          "acc" => true,
          "success" => $data['success']
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
}

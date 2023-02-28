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
    if ($_GET['run'] == "lihat_penugasan") {
      $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
      $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
      $data_tugas_penugasan = mysqli_fetch_assoc($get_tugas_penugasan);
      require('../views/penugasan/lihat_tugas.php');
    } elseif ($_GET['run'] == "tambah_penugasan") {
      //Validation
      $data['errors'] = [];
      $data['success'] = [];
      if (empty($_POST['id_topik'])) {
        $validation = ["input" => "id_topik", "message" => "Topik pembelajaran tidak ditemukan."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "id_topik");
      }

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
        $id_topik = $_POST['id_topik'];
        $gettopik = mysqli_query($conn, "SELECT * FROM topik_pembelajaran WHERE id='$id_topik' AND tgl_hapus IS NULL");
        $data_topik = mysqli_fetch_assoc($gettopik);
        $id_mapel = $data_topik['id_mapel'];
        $id_kelas = $data_topik['id_kelas'];
        $id_thajaran = $data_topik['id_thajaran'];
        // Input Tugas Penugasan
        $id_penugasan = $conn->insert_id;
        $query = $conn->query(
          "INSERT INTO tugas_penugasan(id_topik, jenis_tugas, judul, deskripsi, batas_tugas, durasi_tugas, jumlah_soal) 
        VALUES('$id_topik','$jenis_tugas','$judul','$deskripsi','$batas_tugas','$durasi_menit_tugas','$jumlah_soal_tugas')"
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
    } elseif ($_GET['run'] == "nilai_penugasan") {
      $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
      $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
      $data_tugas_penugasan = mysqli_fetch_assoc($get_tugas_penugasan);
      $id_topik = $data_tugas_penugasan['id_topik'];
      $gettopik = mysqli_query($conn, "SELECT * FROM topik_pembelajaran WHERE id='$id_topik' AND tgl_hapus IS NULL");
      $data_topik = mysqli_fetch_assoc($gettopik);
      $id_kelas = $data_topik['id_kelas'];
      $getsiswa = $conn->query(
        "SELECT ask.nis,ask.nama_siswa,ask.id_kelas_induk,ak.nama_kelas
        FROM arf_siswa_kelashistory ask
        JOIN arf_kelas ak ON ak.id=ask.id_kelas
        WHERE ak.id=$id_kelas 
        AND id_thajaran=$id_thajaran 
        AND id_semester=$semester"
      );
      require('../views/penugasan/nilai_penugasan.php');
    } elseif ($_GET['run'] == "update_penugasan") {
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
      if (empty($_POST['batas-tugas'])) {
        $validation = ["input" => "batas-tugas", "message" => "Batas akhir tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "batas-tugas");
      }
      if (empty($_POST['durasi-tugas'])) {
        $validation = ["input" => "durasi-tugas", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "durasi-tugas");
      }
      if (empty($_POST['jumlah-soal-tugas'])) {
        $validation = ["input" => "jumlah-soal-tugas", "message" => "Jumlah soal tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "jumlah-soal-tugas");
      }
      if (!empty($data['errors'])) {
        $data['acc'] = false;
        echo json_encode($data);
      } else {
        $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $jenis_tugas = $_POST['jenis-tugas'];
        $batas_tugas = $_POST['batas-tugas'];
        $durasi_tugas = $_POST['durasi-tugas'];
        $jumlah_soal_tugas = $_POST['jumlah-soal-tugas'];

        // Update Topik
        $query = mysqli_query($conn, "UPDATE tugas_penugasan SET jenis_tugas='$jenis_tugas', judul='$judul', deskripsi='$deskripsi', batas_tugas='$batas_tugas', durasi_tugas='$durasi_tugas', jumlah_soal='$jumlah_soal_tugas' WHERE id='$id_tugas_penugasan'");
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
    } elseif ($_GET['run'] == "hapus_penugasan") {
      $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
      $today = date("Y-m-d h:i:s");
      $query = mysqli_query($conn, "UPDATE tugas_penugasan SET tgl_hapus='$today' WHERE id='$id_tugas_penugasan'");
      if ($query) {
        $data = "Hapus Data Sukses";
        echo json_encode($data);
      } else {
        $data = "Hapus Data Gagal: " . mysqli_error($conn);
        echo json_encode($data);
      }
    } elseif ($_GET['run'] == "penugasanbyid") {
      $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
      $getpenugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
      if ($getpenugasan->num_rows !== 0) {
        $data_penugasan = mysqli_fetch_assoc($getpenugasan);
        require('../views/penugasan/penugasanbyid.php');
      } else {
        $data = "Gagal Mengambil Data :" . mysqli_error($conn);
        echo $data;
      }
    }
    break;
  case 'proses_soal':
    if ($_GET['run'] == "hapus_soal") {
      $id_soal = $_POST['id_soal'];
      $today = date("Y-m-d h:i:s");
      $query = mysqli_query($conn, "UPDATE soal_tugas_penugasan SET tgl_hapus='$today' WHERE id='$id_soal'");
      if ($query) {
        $data = "Hapus Data Sukses";
        echo json_encode($data);
      } else {
        $data = "Hapus Data Gagal: " . mysqli_error($conn);
        echo json_encode($data);
      }
    } elseif ($_GET['run'] == "tambah_soal") {
      //Validation
      $data['errors'] = [];
      $data['success'] = [];

      if (empty($_FILES['fileexcel']['name'])) {
        $validation = ["input" => "fileexcel", "message" => "File awal tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "fileexcel");
      }
      if (!empty($data['errors'])) {
        $data['acc'] = false;
        echo json_encode($data);
      } else {
        $id_tugas_penugasan = $_POST['id_tugas_penugasan'];
        // Input Soal Tugas Penugasan
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
  case 'proses_materi':
    if ($_GET['run'] == "tambah_materi") {
      //Validation
      $data['errors'] = [];
      $data['success'] = [];
      if (empty($_POST['id_topik'])) {
        $validation = ["input" => "id_topik", "message" => "Topik pembelajaran tidak ditemukan."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "id_topik");
      }

      if (empty($_POST['judul'])) {
        $validation = ["input" => "judul", "message" => "Judul tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "judul");
      }

      if (empty($_FILES['filemateri']['name'])) {
        $validation = ["input" => "filemateri", "message" => "File materi tidak boleh kosong."];
        array_push($data['errors'], $validation);
      } else {
        array_push($data['success'], "filemateri");
      }

      if (!empty($data['errors'])) {
        $data['acc'] = false;
        echo json_encode($data);
      } else {
        $id_staf = $session_id_staf;
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $id_topik = $_POST['id_topik'];

        // Upload
        if (isset($_FILES['filemateri'])) {
          $folder = "../uploads/materi/";
          if (!file_exists($folder)) {
            mkdir($folder, 0777);
          }
          $file_name = $_FILES['filemateri']['name'];
          $query = $conn->query(
            "INSERT INTO materi_pembelajaran(id_topik, judul, deskripsi, file) 
        VALUES('$id_topik','$judul','$deskripsi','$file_name')"
          );
          if ($query) {
            $source       = $_FILES["filemateri"]["tmp_name"];
            $destination  = $folder . $file_name;
            /* move the file */
            move_uploaded_file($source, $destination);
          }
        }
        // End Upload

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
    } elseif ($_GET['run'] == "lihat_materi") {
      $id_materi = $_POST['id_materi'];
      $getmateri = mysqli_query($conn, "SELECT * FROM materi_pembelajaran WHERE id='$id_materi' AND tgl_hapus IS NULL");
      $data_materi = mysqli_fetch_assoc($getmateri);
      require('../views/materi/lihat_materi.php');
    } elseif ($_GET['run'] == "hapus_materi") {
      $id_materi = $_POST['id_materi'];
      $getmateri = mysqli_query($conn, "SELECT * FROM materi_pembelajaran WHERE id='$id_materi' AND tgl_hapus IS NULL");
      $data_materi = mysqli_fetch_assoc($getmateri);
      $folder = "../uploads/materi/";
      $file_name = $data_materi['file'];
      $destination = $folder . $file_name;
      $query = mysqli_query($conn, "DELETE FROM materi_pembelajaran WHERE id='$id_materi'");
      if ($query) {
        $delete = unlink($destination); // Hapus file excel yg telah diupload, ini agar tidak terjadi penumpukan file
        if ($delete) {
          $data = "Hapus File Sukses";
        } else {
          $data = "Hapus File Gagal: ";
        }
      } else {
        $data = "Hapus Data Gagal: " . mysqli_error($conn);
      }
      echo json_encode($data);
    }
    break;
}

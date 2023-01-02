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
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY waktu_selesai DESC");
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
    if (empty($_POST['kode_soal'])) {
      $validation = ["input" => "kode_soal", "message" => "Kode tugas tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "kode_soal");
    }
    if (empty($_POST['batas-akhir'])) {
      $validation = ["input" => "batas-akhir", "message" => "Batas akhir penugasan tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "batas-akhir");
    }
    if (empty($_POST['durasi'])) {
      if ($_POST['durasi'] == "0") {
        array_push($data['success'], "durasi");
      } else {
        $validation = ["input" => "durasi", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      }
    } else {
      array_push($data['success'], "durasi");
    }
    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      $pecahtgl = explode(" - ", $_POST['batas-akhir']);
      $tgl = date('Y-m-d', strtotime($pecahtgl[0]));
      $time = date('H:i:s', strtotime($pecahtgl[1]));
      $tgl_akhir = $tgl . ' ' . $time;
      // Inputan Soal
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['mapel'];
      $id_kelas = $_POST['kelas'];
      $judul = $_POST['judul-penugasan'];
      $deskripsi = $_POST['deskripsi-penugasan'];
      $kode_tugas = $_POST['kode_soal'];
      $batas_awal = date("Y-m-d H:i:s");
      $batas_akhir = $tgl_akhir;
      $durasi = $_POST['durasi'];
      // End Inputan Soal
      // Input Soal
      $query = mysqli_query($conn, "INSERT INTO arf_history_penugasan(id_staff, id_mapel, id_kelas, judul, deskripsi, kode_tugas, waktu_mulai, waktu_selesai, durasi_menit) VALUES('$id_staff','$id_mapel','$id_kelas','$judul','$deskripsi','$kode_tugas','$batas_awal','$batas_akhir','$durasi')");
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
      $kode_tugas = $penugasan['kode_tugas'];
      $gettugas = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
      $datatugas = mysqli_fetch_assoc($gettugas);
      $jenis_tugas = $datatugas['jenis'];
      $gettugas_all = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE jenis='$jenis_tugas' AND tgl_hapus IS NULL");
      $getjenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
      $get_date = date('Y-m-d', strtotime($penugasan['waktu_selesai']));
      $get_time = date('H:i:s', strtotime($penugasan['waktu_selesai']));
      $current_date = $get_date . 'T' . $get_time . 'Z';
?>
      <form role="form" class="form-edit-penugasan" id="form-edit-penugasan">
        <input type="hidden" class="form-control" name="id-editpenugasan" value="<?= $penugasan['id'] ?>">
        <div class="form-body">
          <div class="form-group" id="form-judul-editpenugasan">
            <label class="control-label">Judul Penugasan</label>
            <input class="form-control spinner" type="text" id="judul-editpenugasan" name="judul-editpenugasan" placeholder="Judul penugasan..." value="<?= $penugasan['judul'] ?>">
            <div id="pesan-judul-editpenugasan"></div>
          </div>
          <div class="form-group" id="form-deskripsi-editpenugasan">
            <label class="control-label">Deskripsi penugasan</label>
            <textarea class="form-control" id="deskripsi-editpenugasan" name="deskripsi-editpenugasan" rows="3" placeholder="Deskripsi penugasan..."><?= $penugasan['deskripsi'] ?></textarea>
            <div id="pesan-deskripsi-editpenugasan"></div>
          </div>
          <div class="form-group" id="form-jenis-edittugas">
            <label class="control-label">Jenis Tugas</label>
            <select class="form-control jenis-edittugas" id="jenis-edittugas" name="jenis-edittugas">
              <option></option>
              <?php while ($jenis = mysqli_fetch_array($getjenis_tugas)) :
                $select = ($jenis['jenis_tugas'] == $jenis_tugas) ? "selected" : ""; ?>
                <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
              <?php endwhile; ?>
            </select>
            <div id="pesan-jenis-edittugas"></div>
          </div>
          <div class="form-group" id="form-kode_soal-editpenugasan">
            <label for="kode_soal" class="control-label">Tugas</label>
            <select class="form-control" id="kode_soal-editpenugasan" name="kode_soal-editpenugasan">
              <?php while ($tugas = mysqli_fetch_array($gettugas_all)) :
                $select = ($tugas['kode_tugas'] == $kode_tugas) ? "selected" : ""; ?>
                <option value="<?= $tugas['kode_tugas'] ?>" <?= $select ?>>(<?= $tugas['kode_tugas'] ?>) <?= $tugas['judul'] ?></option>
              <?php endwhile; ?>
            </select>
            <div id="pesan-kode_soal-editpenugasan"></div>
          </div>
          <div class="note note-info">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group" id="form-batas-akhir-editpenugasan">
                  <label class="control-label"><strong>Batas akhir penugasan</strong></label><br>
                  <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
                    <input type="text" class="form-control" id="batas-akhir-editpenugasan" name="batas-akhir-editpenugasan" value="<?= $penugasan['waktu_selesai'] ?>">
                    <span class="input-group-btn">
                      <button class="btn default date-reset" type="button">
                        <i class="fa fa-times"></i>
                      </button>
                      <button class="btn default date-set" type="button">
                        <i class="fa fa-calendar"></i>
                      </button>
                    </span>
                  </div>
                  <div id="pesan-batas-akhir-editpenugasan"></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" id="form-durasi-editpenugasan">
                  <label class="control-label"><strong>Waktu pengerjaan</strong></label><br>
                  <div class="input-group">
                    <input type="text" class="form-control text-right" id="durasi-editpenugasan" name="durasi-editpenugasan" value="<?= $penugasan['durasi_menit'] ?>">
                    <span class="input-group-btn">
                      <button class="btn default date-set" type="button">
                        menit
                      </button>
                    </span>
                  </div>
                  <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
                  <div id="pesan-durasi-editpenugasan"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions right">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn green btn_simpan_edit">Simpan</button>
        </div>
      </form>
      <script>
        $(document).ready(function() {
          $('#jenis-edittugas').on('select2:select', function(e) {
            var id_mapel = '<?= $penugasan['id_mapel'] ?>';
            var jenis_tugas = $(this).val();
            $.ajax({
              url: 'backend/function.php?action=get_data&get=data_tugas',
              type: 'post',
              data: {
                jenis_tugas: jenis_tugas,
                id_mapel: id_mapel
              },
              dataType: 'json',
              success: function(data) {
                var html = '';
                for (i = 0; i < data.length; i++) {
                  html += '<option value="' + data[i].kode_tugas + '">(' + data[i].kode_tugas + ') ' + data[i].judul + '</option>';
                }
                $('#kode_soal-editpenugasan').html(html);
                $('#kode_soal-editpenugasan').trigger('change');
              }
            });
          });
          $("#form-edit-penugasan").on("submit", function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
              url: 'backend/function.php?action=edit_data_penugasan',
              type: 'post',
              data: formdata,
              dataType: 'json',
              success: function(data) {
                $('#modal-edit-penugasan').modal('hide');
                get_penugasan();
                get_penugasan_akanberakhir();
              }
            });
          });
          $('.form_datetime').datetimepicker();
        });
      </script>
<?php
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
    if (empty($_POST['kode_soal-editpenugasan'])) {
      $validation = ["input" => "kode_soal-editpenugasan", "message" => "Kode tugas tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "kode_soal-editpenugasan");
    }
    if (empty($_POST['batas-akhir-editpenugasan'])) {
      $validation = ["input" => "batas-akhir-editpenugasan", "message" => "Batas akhir penugasan tidak boleh kosong."];
      array_push($data['errors'], $validation);
    } else {
      array_push($data['success'], "batas-akhir-editpenugasan");
    }
    if (empty($_POST['durasi-editpenugasan'])) {
      if ($_POST['durasi-editpenugasan'] == "0") {
        array_push($data['success'], "durasi-editpenugasan");
      } else {
        $validation = ["input" => "durasi-editpenugasan", "message" => "Waktu pengerjaan tidak boleh kosong."];
        array_push($data['errors'], $validation);
      }
    } else {
      array_push($data['success'], "durasi-editpenugasan");
    }
    // End Validation
    if (!empty($data['errors'])) {
      $data['acc'] = false;
      echo json_encode($data);
    } else {
      $pecahtgl = explode(" ", $_POST['batas-akhir-editpenugasan']);
      $tgl = date('Y-m-d', strtotime($pecahtgl[0]));
      $time = date('H:i:s', strtotime($pecahtgl[1]));
      $tgl_akhir = $tgl . ' ' . $time;
      // Inputan Soal
      $id_penugasan = $_POST['id-editpenugasan'];
      $judul = $_POST['judul-editpenugasan'];
      $deskripsi = $_POST['deskripsi-editpenugasan'];
      $kode_tugas = $_POST['kode_soal-editpenugasan'];
      $batas_awal = date("Y-m-d H:i:s");
      $batas_akhir = $tgl_akhir;
      $durasi = $_POST['durasi-editpenugasan'];
      // End Inputan Soal
      // Input Soal
      $query = mysqli_query($conn, "UPDATE arf_history_penugasan SET judul='$judul', deskripsi='$deskripsi', kode_tugas='$kode_tugas', waktu_mulai='$batas_awal', waktu_selesai='$batas_akhir', durasi_menit='$durasi' WHERE id='$id_penugasan'");
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

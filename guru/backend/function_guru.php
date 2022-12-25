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
      if ($getsoal->num_rows == 0) {
?>
        <div class="row">
          <div class="col-md-12 text-center" style="opacity: 0.5;">
            <img src="assets/images/no-content.png" alt="No Content">
            <h3>Belum ada soal</h3>
          </div>
        </div>
        <?php
      } else {
        $no = 1;
        while ($row = mysqli_fetch_assoc($getsoal)) {
        ?>
          <li>
            <div class="col1">
              <div class="cont">
                <div class="cont-col1">
                  <div class="label label-sm label-success" style="width: 20px; height: max-content; color:white;">
                    <?= $no ?>
                  </div>
                </div>
                <div class="cont-col2">
                  <div class="desc" style="color:black;">
                    <?= $row['pertanyaan'] ?>
                  </div>
                  <div class="desc" style="color:black;">
                    <?php
                    $id_soal = $row['id'];
                    $getjawaban = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
                    if ($getjawaban) : ?>
                      <div class="form-group">
                        <div class="mt-radio-list">
                          <?php while ($kunci_row = mysqli_fetch_assoc($getjawaban)) :
                            if ($kunci_row['kunci'] == "1") {
                              $check = "checked";
                              $label = "<b style='background-color:#32c5d254;padding:5px;'>" . $kunci_row['jawaban'] . "</b>";
                            } else {
                              $check = "";
                              $label = $kunci_row['jawaban'];
                            }
                          ?>
                            <label class="mt-radio">
                              <input type="radio" name="kunci_<?= $kunci_row['id'] ?>" id="kunci_<?= $kunci_row['id'] ?>" value="<?= $kunci_row['jawaban'] ?>" disabled <?= $check ?>>
                              <?= $label ?>
                              <span></span>
                            </label>
                          <?php endwhile; ?>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col2">
              <a href="javascript:;" class="btn btn-circle btn-icon-only green edit-soal" data-id="<?= $row['id'] ?>"><i class="fa fa-edit"></i></a>
              <a href="javascript:;" class="btn btn-circle btn-icon-only red hapus-soal" data-id="<?= $row['id'] ?>"><i class="fa fa-trash"></i></a>
            </div>
          </li>
        <?php
          $no++;
        }
      }
    } elseif ($_GET['get'] == 'data_soal_id') {
      $id_soal = $_POST['id_soal'];
      $tipe_soal = mysqli_query($conn, "SELECT * FROM arf_master_soal WHERE tgl_hapus IS NULL");
      $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE id='$id_soal' AND tgl_hapus IS NULL");
      $getjawaban = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
      if ($getsoal) {
        $soal = mysqli_fetch_assoc($getsoal);
        ?>
        <form role="form" class="form-edit-soal" id="form-edit-soal">
          <input type="hidden" class="form-control" name="id_soal" value="<?= $soal['id'] ?>">
          <div class="form-body">
            <div class="form-group" id="form-edit-tipe-soal">
              <label class="control-label">Tipe Pertanyaan</label>
              <select class="form-control" id="tipe-soal" name="tipe-soal">
                <?php while ($row = mysqli_fetch_assoc($tipe_soal)) :
                  $select = ($row['tipe_soal'] == $soal['tipe_soal']) ? "selected" : ""; ?>
                  <option value="<?= $row['tipe_soal'] ?>" <?= $select ?>><?= $row['tipe_soal'] ?></option>
                <?php endwhile; ?>
              </select>
              <div id="pesan-edit-tipe-soal"></div>
            </div>
            <div class="form-group" id="form-edit-pertanyaan">
              <label class="control-label">Pertanyaan</label>
              <textarea class="form-control col-md-4" id="pertanyaan" name="pertanyaan" rows="3" style="margin-bottom: 20px;"><?= $soal['pertanyaan'] ?></textarea>
              <div id="pesan-edit-pertanyaan"></div>
            </div>
            <div id="jawaban-edit" style="padding: 20px;">
              <div class="form-group">
                <label class="control-label">Pilihan Jawaban</label>
              </div>
              <?php $no = 1;
              while ($row = mysqli_fetch_assoc($getjawaban)) :
                $check = ($row['kunci'] == "1") ? "checked" : ""; ?>
                <div class="form-group" id="form-edit-pilihan-<?= $no ?>">
                  <div class="input-group" style="margin-top: 5px; margin-bottom: 5px;">
                    <span class="input-group-addon">
                      <input type="radio" name="radio-pilihan" value="<?= $no ?>" <?= $check ?>>
                      <span></span>
                    </span>
                    <input type="text" class="form-control" name="pilihan-<?= $no ?>" value="<?= $row['jawaban'] ?>">
                  </div>
                  <div id="pesan-edit-pilihan-<?= $no ?>"></div>
                  <?php if ($no == 4) : ?>
                    <div id="pesan-edit-radio-pilihan"></div>
                  <?php endif; ?>
                </div>
              <?php $no++;
              endwhile; ?>
            </div>
          </div>
          <div class="form-actions right">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn green">Simpan</button>
          </div>
        </form>
      <?php
      } else {
        $data = "Gagal Mengambil Data :" . mysqli_error($conn);
        echo $data;
      }
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
      if ($getpenugasan->num_rows == 0) {
      ?>
        <div class="row">
          <div class="col-md-12 text-center" style="opacity: 0.5;">
            <img src="assets/images/no-content.png" alt="No Content">
            <h3>Belum ada penugasan</h3>
          </div>
        </div>
        <?php
      } else {
        while ($row = mysqli_fetch_assoc($getpenugasan)) {
          $pecahtglinput = explode(" ", $row['tgl_input']);
          $tgl_input = date("d-m-Y", strtotime($pecahtglinput[0]));
          $jam_input = date("H:i", strtotime($pecahtglinput[1]));
          $pecahtglselesai = explode(" ", $row['waktu_selesai']);
          $tgl_selesai = date("Y-m-d", strtotime($pecahtglselesai[0]));
          $jam_selesai = date("H:i", strtotime($pecahtglselesai[1]));
        ?>
          <div class="note note-info">
            <div class="mt-comments">
              <div class="mt-comment">
                <div class="mt-comment-body">
                  <div class="mt-comment-info">
                    <span class="mt-comment-author"><?= $row['judul'] ?></span>
                    <span class="mt-comment-date"><?= $tgl_input . ", " . $jam_input ?> WIB</span>
                  </div>
                  <div class="mt-comment-text"> <?= $row['deskripsi'] ?> </div>
                  <div class="alert alert-info" style="margin-top:10px;">
                    <strong>
                      <i class="fa fa-calendar"></i> Batas Akhir <?= tgl_indo($tgl_selesai) . ", " . $jam_selesai ?> WIB
                    </strong>
                  </div>
                  <div class="mt-comment-details">
                    <span class="mt-comment-status mt-comment-status-pending">
                      <div class="row">
                        <div class="col-md-12">
                          <a href="javascript:;" class="btn btn-circle default green-stripe lihat_tugas" id="lihat_tugas" data-kode="<?= $row['kode_tugas'] ?>"><?= $row['kode_tugas'] ?></a>
                          <span style="color:#327ad5;padding-top:7px;text-transform: none;">!klik untuk melihat</span>
                        </div>
                      </div>
                    </span>
                    <ul class="mt-comment-actions">
                      <li>
                        <a href="javascript:;" class="edit-penugasan" data-id="<?= $row['id'] ?>">Edit</a>
                      </li>
                      <li>
                        <a href="javascript:;" class="hapus-penugasan" data-id="<?= $row['id'] ?>">Hapus</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
        }
      }
    } elseif ($_GET['get'] == "data_penugasan_akanberakhir") {
      $id_staff = $session_id_staf;
      $id_mapel = $_POST['id_mapel'];
      $id_kelas = $_POST['id_kelas'];
      $datenow = date("Y-m-d H:i:s");
      $getpenugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_staff='$id_staff' AND id_mapel='$id_mapel' AND id_kelas='$id_kelas' AND tgl_hapus IS NULL ORDER BY waktu_selesai DESC");
      if ($getpenugasan->num_rows == 0) {
        ?>
        <div class="alert alert-info" style="margin-left:30px;">
          <a href="javascript:;">
            Tidak ada tugas!
          </a>
        </div>
        <?php
      } else {
        while ($row = mysqli_fetch_assoc($getpenugasan)) {
          $pecahtgl = explode(" ", $row['waktu_selesai']);
          $tgl_selesai = date("d-m-Y", strtotime($pecahtgl[0]));
          $jam_selesai = date("H:i", strtotime($pecahtgl[1]));
        ?>
          <?php if ($datenow <= $row['waktu_selesai']) : ?>
            <div class="alert alert-info" style="margin-left:30px;">
              <a href="javascript:;">
                <b style="margin-left: -10px;"><?= $tgl_selesai . ", " . $jam_selesai ?> WIB</b><br>
                (<?= $row['kode_tugas'] ?>) <?= $row['judul'] ?>
              </a>
            </div>
          <?php endif; ?>
      <?php
        }
      }
    } elseif ($_GET['get'] == "lihat_tugas") {
      $kode_tugas = $_POST['kode_tugas'];
      $gettugas = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
      $datatugas = mysqli_fetch_assoc($gettugas);
      $id_tugas = $datatugas['id'];
      ?>
      <div class="portlet light bordered">
        <div class="portlet-body">
          <div class="row">
            <div class="col-md-12 profile-info" style="padding-right: 50px;padding-left: 50px;margin-bottom: 50px;">
              <a href="javascript:;" class="btn btn-circle default green-stripe" id="text-kode">KODE: <?= $datatugas['kode_tugas'] ?></a>
              <h2 class="font-green sbold uppercase" id="text-judul"><?= $datatugas['judul'] ?></h2>
              <p id="text-deskripsi"><?= $datatugas['deskripsi'] ?></p>
              <ul class="list-inline">
                <li id="text-jenis">
                  <i class="fa fa-briefcase"></i> <?= $datatugas['jenis'] ?>
                </li>
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="portlet light bordered">
                <div class="portlet-title">
                  <div class="caption">
                    <i class="icon-bubble font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">SOAL</span>
                  </div>
                </div>
                <div class="portlet-body">
                  <ul class="feeds">
                    <?php
                    $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
                    if ($getsoal) {
                      $no = 1;
                      while ($row = mysqli_fetch_assoc($getsoal)) {
                    ?>
                        <li>
                          <div class="col1">
                            <div class="cont">
                              <div class="cont-col1">
                                <div class="label label-sm label-success" style="width: 20px; height: max-content; color:white;">
                                  <?= $no ?>
                                </div>
                              </div>
                              <div class="cont-col2">
                                <div class="desc" style="color:black;">
                                  <?= $row['pertanyaan'] ?>
                                </div>
                                <div class="desc" style="color:black;">
                                  <?php
                                  $id_soal = $row['id'];
                                  $getjawaban = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
                                  if ($getjawaban) : ?>
                                    <div class="form-group">
                                      <div class="mt-radio-list">
                                        <?php while ($kunci_row = mysqli_fetch_assoc($getjawaban)) :
                                          if ($kunci_row['kunci'] == "1") {
                                            $check = "checked";
                                            $label = "<b style='background-color:#32c5d254;padding:5px;'>" . $kunci_row['jawaban'] . "</b>";
                                          } else {
                                            $check = "";
                                            $label = $kunci_row['jawaban'];
                                          }
                                        ?>
                                          <label class="mt-radio">
                                            <input type="radio" name="kunci_<?= $kunci_row['id'] ?>" id="kunci_<?= $kunci_row['id'] ?>" value="<?= $kunci_row['jawaban'] ?>" disabled <?= $check ?>>
                                            <?= $label ?>
                                            <span></span>
                                          </label>
                                        <?php endwhile; ?>
                                      </div>
                                    </div>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                    <?php
                        $no++;
                      }
                    } else {
                      $data = "Gagal Mengambil Data :" . mysqli_error($conn);
                      echo $data;
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
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
              url: 'backend/function_guru.php?action=get_data&get=data_tugas',
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
              url: 'backend/function_guru.php?action=edit_data_penugasan',
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

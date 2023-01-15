<?php
require('backend/connection.php');
$page_title = "Detail Kelas";
require('layouts/headlayout.php');
$id_kelas = $_GET['kelas'];
$id_subkelas = $_GET['subkelas'];
$getkelasmapel = mysqli_query(
  $conn,
  "SELECT ak.id AS id_kelas,ak.nama_kelas,ak.parent_id,am.id AS id_mapel,am.nama_mapel,ak.program_keahlian,stf.nama_lengkap,stf.email 
  FROM arf_guru_mapel agm 
  JOIN arf_staf stf ON stf.nip=agm.id_staf 
  JOIN arf_mapel am ON am.id=agm.id_mapel 
  JOIN arf_kelas ak ON ak.id=agm.id_subkelas 
  WHERE ak.id=$id_subkelas 
  AND agm.id_staf='$session_id_staf' 
  AND agm.id_thajaran=$id_thajaran"
);
$datakelas = mysqli_fetch_assoc($getkelasmapel);
if ($datakelas['parent_id'] == 1) {
  $grade = "X";
} elseif ($datakelas['parent_id'] == 2) {
  $grade = "XI";
} elseif ($datakelas['parent_id'] == 3) {
  $grade = "XII";
}
$id_mapel = $datakelas['id_mapel'];
$getsiswa = $conn->query(
  "SELECT ask.nis,ask.nama_siswa,asw.email_siswa,ask.id_kelas_induk,ak.nama_kelas,ak.program_keahlian
   FROM arf_siswa_kelashistory ask
   JOIN arf_siswa asw ON asw.nis=ask.nis
   JOIN arf_kelas ak ON ak.id=ask.id_kelas
   WHERE id_kelas_induk=$id_kelas 
   AND id_kelas=$id_subkelas 
   AND id_thajaran=$id_thajaran 
   AND id_semester=$semester"
);
$countsiswa = $getsiswa->num_rows;
$jenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
$getsoal = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE id_staff='$session_id_staf' AND id_mapel='$id_mapel' AND tgl_hapus IS NULL");
$get_date = date('Y-m-d');
$get_time = date('H:i:s');
$current_date = $get_date . 'T' . $get_time . 'Z';
?>
<input class="form-control" type="hidden" id="id-mapel" name="id-mapel" value="<?= $id_mapel ?>">
<input class="form-control" type="hidden" id="id-kelas" name="id-kelas" value="<?= $datakelas['id_kelas'] ?>">
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <!-- BEGIN CONTENT BODY -->
  <div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
        <h1><?= "Kelas " . $grade . " " . $datakelas['nama_kelas'] . " - " . $datakelas['program_keahlian'] ?>
        </h1>
      </div>
      <!-- END PAGE TITLE -->
    </div>
    <!-- END PAGE HEAD-->
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
      <li>
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
      </li>
      <li>
        <span class="active">User</span>
      </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="profile">
      <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#tab_overview" data-toggle="tab"> Overview </a>
          </li>
          <li>
            <a href="#tab_peserta" data-toggle="tab"> Peserta Didik </a>
          </li>
          <li>
            <a href="#tab_penugasan" data-toggle="tab"> Penugasan </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_overview">
            <div class="row">
              <div class="col-md-12">
                <div class="profile-sidebar">
                  <!-- PORTLET MAIN -->
                  <div class="portlet light profile-sidebar-portlet">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                      <img src="assets/images/admin_avatar.png" class="img-responsive" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                      <div class="profile-usertitle-name"> <?= $datakelas['nama_lengkap'] ?> </div>
                      <div class="profile-usertitle-job"> Guru </div>
                      <div class="profile-desc-link">
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:<?= $datakelas['nama_kelas'] ?>"><?= $datakelas['email'] ?></a>
                      </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="margin-top-20 profile-userbuttons">
                      <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                      <button type="button" class="btn btn-circle red btn-sm">Message</button>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                  </div>
                  <!-- END PORTLET MAIN -->
                </div>
                <div class="profile-info">
                  <h1 class="font-green sbold uppercase"><?= $datakelas['nama_mapel'] ?></h1>
                  <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt laoreet dolore magna aliquam tincidunt erat volutpat laoreet dolore magna aliquam tincidunt erat volutpat.
                  </p>
                  <p>
                    <a href="javascript:;"> www.mywebsite.com </a>
                  </p>
                  <ul class="list-inline">
                    <li>
                      <i class="fa fa-map-marker"></i> <?= $grade . " " . $datakelas['nama_kelas'] ?>
                    </li>
                    <li>
                      <i class="fa fa-users"></i> <?= $countsiswa ?> Siswa
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!--tab_1_2-->
          <div class="tab-pane" id="tab_peserta">
            <div class="mt-comments">
              <?php $no = 1;
              while ($datasiswa = mysqli_fetch_array($getsiswa)) : ?>
                <div class="mt-comment">
                  <div class="mt-comment-img">
                    <?= $no ?>
                    <img src="assets/images/person_avatar.png" style="width:100%;">
                  </div>
                  <div class="mt-comment-body">
                    <div class="mt-comment-info">
                      <span class="mt-comment-author"><?= $datasiswa['nama_siswa'] ?></span>
                      <!-- <span class="mt-comment-date">26 Feb, 10:30AM</span> -->
                    </div>
                    <?php
                    if ($datasiswa['id_kelas_induk'] == 1) {
                      $grade = "X";
                    } elseif ($datasiswa['id_kelas_induk'] == 2) {
                      $grade = "XI";
                    } elseif ($datasiswa['id_kelas_induk'] == 3) {
                      $grade = "XII";
                    } ?>
                    <div class="mt-comment-text">NIS: <?= $datasiswa['nis'] ?> <?= (!empty($datasiswa['email_siswa'])) ? "- EMAIL : " . $datasiswa['email_siswa'] : "" ?> <br>Kelas: <?= $grade . " " . $datasiswa['nama_kelas'] . " (" . $datasiswa['program_keahlian'] . ")" ?></div>
                  </div>
                </div>
                <?php $no++; ?>
              <?php endwhile; ?>
            </div>
          </div>
          <!--end tab-pane-->
          <div class="tab-pane" id="tab_penugasan">
            <div class="todo-ui">
              <div class="todo-sidebar">
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                      <span class="caption-subject font-green-sharp bold uppercase">Menu </span>
                      <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">Klik untuk melihat menu</span>
                    </div>
                  </div>
                  <div class="portlet-body todo-project-list-content" style="height: auto;">
                    <div class="todo-project-list">
                      <ul class="nav nav-stacked">
                        <li>
                          <a href="javascript:;" data-toggle="collapse" data-target=".akan-berakhir"> Tugas Akan Berakhir </a>
                          <div id="show_akan_berakhir">

                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption">
                      <button type="button" class="btn btn-circle green" id="btn-nilai">Nilai</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="todo-content">
                <form class="form-horizontal" role="form" id="form-edit-tugas">
                  <div class="form-body">
                    <div class="form-group">
                      <label class="col-md-1 control-label vcenter">
                        <img alt="" class="img-circle bg-white" style="padding:2px;width:40px;" src="assets/images/admin_avatar.png" />
                      </label>
                      <div class="col-md-9 vcenter" style="padding-top:7px;">
                        <input class="form-control" type="hidden" id="id_tugas" name="id_tugas" value="">
                        <input class="form-control spinner input-circle" type="text" id="tambah-penugasan" name="tambah-penugasan" placeholder="Tambah penugasan..." value="">
                      </div>
                    </div>
                  </div>
                </form>
                <hr>
                <div id="show_penugasan">

                </div>
              </div>
            </div>
          </div>
          <!--end tab-pane-->
        </div>
      </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
  </div>
  <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

<!-- MODAL TAMBAH PENUGASAN -->
<div class="modal fade bs-modal-lg" id="modal-tambah-penugasan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah penugasan</h4>
      </div>
      <form role="form" id="form-tambah-penugasan">
        <div class="modal-body form">
          <div class="form-body">
            <div class="form-group" id="form-judul-penugasan">
              <label class="control-label">Judul Penugasan</label>
              <input class="form-control" type="hidden" id="mapel" name="mapel" value="<?= $id_mapel ?>">
              <input class="form-control" type="hidden" id="kelas" name="kelas" value="<?= $datakelas['id_kelas'] ?>">
              <input class="form-control spinner" type="text" id="judul-penugasan" name="judul-penugasan" placeholder="Judul penugasan..." value="">
              <div id="pesan-judul-penugasan"></div>
            </div>
            <div class="form-group" id="form-deskripsi-penugasan">
              <label class="control-label">Deskripsi penugasan</label>
              <textarea class="form-control" id="deskripsi-penugasan" name="deskripsi-penugasan" rows="3" placeholder="Deskripsi penugasan..."></textarea>
              <div id="pesan-deskripsi-penugasan"></div>
            </div>
            <div class="form-group" id="form-jenis-tugas">
              <label class="control-label">Jenis Tugas</label>
              <select class="form-control select2" id="jenis-tugas" name="jenis-tugas">
                <option></option>
                <?php while ($jenis = mysqli_fetch_array($jenis_tugas)) :
                  $select = ($jenis['jenis_tugas'] == $tugas['jenis']) ? "selected" : ""; ?>
                  <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
                <?php endwhile; ?>
              </select>
              <div id="pesan-jenis-tugas"></div>
            </div>
            <div class="note note-info">
              <div class="row col-md-12">
                <div class="form-group" id="form-tugas-awal">
                  <label for="tugas-awal" class="control-label"><strong>Tugas Awal</strong></label>
                  <select class="form-control select2" id="tugas-awal" name="tugas-awal">
                    <option></option>
                  </select>
                  <div id="pesan-tugas-awal"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-xl-12">
                  <div class="form-group" id="form-batas-tugas-awal">
                    <label class="control-label">Batas akhir</label><br>
                    <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
                      <input type="text" class="form-control" id="batas-tugas-awal" name="batas-tugas-awal">
                      <span class="input-group-btn">
                        <button class="btn default date-reset" type="button">
                          <i class="fa fa-times"></i>
                        </button>
                        <button class="btn default date-set" type="button">
                          <i class="fa fa-calendar"></i>
                        </button>
                      </span>
                    </div>
                    <div id="pesan-batas-tugas-awal"></div>
                  </div>
                </div>
                <div class="col-md-3 col-xl-12">
                  <div class="form-group" id="form-durasi-tugas-awal">
                    <label class="control-label">Waktu pengerjaan</label><br>
                    <div class="input-group">
                      <input type="text" class="form-control text-right" id="durasi-tugas-awal" name="durasi-tugas-awal">
                      <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                          menit
                        </button>
                      </span>
                    </div>
                    <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
                    <div id="pesan-durasi-tugas-awal"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="note note-warning" style="background-color: #fcf8e3;">
              <div class="row col-md-12">
                <div class="form-group" id="form-r1">
                  <label for="r1" class="control-label"><strong>Remidi 1</strong></label>
                  <select class="form-control select2" id="r1" name="r1">
                    <option></option>
                  </select>
                  <div id="pesan-r1"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-xl-12">
                  <div class="form-group" id="form-batas-r1">
                    <label class="control-label">Batas akhir</label><br>
                    <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
                      <input type="text" class="form-control" id="batas-r1" name="batas-r1">
                      <span class="input-group-btn">
                        <button class="btn default date-reset" type="button">
                          <i class="fa fa-times"></i>
                        </button>
                        <button class="btn default date-set" type="button">
                          <i class="fa fa-calendar"></i>
                        </button>
                      </span>
                    </div>
                    <div id="pesan-batas-r1"></div>
                  </div>
                </div>
                <div class="col-md-3 col-xl-12">
                  <div class="form-group" id="form-durasi-r1">
                    <label class="control-label">Waktu pengerjaan</label><br>
                    <div class="input-group">
                      <input type="text" class="form-control text-right" id="durasi-r1" name="durasi-r1">
                      <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                          menit
                        </button>
                      </span>
                    </div>
                    <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
                    <div id="pesan-durasi-r1"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="note note-warning" style="background-color: #fcf8e3;">
              <div class="row col-md-12">
                <div class="form-group" id="form-r2">
                  <label for="r2" class="control-label"><strong>Remidi 2</strong></label>
                  <select class="form-control select2" id="r2" name="r2">
                    <option></option>
                  </select>
                  <div id="pesan-r2"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-xl-12">
                  <div class="form-group" id="form-batas-r2">
                    <label class="control-label">Batas akhir</label><br>
                    <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
                      <input type="text" class="form-control" id="batas-r2" name="batas-r2">
                      <span class="input-group-btn">
                        <button class="btn default date-reset" type="button">
                          <i class="fa fa-times"></i>
                        </button>
                        <button class="btn default date-set" type="button">
                          <i class="fa fa-calendar"></i>
                        </button>
                      </span>
                    </div>
                    <div id="pesan-batas-r2"></div>
                  </div>
                </div>
                <div class="col-md-3 col-xl-12">
                  <div class="form-group" id="form-durasi-r2">
                    <label class="control-label">Waktu pengerjaan</label><br>
                    <div class="input-group">
                      <input type="text" class="form-control text-right" id="durasi-r2" name="durasi-r2">
                      <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                          menit
                        </button>
                      </span>
                    </div>
                    <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
                    <div id="pesan-durasi-r2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn green">Publish</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL TAMBAH PENUGASAN -->
<!-- MODAL LIHAT TUGAS -->
<div class="modal fade bs-modal-lg" id="modal-lihat-tugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Lihat Tugas</h4>
      </div>
      <div class="modal-body" id="show_tugas">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL LIHAT TUGAS -->
<!-- MODAL EDIT PENUGASAN -->
<div class="modal fade bs-modal-lg" id="modal-edit-penugasan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit penugasan</h4>
      </div>
      <div class="modal-body form" id="tampil-edit-penugasan">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL EDIT PENUGASAN -->
<!-- MODAL HAPUS PENUGASAN -->
<div class="modal fade bs-modal-md" id="modal-hapus-penugasan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Hapus Penugasan</h4>
      </div>
      <form role="form" id="form-hapus-penugasan">
        <div class="modal-body">
          <div class="form-body">
            <div class="form-group">
              <input class="form-control spinner" type="hidden" id="id-hapus-penugasan" name="id-hapus-penugasan" value="">
              <div class="note note-danger">
                <h4 class="block">Peringatan Hapus!</h4>
                <p> Apakah anda yakin menghapus data ini? </p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn red">Hapus</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL HAPUS PENUGASAN -->
<!-- MODAL LIHAT NILAI -->
<div class="modal fade bs-modal-lg" id="modal-lihat-nilai" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Lihat Nilai</h4>
      </div>
      <div class="modal-body" id="show_nilai">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL LIHAT NILAI -->
<?php
require('layouts/bodylayout.php');
?>
<script type="text/javascript">
  function get_penugasan() {
    var id_mapel = '<?= $datakelas['id_mapel'] ?>';
    var id_kelas = '<?= $datakelas['id_kelas'] ?>';
    $.ajax({
      url: 'backend/function.php?action=get_data&get=data_penugasan',
      type: 'post',
      data: {
        id_mapel: id_mapel,
        id_kelas: id_kelas
      },
      success: function(data) {
        $('#show_penugasan').html(data);
      }
    });
  }

  function get_penugasan_akanberakhir() {
    var id_mapel = '<?= $datakelas['id_mapel'] ?>';
    var id_kelas = '<?= $datakelas['id_kelas'] ?>';
    $.ajax({
      url: 'backend/function.php?action=get_data&get=data_penugasan_akanberakhir',
      type: 'post',
      data: {
        id_mapel: id_mapel,
        id_kelas: id_kelas
      },
      success: function(data) {
        $('#show_akan_berakhir').html(data);
      }
    });
  }

  $(document).ready(function() {
    get_penugasan();
    get_penugasan_akanberakhir();

    $('#tambah-penugasan').on('click', function() {
      $('#modal-tambah-penugasan').modal('show');
    });

    $('#show_penugasan').on('click', '.lihat_tugas', function() {
      var kode_tugas = $(this).attr("data-kode");
      $.ajax({
        url: 'backend/function.php?action=get_data&get=lihat_tugas',
        type: 'post',
        data: {
          kode_tugas: kode_tugas,
        },
        success: function(data) {
          if (kode_tugas) {
            $('#show_tugas').html(data);
            $('#modal-lihat-tugas').modal('show');
          }
        }
      });
    });

    $('#btn-nilai').on('click', function() {
      var id_mapel = '<?= $datakelas['id_mapel'] ?>';
      var id_kelas = '<?= $datakelas['id_kelas'] ?>';
      $.ajax({
        url: 'backend/function.php?action=get_data&get=nilai_penugasan',
        type: 'post',
        data: {
          id_mapel: id_mapel,
          id_kelas: id_kelas
        },
        success: function(data) {
          $('#show_nilai').html(data);
          $('#modal-lihat-nilai').modal('show');
        }
      });
    });

    $('#jenis-tugas').on('select2:select', function(e) {
      var id_mapel = '<?= $datakelas['id_mapel'] ?>';
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
          $('#tugas-awal').html(html);
          $('#r1').html('<option value="">Pilih Tugas</option>' + html);
          $('#r2').html('<option value="">Pilih Tugas</option>' + html);
          $('#tugas-awal').trigger('change');
          $('#r1').trigger('change');
          $('#r2').trigger('change');
        }
      });
    });

    $("#jenis-tugas").select2({
      placeholder: "Pilih jenis tugas..",
      allowClear: true,
      width: "100%"
    });

    $("#tugas-awal").select2({
      placeholder: "Pilih tugas..",
      width: "100%"
    });
    $("#r1").select2({
      placeholder: "Pilih tugas..",
      allowClear: true,
      width: "100%"
    });
    $("#r2").select2({
      placeholder: "Pilih tugas..",
      allowClear: true,
      width: "100%"
    });

    $("#form-tambah-penugasan").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=simpan_data_penugasan',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            $('#modal-tambah-penugasan').modal('hide');
            get_penugasan();
            get_penugasan_akanberakhir();
          } else {
            for (i = 0; i < data.errors.length; i++) {
              $('#pesan-' + data.errors[i].input).html('<span class="help-block" style="color:red;">' + data.errors[i].message + '</span>')
              $('#form-' + data.errors[i].input).addClass('has-error');
            }
            for (i = 0; i < data.success.length; i++) {
              $('#pesan-' + data.success[i]).html('')
              $('#form-' + data.success[i]).removeClass('has-error');
            }
          }
        }
      });
    });

    $('#show_penugasan').on('click', '.edit-penugasan', function(event) {
      var id_penugasan = $(this).attr('data-id');
      $.ajax({
        url: 'backend/function.php?action=get_data_penugasan_byid',
        type: 'post',
        data: {
          id_penugasan: id_penugasan,
        },
        success: function(data) {
          $('#tampil-edit-penugasan').html(data);
          $('#modal-edit-penugasan').modal('show');
          $("#jenis-edittugas").select2({
            placeholder: "Pilih jenis tugas..",
            allowClear: true,
            width: "100%"
          });

          $("#kode_soal-editpenugasan").select2({
            placeholder: "Pilih tugas..",
            allowClear: true,
            width: "100%"
          });
        }
      });
    });

    $('#show_penugasan').on('click', '.hapus-penugasan', function(event) {
      var id_penugasan = $(this).attr('data-id');
      $('#id-hapus-penugasan').val(id_penugasan);
      $('#modal-hapus-penugasan').modal('show');
    });

    $("#form-hapus-penugasan").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=hapus_data_penugasan',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          $('#modal-hapus-penugasan').modal('hide');
          get_penugasan();
          get_penugasan_akanberakhir();
        }
      });
    });
  });
</script>
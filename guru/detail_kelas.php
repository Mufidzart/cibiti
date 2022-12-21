<?php
require('../backend/connection.php');
$page_title = "Detail Kelas";
require('../frontend/layouts/headlayout.php');
$id_kelas = $_GET['kelas'];
$getkelasmapel = mysqli_query($conn, "SELECT ak.id AS id_kelas,ak.nama_kelas,ak.parent_id,am.id AS id_mapel,am.nama_mapel,ak.program_keahlian,stf.nama_lengkap,stf.email FROM arf_guru_mapel agm JOIN arf_staf stf ON stf.nip=agm.id_staf JOIN arf_mapel am ON am.id=agm.id_mapel JOIN arf_kelas ak ON ak.id=agm.id_subkelas WHERE ak.id=$id_kelas AND agm.id_staf='$session_id_staf' AND agm.id_thajaran=$id_thajaran");
$datakelas = mysqli_fetch_assoc($getkelasmapel);
if ($datakelas['parent_id'] == 1) {
  $grade = "X";
} elseif ($datakelas['parent_id'] == 2) {
  $grade = "XI";
} elseif ($datakelas['parent_id'] == 3) {
  $grade = "XII";
}
$id_mapel = $datakelas['id_mapel'];
$kelas = $grade . " " . $datakelas['nama_kelas'];
$getsiswa = $conn->query("SELECT * FROM arf_siswa WHERE id_kelasaktif='" . $kelas . "'");
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
                      <img src="../assets/images/admin_avatar.png" class="img-responsive" alt="">
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
              <?php while ($datasiswa = mysqli_fetch_array($getsiswa)) : ?>
                <div class="mt-comment">
                  <div class="mt-comment-img">
                    <img src="../assets/images/person_avatar.png" style="width:100%;">
                  </div>
                  <div class="mt-comment-body">
                    <div class="mt-comment-info">
                      <span class="mt-comment-author"><?= $datasiswa['nama_siswa'] ?></span>
                      <!-- <span class="mt-comment-date">26 Feb, 10:30AM</span> -->
                    </div>
                    <div class="mt-comment-text">NIS: <?= $datasiswa['nis'] ?> <?= (!empty($datasiswa['email_siswa'])) ? "- EMAIL : " . $datasiswa['email_siswa'] : "" ?> Kelas: <?= $datasiswa['id_kelasaktif'] ?></div>
                  </div>
                </div>
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
                          <!-- <a href="javascript:;" data-toggle="collapse" data-target=".akan-berakhir"><span class="badge badge-info"> 0 </span> Tugas Akan Berakhir </a> -->
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="todo-content">
                <form class="form-horizontal" role="form" id="form-edit-tugas">
                  <div class="form-body">
                    <div class="form-group">
                      <label class="col-md-1 control-label vcenter">
                        <img alt="" class="img-circle bg-white" style="padding:2px;width:40px;" src="../assets/images/admin_avatar.png" />
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
            <div class="form-group" id="form-kode_soal">
              <label for="kode_soal" class="control-label">Tugas</label>
              <select class="form-control select2" id="kode_soal" name="kode_soal">
                <option></option>
              </select>
              <div id="pesan-kode_soal"></div>
            </div>
            <div class="note note-info">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group" id="form-batas-akhir">
                    <label class="control-label"><strong>Batas akhir penugasan</strong></label><br>
                    <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
                      <input type="text" class="form-control" id="batas-akhir" name="batas-akhir">
                      <span class="input-group-btn">
                        <button class="btn default date-reset" type="button">
                          <i class="fa fa-times"></i>
                        </button>
                        <button class="btn default date-set" type="button">
                          <i class="fa fa-calendar"></i>
                        </button>
                      </span>
                    </div>
                    <div id="pesan-batas-akhir"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group" id="form-durasi">
                    <label class="control-label"><strong>Waktu pengerjaan</strong></label><br>
                    <div class="input-group">
                      <input type="text" class="form-control text-right" id="durasi" name="durasi">
                      <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                          menit
                        </button>
                      </span>
                    </div>
                    <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
                    <div id="pesan-durasi"></div>
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
<?php
require('../frontend/layouts/bodylayout.php');
?>
<script type="text/javascript">
  function get_penugasan() {
    var id_mapel = '<?= $datakelas['id_mapel'] ?>';
    var id_kelas = '<?= $datakelas['id_kelas'] ?>';
    $.ajax({
      url: '../backend/function_guru.php?action=get_data&get=data_penugasan',
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
      url: '../backend/function_guru.php?action=get_data&get=data_penugasan_akanberakhir',
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
        url: '../backend/function_guru.php?action=get_data&get=lihat_tugas',
        type: 'post',
        data: {
          kode_tugas: kode_tugas,
        },
        success: function(data) {
          $('#show_tugas').html(data);
        }
      });
      $('#modal-lihat-tugas').modal('show');
    });

    $('#jenis-tugas').on('select2:select', function(e) {
      var id_mapel = '<?= $datakelas['id_mapel'] ?>';
      var jenis_tugas = $(this).val();
      $.ajax({
        url: '../backend/function_guru.php?action=get_data&get=data_tugas',
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
          $('#kode_soal').html(html);
          $('#kode_soal').trigger('change');
        }
      });
    });


    $("#jenis-tugas").select2({
      placeholder: "Pilih jenis tugas..",
      allowClear: true,
      width: "100%"
    });

    $("#kode_soal").select2({
      placeholder: "Pilih tugas..",
      allowClear: true,
      width: "100%"
    });

    $("#form-tambah-penugasan").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: '../backend/function_guru.php?action=simpan_data_penugasan',
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
          }
          for (i = 0; i < data.success.length; i++) {
            $('#pesan-' + data.success[i]).html('')
            $('#form-' + data.success[i]).removeClass('has-error');
          }
        }
      });
    });

    $('#show_penugasan').on('click', '.edit-penugasan', function(event) {
      var id_penugasan = $(this).attr('data-id');
      $.ajax({
        url: '../backend/function_guru.php?action=get_data_penugasan_byid',
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

    $('#show_penugasan').on('select2:select', '.jenis-edittugas', function(e) {
      console.log("TEST");
      var id_mapel = '<?= $datakelas['id_mapel'] ?>';
      var jenis_tugas = $(this).val();
      $.ajax({
        url: '../backend/function_guru.php?action=get_data&get=data_tugas',
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
  });
</script>
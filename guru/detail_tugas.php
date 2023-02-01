<?php
require('backend/connection.php');
$page_title = "Detail Tugas";
require('layouts/headlayout.php');
$data_tugas = mysqli_query($conn, "SELECT atc.*,am.nama_mapel FROM arf_tugas_cbt atc JOIN arf_mapel am ON am.id=atc.id_mapel WHERE atc.id='" . $_GET['tgs'] . "' AND tgl_hapus IS NULL");
$getmapel = mysqli_query($conn, "SELECT distinct am.id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel WHERE agm.id_staf='$session_id_staf' AND agm.id_thajaran=4");
$jenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
$tipe_soal = mysqli_query($conn, "SELECT * FROM arf_master_soal WHERE tgl_hapus IS NULL");
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <!-- BEGIN CONTENT BODY -->
  <div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
        <h1><?= $page_title ?>
          <small></small>
        </h1>
      </div>
      <!-- END PAGE TITLE -->
      <!-- BEGIN PAGE TOOLBAR -->
      <div class="page-toolbar">
      </div>
      <!-- END PAGE TOOLBAR -->
    </div>
    <!-- END PAGE HEAD-->
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
      <li>
        <a href="index.php">Home</a>
        <i class="fa fa-circle"></i>
      </li>
      <li>
        <span class="active">Apps</span>
      </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <?php if ($data_tugas->num_rows >= 1) : ?>
      <?php $tugas = mysqli_fetch_array($data_tugas) ?>
      <div class="row ">
        <div class="col-md-12">
          <!-- BEGIN SAMPLE FORM PORTLET-->
          <div class="portlet light bordered">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-plus-square"></i>
                <span class="caption-subject font-dark bold uppercase"><?= $page_title ?></span>
              </div>
              <div class="actions">
                <a class="btn btn-circle green" data-toggle="modal" href="#edit-tugas">Edit <i class="icon-wrench"></i></a>
                <a class="btn btn-circle red" data-toggle="modal" href="#hapus-tugas">Hapus <i class="icon-trash"></i></a>
              </div>
            </div>
            <div class="portlet-body">
              <div class="row">
                <div class="col-md-12 profile-info" style="padding-right: 50px;padding-left: 50px;margin-bottom: 50px;">
                  <input type="hidden" id="kode-show" value="<?= $tugas['kode_tugas'] ?>">
                  <a href="javascript:;" class="btn btn-circle default green-stripe" id="text-kode">KODE: <?= $tugas['kode_tugas'] ?></a>
                  <h2 class="font-green sbold uppercase" id="text-judul"><?= $tugas['judul'] ?></h2>
                  <p id="text-deskripsi"><?= $tugas['deskripsi'] ?></p>
                  <ul class="list-inline">
                    <li id="text-jenis">
                      <i class="fa fa-briefcase"></i> <?= $tugas['jenis'] ?>
                    </li>
                    <li id="text-mapel">
                      <i class="fa fa-book"></i> <?= $tugas['nama_mapel'] ?>
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
                      <div class="actions">
                        <div class="btn-group">
                          <a class="btn btn-circle green" data-toggle="modal" href="#modal-tambah-soal-excel">Tambah Soal <i class="fa fa-plus"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="portlet-body">
                      <ul class="feeds" id="tampil_soal">
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END SAMPLE FORM PORTLET-->
        </div>
      </div>
    <?php else : ?>
      <div class="note note-danger">
        <p> Data tugas yang diinginkan tidak ditemukan </p>
      </div>
    <?php endif; ?>
    <!-- END PAGE BASE CONTENT -->
  </div>
  <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- MODAL TAMBAH SOAL -->
<div class="modal fade bs-modal-lg" id="modal-tambah-soal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah Soal</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form-tambah-soal">
          <div class="form-body">
            <input class="form-control" type="hidden" name="id-mapel-soal" value="<?= $tugas['id_mapel'] ?>">
            <input class="form-control" type="hidden" name="kode-tugas-soal" value="<?= $tugas['kode_tugas'] ?>">
            <div class="form-group" id="form-tipe-soal">
              <label class="control-label">Tipe Pertanyaan</label>
              <select class="form-control" id="tipe-soal" name="tipe-soal">
                <?php while ($row = mysqli_fetch_array($tipe_soal)) : ?>
                  <option value="<?= $row['tipe_soal'] ?>"><?= $row['tipe_soal'] ?></option>
                <?php endwhile; ?>
              </select>
              <div id="pesan-tipe-soal"></div>
            </div>
            <div class="form-group" id="form-pertanyaan">
              <label class="control-label">Pertanyaan</label>
              <textarea class="form-control col-md-4" id="pertanyaan" name="pertanyaan" rows="3" style="margin-bottom: 20px;"></textarea>
              <div id="pesan-pertanyaan"></div>
            </div>
            <div id="jawaban" style="padding: 20px;">
              <div class="form-group">
                <label class="control-label">Pilihan Jawaban</label>
              </div>
              <div class="form-group" id="form-pilihan-1">
                <div class="input-group" style="margin-top: 5px; margin-bottom: 5px;">
                  <span class="input-group-addon">
                    <input type="radio" name="radio-pilihan" value="1">
                    <span></span>
                  </span>
                  <input type="text" class="form-control" name="pilihan-1">
                </div>
                <div id="pesan-pilihan-1"></div>
              </div>
              <div class="form-group" id="form-pilihan-2">
                <div class="input-group" style="margin-top: 5px; margin-bottom: 5px;">
                  <span class="input-group-addon has-error">
                    <input type="radio" name="radio-pilihan" value="2">
                    <span></span>
                  </span>
                  <input type="text" class="form-control" name="pilihan-2">
                </div>
                <div id="pesan-pilihan-2"></div>
              </div>
              <div class="form-group" id="form-pilihan-3">
                <div class="input-group" style="margin-top: 5px; margin-bottom: 5px;">
                  <span class="input-group-addon">
                    <input type="radio" name="radio-pilihan" value="3">
                    <span></span>
                  </span>
                  <input type="text" class="form-control" name="pilihan-3">
                </div>
                <div id="pesan-pilihan-3"></div>
              </div>
              <div class="form-group" id="form-pilihan-4">
                <div class="input-group" style="margin-top: 5px; margin-bottom: 5px;">
                  <span class="input-group-addon">
                    <input type="radio" name="radio-pilihan" value="4">
                    <span></span>
                  </span>
                  <input type="text" class="form-control" name="pilihan-4">
                </div>
                <div id="pesan-pilihan-4"></div>
                <div id="pesan-radio-pilihan"></div>
              </div>
            </div>
          </div>
          <div class="form-actions right">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn green">Simpan</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL TAMBAH SOAL -->
<!-- MODAL TAMBAH SOAL GENERATE EXCEL -->
<div class="modal fade bs-modal-lg" id="modal-tambah-soal-excel" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah Soal</h4>
      </div>
      <div class="modal-body form">
        <div class="form-body">
          <input class="form-control" type="hidden" name="id-mapel-soal" value="<?= $tugas['id_mapel'] ?>">
          <input class="form-control" type="hidden" name="kode-tugas-soal" value="<?= $tugas['kode_tugas'] ?>">
          <div class="alert alert-danger alert-soal" style="display: none;">Jumlah soal tidak boleh kosong</div>
          <div class="alert alert-danger alert-jawaban" style="display: none;">Jumlah Jawaban tidak boleh kosong</div>
          <div class="form-group" id="form-soal">
            <label class="control-label">Jumlah Soal</label>
            <input class="form-control col-md-4 jumlah_soal" style="margin-bottom: 10px;" type="text" name="jumlah_soal" id="jumlah_soal">
          </div>
          <div class="form-group" id="form-jawaban">
            <label class="control-label">Jumlah pilihan jawaban per soal</label>
            <input class="form-control col-md-4 jumlah_jawaban" style="margin-bottom: 10px;" type="text" name="jumlah_jawaban" id="jumlah_jawaban">
          </div>
          <div class="form-group" id="form-jawaban">
            <button type="button" class="btn success btn-outline" style="margin-bottom: 10px;" id="btn_excel">Generate Excel</button>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">Import Soal</h3>
                </div>
                <div class="panel-body" style="text-align:center;">
                  <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                  <div class="row">
                    <div class="col-lg-7">
                      <!-- The fileinput-button span is used to style the file input field as button -->
                      <form id="formexcel">
                        <div class="form-group">
                          <input type="file" class="form-control col-md-4" style="margin-bottom: 10px;" name="fileexcel" id="fileexcel">
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn blue start start_import">
                            <i class="fa fa-upload"></i>
                            <span> Start Import </span>
                          </button>
                        </div>
                        <div class="form-group" id="pesan-excel">

                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions right">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL TAMBAH SOAL GENERATE EXCEL -->
<!-- MODAL EDIT SOAL -->
<div class="modal fade bs-modal-lg" id="modal-edit-soal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Soal</h4>
      </div>
      <div class="modal-body form" id="tampil-edit-soal">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL EDIT SOAL -->
<!-- MODAL HAPUS SOAL -->
<div class="modal fade bs-modal-md" id="modal-hapus-soal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Hapus Soal</h4>
      </div>
      <form role="form" id="form-hapus-soal">
        <div class="modal-body">
          <div class="form-body">
            <div class="form-group">
              <input class="form-control spinner" type="hidden" id="id-hapus-soal" name="id-hapus-soal" value="">
              <div class="note note-danger">
                <h4 class="block">Peringatan Hapus!</h4>
                <p> Apakah anda yakin menghapus soal ini? </p>
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
<!-- END MODAL EDIT SOAL -->
<!-- MODAL EDIT TUGAS -->
<div class="modal fade bs-modal-md" id="edit-tugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Tugas</h4>
      </div>
      <form role="form" id="form-edit-tugas">
        <div class="modal-body">
          <div class="form-body">
            <div class="form-group">
              <label class="control-label">Judul Tugas</label>
              <input class="form-control spinner" type="hidden" id="id-tugas" name="id-tugas" value="<?= $tugas['id'] ?>">
              <input class="form-control spinner" type="text" id="judul-tugas" name="judul-tugas" placeholder="Judul tugas" value="<?= $tugas['judul'] ?>">
            </div>
            <div class="form-group">
              <label class="control-label">Mata Pelajaran</label>
              <select class="form-control" id="mapel-tugas" name="mapel-tugas">
                <?php while ($data_mapel = mysqli_fetch_array($getmapel)) :
                  $select = ($data_mapel['id'] == $tugas['id_mapel']) ? "selected" : ""; ?>
                  <option value="<?= $data_mapel['id'] ?>" <?= $select ?>><?= $data_mapel['nama_mapel'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Jenis Tugas</label>
              <select class="form-control" id="jenis-tugas" name="jenis-tugas">
                <?php while ($jenis = mysqli_fetch_array($jenis_tugas)) :
                  $select = ($jenis['jenis_tugas'] == $tugas['jenis']) ? "selected" : ""; ?>
                  <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Deskripsi Tugas</label>
              <textarea class="form-control" id="deskripsi-tugas" name="deskripsi-tugas" rows="3"><?= $tugas['deskripsi'] ?></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn green">Edit Tugas</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL EDIT TUGAS -->
<!-- MODAL HAPUS TUGAS -->
<div class="modal fade bs-modal-md" id="hapus-tugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Hapus Tugas</h4>
      </div>
      <form role="form" id="form-hapus-tugas">
        <div class="modal-body">
          <div class="form-body">
            <div class="form-group">
              <input class="form-control spinner" type="hidden" id="id-tugas" name="id-tugas" value="<?= $tugas['id'] ?>">
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
<!-- END MODAL HAPUS TUGAS -->
<?php
require('layouts/bodylayout.php');
?>
<script type="text/javascript">
  function get_soal() {
    var kode_tugas = $('#kode-show').val();
    $.ajax({
      url: 'backend/function.php?action=get_data&get=data_soal',
      type: 'post',
      data: {
        kode_tugas: kode_tugas,
      },
      success: function(data) {
        $('#tampil_soal').html(data);
      }
    });
  }
  $(document).ready(function() {
    get_soal();

    $('#tipe-soal').on('click', function() {
      var tipe_soal = $(this).val();
      if (tipe_soal == "Pilihan Ganda") {
        $("#jawaban :input").attr("disabled", false);
        $("#jawaban").css("display", "block");
      } else {
        $("#jawaban :input").attr("disabled", true);
        $("#jawaban").css("display", "none");
      }
    });

    $("#form-edit-tugas").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=edit_data_tugas',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          var html_jenis = '';
          var jenis = ['Tugas Harian', 'UTS', 'UAS']
          jenis.forEach(element => {
            var select = (element == data.jenis) ? "selected" : "";
            html_jenis += '<option value="' + element + '" ' + select + '>' + element + '</option>'
          });
          $('#text-judul').html(data.judul);
          $('#text-deskripsi').html(data.deskripsi);
          $('#text-jenis').html('<i class="fa fa-briefcase"></i> ' + data.jenis);
          $('#text-mapel').html('<i class="fa fa-book"></i> ' + data.nama_mapel);
          $('#id-tugas').val(data.id);
          $('#judul-tugas').val(data.judul);
          $('#mapel-tugas').html(data.mapel);
          $('#jenis-tugas').html(data.jenis_tugas);
          $('#deskripsi-tugas').val(data.deskripsi);
          $('#edit-tugas').modal('hide');
        }
      });
    });

    $("#form-hapus-tugas").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=hapus_data_tugas',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          $('#hapus-tugas').modal('hide');
          window.location.href = "tugas.php";
        }
      });
    });

    $("#form-tambah-soal").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=simpan_data_soal',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            get_soal();
            $('#modal-tambah-soal').modal('hide');
          } else {
            for (i = 0; i < data.errors.length; i++) {
              $('#pesan-' + data.errors[i].input).html('<span class="help-block" style="color:red;">' + data.errors[i].message + '</span>')
              $('#form-' + data.errors[i].input).addClass('has-error');
              if (data.errors[i].input == "radio-pilihan") {
                $('#jawaban').addClass('alert-danger');
              }
            }

          }
          for (i = 0; i < data.success.length; i++) {
            $('#pesan-' + data.success[i]).html('')
            $('#form-' + data.success[i]).removeClass('has-error');
            if (data.success[i] == "radio-pilihan") {
              $('#jawaban').removeClass('alert-danger');
            }
          }
        }
      });
    });

    $('#modal-tambah-soal').on('hidden.bs.modal', function() {
      var input = ["pertanyaan", "pilihan-1", "pilihan-2", "pilihan-3", "pilihan-4"];
      input.forEach(element => {
        $('[name=' + element + ']').val("");
        $('#pesan-' + element).html('')
        $('#form-' + element).removeClass('has-error');
      });
      $("[name=radio-pilihan]").attr("checked", false);
      $('#pesan-radio-pilihan').html('')
      $('#jawaban').removeClass('alert-danger');
    });

    $('#modal-tambah-soal-excel').on('hidden.bs.modal', function() {
      $(".jumlah_soal").val("");
      $(".jumlah_jawaban").val("");
      $('.alert-soal').css("display", "none");
      $('.alert-jawaban').css("display", "none");
    });

    $('#tampil_soal').on('click', '.edit-soal', function(event) {
      var id_soal = $(this).attr('data-id');
      $.ajax({
        url: 'backend/function.php?action=get_data&get=data_soal_id',
        type: 'post',
        data: {
          id_soal: id_soal
        },
        success: function(data) {
          $('#tampil-edit-soal').html(data);
          $('#modal-edit-soal').modal('show');
        }
      });
    });

    $('#modal-edit-soal').on('hidden.bs.modal', function() {
      $('#tampil-edit-soal').html("");
    });

    $("#tampil-edit-soal").on("submit", ".form-edit-soal", function(event) {
      event.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=edit_data_soal',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            get_soal();
            $('#modal-edit-soal').modal('hide');
          } else {
            for (i = 0; i < data.errors.length; i++) {
              $('#pesan-edit-' + data.errors[i].input).html('<span class="help-block" style="color:red;">' + data.errors[i].message + '</span>')
              $('#form-edit-' + data.errors[i].input).addClass('has-error');
              if (data.errors[i].input == "radio-pilihan") {
                $('#jawaban-edit').addClass('alert-danger');
              }
            }

          }
          for (i = 0; i < data.success.length; i++) {
            $('#pesan-edit-' + data.success[i]).html('')
            $('#form-edit-' + data.success[i]).removeClass('has-error');
            if (data.success[i] == "radio-pilihan") {
              $('#jawaban-edit').removeClass('alert-danger');
            }
          }
        }
      });
    });

    $('#tampil_soal').on('click', '.hapus-soal', function(event) {
      var id_soal = $(this).attr('data-id');
      $('#id-hapus-soal').val(id_soal);
      $('#modal-hapus-soal').modal('show');
    });

    $("#form-hapus-soal").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=hapus_data_soal',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          get_soal();
          $('#modal-hapus-soal').modal('hide');
        }
      });
    });

    $('#btn_excel').on('click', function(event) {
      var jumlah_soal = $(".jumlah_soal").val();
      var jumlah_jawaban = $(".jumlah_jawaban").val();
      var id_tugas = <?= $tugas['id'] ?>;
      if (!jumlah_soal) {
        $('.alert-soal').css("display", "block");
      } else {
        $('.alert-soal').css("display", "none");
      }
      if (!jumlah_jawaban) {
        $('.alert-jawaban').css("display", "block");
      } else {
        $('.alert-jawaban').css("display", "none");
      }
      if (jumlah_soal && jumlah_jawaban) {
        var popout = window.open('<?= $baseurl ?>/guru/views/generate_document/excel_soal.php?id=' + id_tugas + '&js=' + jumlah_soal + '&jj=' + jumlah_jawaban);
        // window.setTimeout(function() {
        //   popout.close();
        // }, 1000);
      }
    });

    $("#formexcel").on("submit", function(event) {
      event.preventDefault();
      var file_data = $('#fileexcel').prop('files')[0];
      var formData = new FormData($(this)[0]);
      if (file_data == undefined) {
        $("#pesan-excel").html('<div class="alert alert-danger">File tidak boleh kosong</div>');
      } else {
        $("#pesan-excel").html('');
        var file_name = file_data.name;
        var file_extension = file_name.split('.').pop().toLowerCase();
        console.log(file_extension);
        if (jQuery.inArray(file_extension, ['xlsx', 'xls', 'csv'])) {
          $("#pesan-excel").html('<div class="alert alert-danger">File yang diizinkan hanya .xlsx, .xls, dan .csv</div>');
        } else {
          $.ajax({
            url: 'backend/function.php?action=import_soal',
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
              get_soal();
              $('#modal-tambah-soal-excel').modal('hide');
            }
          });
        }
      }
    });
  })
</script>
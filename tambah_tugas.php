<?php
$page_title = "Detail Tugas";
require('frontend/layouts/headlayout.php');
require('backend/connection.php');
$data_tugas = mysqli_query($conn, "SELECT atc.*,am.nama_mapel FROM arf_tugas_cbt atc JOIN arf_mapel am ON am.id=atc.id_mapel WHERE atc.id='" . $_GET['tgs'] . "' AND tgl_hapus IS NULL");
$getmapel = mysqli_query($conn, "SELECT distinct am.id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel WHERE agm.id_staf='197211012007011009' AND agm.id_thajaran=4");
$jenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
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
                <span class="caption-subject font-dark bold uppercase" id="body-title">Detail Soal <?= $tugas['jenis'] ?></span>
              </div>
              <div class="actions">
                <a class="btn btn-circle green" data-toggle="modal" href="#edit-tugas">Edit <i class="icon-wrench"></i></a>
                <a class="btn btn-circle red" data-toggle="modal" href="#hapus-tugas">Hapus <i class="icon-trash"></i></a>
              </div>
            </div>
            <div class="portlet-body">
              <form role="form">
                <div class="form-body">
                  <div class="form-group">
                    <label>Judul Tugas</label>
                    <input class="form-control spinner" type="text" id="judul-show" name="judul-show" placeholder="Judul tugas" value="<?= $tugas['judul'] ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <select class="form-control" id="mapel-show" name="mapel-show" disabled>
                      <option value="<?= $tugas['nama_mapel'] ?>"><?= $tugas['nama_mapel'] ?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jenis Tugas</label>
                    <select class="form-control" id="jenis-show" name="jenis-show" disabled>
                      <option value="<?= $tugas['jenis'] ?>"><?= $tugas['jenis'] ?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Deskripsi Tugas</label>
                    <textarea class="form-control" id="deskripsi-show" name="deskripsi-show" rows="3" disabled><?= $tugas['deskripsi'] ?></textarea>
                  </div>
                </div>
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption">
                      <i class="icon-bubble font-green-sharp"></i>
                      <span class="caption-subject font-green-sharp bold uppercase">SOAL</span>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <div id="soal_baru">

                    </div>
                    <a class="btn btn-circle green" data-toggle="modal" href="#modal-tambah-soal">Tambah Soal <i class="fa fa-plus"></i></a>
                  </div>
                </div>
              </form>
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
      <div class="modal-body"> Modal body goes here </div>
      <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
        <button type="button" class="btn green">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL TAMBAH SOAL -->
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
              <label>Judul Tugas</label>
              <input class="form-control spinner" type="hidden" id="id-tugas" name="id-tugas" value="<?= $tugas['id'] ?>">
              <input class="form-control spinner" type="text" id="judul-tugas" name="judul-tugas" placeholder="Judul tugas" value="<?= $tugas['judul'] ?>">
            </div>
            <div class="form-group">
              <label>Mata Pelajaran</label>
              <select class="form-control" id="mapel-tugas" name="mapel-tugas">
                <?php while ($data_mapel = mysqli_fetch_array($getmapel)) :
                  $select = ($data_mapel['id'] == $tugas['id_mapel']) ? "selected" : ""; ?>
                  <option value="<?= $data_mapel['id'] ?>" <?= $select ?>><?= $data_mapel['nama_mapel'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Jenis Tugas</label>
              <select class="form-control" id="jenis-tugas" name="jenis-tugas">
                <?php while ($jenis = mysqli_fetch_array($jenis_tugas)) :
                  $select = ($jenis['jenis_tugas'] == $tugas['jenis']) ? "selected" : ""; ?>
                  <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Deskripsi Tugas</label>
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
<!-- END MODAL EDIT TUGAS -->
<?php
require('frontend/layouts/bodylayout.php');
?>
<script type="text/javascript">
  $(document).ready(function() {
    $("#form-edit-tugas").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=edit_data_tugas',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          console.log(data.jenis_tugas);
          var html_jenis = '';
          var jenis = ['Tugas Harian', 'UTS', 'UAS']
          jenis.forEach(element => {
            var select = (element == data.jenis) ? "selected" : "";
            html_jenis += '<option value="' + element + '" ' + select + '>' + element + '</option>'
          });
          $('#body-title').html('Detail Soal ' + data.jenis);
          $('#id-tugas').val(data.id);
          $('#judul-tugas').val(data.judul);
          $('#judul-show').val(data.judul);
          $('#mapel-tugas').html(data.mapel);
          $('#mapel-show').html(data.mapel);
          $('#jenis-tugas').html(data.jenis_tugas);
          $('#jenis-show').html(data.jenis_tugas);
          $('#deskripsi-tugas').val(data.deskripsi);
          $('#deskripsi-show').val(data.deskripsi);
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
  })
</script>
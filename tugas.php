<?php
require('backend/connection.php');
$page_title = "Tugas Learning Management System (LMS)";
require('frontend/layouts/headlayout.php');
$data_tugas = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE id_staff='$session_id_staf' AND id_mapel='47' AND tgl_hapus IS NULL");
$getmapel = mysqli_query($conn, "SELECT distinct am.id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel WHERE agm.id_staf='$session_id_staf' AND agm.id_thajaran=4");
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
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
      </li>
      <li>
        <span class="active">Apps</span>
      </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
          <div class="portlet-title">
            <div class="caption">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject font-dark sbold uppercase">Tugas</span>
            </div>
            <div class="actions">
              <div class="btn-group btn-group-devided" data-toggle="buttons">
                <a class="btn btn-circle green" data-toggle="modal" href="#large">Tambah Tugas <i class="fa fa-plus"></i></a>
              </div>
            </div>
          </div>
          <div class="portlet-body">
            <div class="mt-actions">
              <?php while ($tugas = mysqli_fetch_array($data_tugas)) : ?>
                <div class="mt-action">
                  <a href="tambah_tugas.php?tgs=<?= $tugas['id'] ?>">
                    <div class="mt-action-img">
                      <?php
                      if ($tugas['jenis'] == "Tugas Harian") {
                        $img = "tugas-3.webp";
                      } elseif ($tugas['jenis'] == "UTS") {
                        $img = "tugas-2.webp";
                      } else {
                        $img = "tugas-1.webp";
                      }
                      ?>
                      <img src="../assets/images/<?= $img ?>" width="45px" />
                    </div>
                  </a>
                  <div class="mt-action-body">
                    <div class="mt-action-row">
                      <a href="tambah_tugas.php?tgs=<?= $tugas['id'] ?>">
                        <div class="mt-action-info ">
                          <div class="mt-action-details ">
                            <span class="mt-action-author" id="judul-<?= $tugas['id'] ?>"><?= $tugas['judul'] ?></span>
                            <p class="mt-action-desc"><?= $tugas['deskripsi'] ?></p>
                          </div>
                        </div>
                      </a>
                      <div class="mt-action-info">
                        <div class="mt-action-details ">
                          <span class="mt-action-author">Jumlah Soal</span>
                          <p class="mt-action-desc">0 Soal</p>
                        </div>
                      </div>
                      <div class="mt-action-info">
                        <div class="mt-action-details ">
                          <a href="javascript:;" class="btn btn-circle default green-stripe">KODE: <?= $tugas['kode_tugas'] ?></a>
                        </div>
                      </div>
                      <div class="mt-action-datetime">
                        <span class="mt-action-date">Dibuat: </span>
                        <?php $date = date("d-m-Y H:i", strtotime($tugas['tgl_input'])) ?>
                        <span class="mt=action-time"><?= $date ?></span>
                      </div>
                      <div class="mt-action-buttons">
                        <div class="btn-group btn-group-circle">
                          <a class="btn btn-outline green btn-sm" href="tambah_tugas.php?tgs=<?= $tugas['id'] ?>">Lihat</a>
                          <button type="button" class="btn btn-outline red btn-sm btn-hapus" id="btn-hapus" data-id="<?= $tugas['id'] ?>">Hapus</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
      </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
  </div>
  <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- /.modal -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah Tugas Baru</h4>
      </div>
      <form role="form" id="form-tambah-tugas">
        <div class="modal-body">
          <div id="pesan"></div>
          <div class="form-body">
            <div class="form-group">
              <label>Judul Tugas</label>
              <input class="form-control spinner" type="text" id="judul-tugas" name="judul-tugas" placeholder="Judul tugas">
            </div>
            <div class="form-group">
              <label>Mata Pelajaran</label>
              <select class="form-control" id="mapel-tugas" name="mapel-tugas">
                <?php while ($data_mapel = mysqli_fetch_array($getmapel)) : ?>
                  <option value="<?= $data_mapel['id'] ?>"><?= $data_mapel['nama_mapel'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Jenis Tugas</label>
              <select class="form-control" id="jenis-tugas" name="jenis-tugas">
                <option value="Tugas Harian">Tugas Harian</option>
                <option value="UTS">UTS</option>
                <option value="UAS">UAS</option>
              </select>
            </div>
            <div class="form-group">
              <label>Deskripsi Tugas</label>
              <textarea class="form-control" id="deskripsi-tugas" name="deskripsi-tugas" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn green">Buat Tugas</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
              <input class="form-control spinner" type="hidden" id="id-tugas" name="id-tugas" value="">
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
    $("#form-tambah-tugas").on("submit", function(e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=simpan_data_tugas',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            window.location.href = "tambah_tugas.php?tgs=" + data.last_id;
          } else {
            var html = '<div class="note note-danger">';
            html += '<p> ' + data.errors + ' </p>';
            html += '</div>';
            $('#pesan').html(html)
          }
        }
      });
    });

    $('.btn-hapus').on('click', function() {
      var id_tugas = $(this).attr('data-id');
      var judul = $('#judul-' + id_tugas).html();
      $('#id-tugas').val(id_tugas);
      $('#hapus-tugas').modal('show');
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
          window.location.reload();
        }
      });
    });
  })
</script>
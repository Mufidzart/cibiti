<?php
require('backend/connection.php');
$page_title = "Tugas Learning Management System (LMS)";
require('frontend/layouts/headlayout.php');
$data_tugas = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE id_staff='197211012007011009' AND id_mapel='47'");
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
                        $img = "tugas-1.webp";
                      } elseif ($tugas['jenis'] == "UTS") {
                        $img = "tugas-2.webp";
                      } else {
                        $img = "tugas-3.webp";
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
                            <span class="mt-action-author"><?= $tugas['judul'] ?></span>
                            <p class="mt-action-desc"><?= $tugas['deskripsi'] ?></p>
                          </div>
                        </div>
                      </a>
                      <div class="mt-action-info ">
                        <div class="mt-action-details ">
                          <span class="mt-action-author">Jumlah Soal</span>
                          <p class="mt-action-desc">30 Soal</p>
                        </div>
                      </div>
                      <div class="mt-action-datetime ">
                        <span class="mt-action-date">Dibuat: </span>
                        <span class="mt=action-time"><?= $tugas['tgl_input'] ?></span>
                      </div>
                      <div class="mt-action-buttons ">
                        <div class="btn-group btn-group-circle">
                          <button type="button" class="btn btn-outline green btn-sm">Lihat</button>
                          <button type="button" class="btn btn-outline red btn-sm">Hapus</button>
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
          <div class="form-body">
            <div class="form-group">
              <label>Judul Tugas</label>
              <input class="form-control spinner" type="text" id="judul-tugas" name="judul-tugas" placeholder="Judul tugas">
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
          window.location.href = "tambah_tugas.php?tgs=" + data;
        }
      });
    });
  })
</script>
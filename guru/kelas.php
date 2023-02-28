<?php
require '../config/lms_connection.php';
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
// $getkelasmapel = $conn->query("SELECT ak.id,ak.nama_kelas,ak.parent_id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel JOIN arf_siswa_kelashistory ask ON ask.id=agm.id_subkelas JOIN arf_kelas ak ON ak.id=ask.id_kelas WHERE agm.id_staf='$session_id_staf' AND agm.id_thajaran=$id_thajaran");
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
          <small>dashboard & statistics</small>
        </h1>
      </div>
      <!-- END PAGE TITLE -->
      <!-- BEGIN PAGE TOOLBAR -->
      <div class="page-toolbar">
        <!-- BEGIN THEME PANEL -->
        <div class="btn-group btn-theme-panel">
          <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
            <i class="icon-settings"></i>
          </a>
          <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <h3>FILTER DATA</h3>
                <form role="form" id="form-filter">
                  <div class="form-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="control-label">Tahun Ajaran</label>
                          <select class="form-control select2" id="set-tahun-ajaran" name="set-tahun-ajaran">
                            <option></option>
                            <?php $arf_thajaran = mysqli_query($conn, "SELECT * FROM arf_thajaran WHERE publish='yes'");
                            while ($row = mysqli_fetch_assoc($arf_thajaran)) :
                              $select = ($row['id'] == $id_thajaran) ? "selected" : ""; ?>
                              <option value="<?= $row['id'] ?>" <?= $select ?>><?= $row['tahun_pelajaran'] ?></option>
                            <?php endwhile; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="control-label">Semester</label>
                          <select class="form-control select2" id="set-semester" name="set-semester">
                            <option></option>
                            <?php $arf_semester = [1, 2];
                            foreach ($arf_semester as $item) :
                              $select = ($item == $semester) ? "selected" : ""; ?>
                              <option value="<?= $item ?>" <?= $select ?>><?= $item ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn green">Terapkan</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- END THEME PANEL -->
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
        <span class="active">Dashboard</span>
      </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div id="tampil-kelas">

    </div>
    <!-- END PAGE BASE CONTENT -->
  </div>
  <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<?php
require('layouts/bodylayout.php');
?>
<script>
  function get_kelas() {
    var id_thajaran = $("#set-tahun-ajaran").val();
    var semester = $("#set-semester").val();
    $.ajax({
      url: 'backend/function.php?action=get_kelas',
      type: 'post',
      data: {
        id_thajaran: id_thajaran,
        semester: semester
      },
      cache: false,
      success: function(data) {
        $("#tampil-kelas").html(data);
      }
    });
  }

  $(document).ready(function() {
    get_kelas();

    $("#set-tahun-ajaran").select2({
      placeholder: "Pilih tahun ajaran...",
      width: "100%"
    });
    $("#set-semester").select2({
      placeholder: "Pilih semester...",
      width: "100%"
    });

    $("#form-filter").on("submit", function(e) {
      e.preventDefault();
      get_kelas();
    });
  });
</script>
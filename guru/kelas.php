<?php
require('../backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('../frontend/layouts/headlayout.php');
// $getkelasmapel = $conn->query("SELECT ak.id,ak.nama_kelas,ak.parent_id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel JOIN arf_siswa_kelashistory ask ON ask.id=agm.id_subkelas JOIN arf_kelas ak ON ak.id=ask.id_kelas WHERE agm.id_staf='$session_id_staf' AND agm.id_thajaran=$id_thajaran");
$getkelasmapel = $conn->query("SELECT ak.id,ak.nama_kelas,ak.parent_id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel JOIN arf_kelas ak ON ak.id=agm.id_subkelas WHERE agm.id_staf='$session_id_staf' AND agm.id_thajaran=$id_thajaran");
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
        <div id="dashboard-report-range" data-display-range="0" class="pull-right tooltips btn btn-fit-height green" data-placement="left" data-original-title="Change dashboard date range">
          <i class="icon-calendar"></i>&nbsp;
          <span class="thin uppercase hidden-xs"></span>&nbsp;
          <i class="fa fa-angle-down"></i>
        </div>
        <!-- BEGIN THEME PANEL -->
        <div class="btn-group btn-theme-panel">
          <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
            <i class="icon-settings"></i>
          </a>
          <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
            <div class="row">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <h3>HEADER</h3>
                <ul class="theme-colors">
                  <li class="theme-color theme-color-default active" data-theme="default">
                    <span class="theme-color-view"></span>
                    <span class="theme-color-name">Dark Header</span>
                  </li>
                  <li class="theme-color theme-color-light " data-theme="light">
                    <span class="theme-color-view"></span>
                    <span class="theme-color-name">Light Header</span>
                  </li>
                </ul>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12 seperator">
                <h3>LAYOUT</h3>
                <ul class="theme-settings">
                  <li> Theme Style
                    <select class="layout-style-option form-control input-small input-sm">
                      <option value="square">Square corners</option>
                      <option value="rounded" selected="selected">Rounded corners</option>
                    </select>
                  </li>
                  <li> Layout
                    <select class="layout-option form-control input-small input-sm">
                      <option value="fluid" selected="selected">Fluid</option>
                      <option value="boxed">Boxed</option>
                    </select>
                  </li>
                  <li> Header
                    <select class="page-header-option form-control input-small input-sm">
                      <option value="fixed" selected="selected">Fixed</option>
                      <option value="default">Default</option>
                    </select>
                  </li>
                  <li> Top Dropdowns
                    <select class="page-header-top-dropdown-style-option form-control input-small input-sm">
                      <option value="light">Light</option>
                      <option value="dark" selected="selected">Dark</option>
                    </select>
                  </li>
                  <li> Sidebar Mode
                    <select class="sidebar-option form-control input-small input-sm">
                      <option value="fixed">Fixed</option>
                      <option value="default" selected="selected">Default</option>
                    </select>
                  </li>
                  <li> Sidebar Menu
                    <select class="sidebar-menu-option form-control input-small input-sm">
                      <option value="accordion" selected="selected">Accordion</option>
                      <option value="hover">Hover</option>
                    </select>
                  </li>
                  <li> Sidebar Position
                    <select class="sidebar-pos-option form-control input-small input-sm">
                      <option value="left" selected="selected">Left</option>
                      <option value="right">Right</option>
                    </select>
                  </li>
                  <li> Footer
                    <select class="page-footer-option form-control input-small input-sm">
                      <option value="fixed">Fixed</option>
                      <option value="default" selected="selected">Default</option>
                    </select>
                  </li>
                </ul>
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
    <div class="row widget-row">
      <?php
      $colorbg = ["bg-red", "bg-blue", "bg-green", "bg-red", "bg-blue", "bg-green", "bg-red", "bg-blue", "bg-green", "bg-red"];
      $i = 0;
      while ($datakelas = mysqli_fetch_assoc($getkelasmapel)) :
        $no = substr($i, -1);
        $bg = $colorbg[$no];
        if ($datakelas['parent_id'] == 1) {
          $grade = "X";
        } elseif ($datakelas['parent_id'] == 2) {
          $grade = "XI";
        } elseif ($datakelas['parent_id'] == 3) {
          $grade = "XII";
        }
        $kelas = $grade . " " . $datakelas['nama_kelas'];
        $getsiswa = $conn->query("SELECT * FROM arf_siswa WHERE id_kelasaktif='" . $kelas . "'");
        $countsiswa = $getsiswa->num_rows;
      ?>
        <a href="detail_kelas.php?kelas=<?= $datakelas['id'] ?>">
          <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
              <h4 class="widget-thumb-heading"><?= $datakelas['nama_mapel'] ?></h4>
              <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon <?= $bg ?> icon-layers" style="margin-top: 10px;"></i>
                <div class="widget-thumb-body">
                  <span class="widget-thumb-subtitle"><?= $kelas ?></span>
                  <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $countsiswa ?>">0</span> Siswa
                </div>
              </div>
            </div>
            <!-- END WIDGET THUMB -->
          </div>
        </a>
      <?php
        $i++;
      endwhile; ?>
    </div>
    <!-- END PAGE BASE CONTENT -->
  </div>
  <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<?php
require('../frontend/layouts/bodylayout.php');
?>
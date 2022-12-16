<?php
require('backend/connection.php');
$page_title = "Detail Kelas";
require('frontend/layouts/headlayout.php');
$id_kelas = $_GET['kelas'];
$getkelasmapel = mysqli_query($conn, "SELECT ak.id,ak.nama_kelas,ak.parent_id,am.nama_mapel,ak.program_keahlian,stf.nama_lengkap,stf.email FROM arf_guru_mapel agm JOIN arf_staf stf ON stf.nip=agm.id_staf JOIN arf_mapel am ON am.id=agm.id_mapel JOIN arf_kelas ak ON ak.id=agm.id_subkelas WHERE ak.id=$id_kelas AND agm.id_staf='$session_id_staf' AND agm.id_thajaran=$id_thajaran");
$datakelas = mysqli_fetch_assoc($getkelasmapel);
if ($datakelas['parent_id'] == 1) {
  $grade = "X";
} elseif ($datakelas['parent_id'] == 2) {
  $grade = "XI";
} elseif ($datakelas['parent_id'] == 3) {
  $grade = "XII";
}
$kelas = $grade . " " . $datakelas['nama_kelas'];
$getsiswa = $conn->query("select * from arf_siswa where id_kelasaktif='" . $kelas . "'");
$countsiswa = $getsiswa->num_rows;
?>
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
              <div class="col-md-3">
                <div class="profile-sidebar">
                  <!-- PORTLET MAIN -->
                  <div class="portlet light profile-sidebar-portlet">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                      <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt="">
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
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-12 profile-info">
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
                  <!--end col-md-8-->
                </div>
                <!--end row-->
              </div>
            </div>
          </div>
          <!--tab_1_2-->
          <div class="tab-pane" id="tab_peserta">
            <div class="mt-comments">
              <?php while ($datasiswa = mysqli_fetch_array($getsiswa)) : ?>
                <div class="mt-comment">
                  <div class="mt-comment-img">
                    <img src="../assets/pages/media/users/avatar1.jpg">
                  </div>
                  <div class="mt-comment-body">
                    <div class="mt-comment-info">
                      <span class="mt-comment-author"><?= $datasiswa['nama_siswa'] ?></span>
                      <!-- <span class="mt-comment-date">26 Feb, 10:30AM</span> -->
                    </div>
                    <div class="mt-comment-text">NIS: <?= $datasiswa['nis'] ?> <?= (!empty($datasiswa['email_siswa'])) ? "- EMAIL : " . $datasiswa['email_siswa'] : "" ?></div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
          <!--end tab-pane-->
          <div class="tab-pane" id="tab_penugasan">
            Tab Penugasan
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
<?php
require('frontend/layouts/bodylayout.php');
?>
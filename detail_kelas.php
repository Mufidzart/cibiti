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
                    <img src="../assets/images/person_avatar.png" style="width:100%;">
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
            <div class="row todo-ui">
              <div class="col-md-3 todo-sidebar">
                <div class="portlet light bordered">
                  <div class="portlet-title">
                    <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                      <span class="caption-subject font-green-sharp bold uppercase">Menu </span>
                      <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
                    </div>
                  </div>
                  <div class="portlet-body todo-project-list-content" style="height: auto;">
                    <div class="todo-project-list">
                      <ul class="nav nav-stacked">
                        <li>
                          <a href="javascript:;" data-toggle="collapse" data-target=".akan-berakhir"> Tugas Akan Berakhir </a>
                          <div class="alert alert-info" style="margin-left:30px;">
                            <?php if (isset($_GET['action'])) : ?>
                              Tidak ada tugas berjalan!
                            <?php else : ?>
                              <a href="javascript:;">
                                <strong>26 Feb 2022, 10:30AM</strong> <br>
                                (BE02BF) Tugas Pertama
                              </a>
                            <?php endif; ?>
                          </div>
                          <!-- <a href="javascript:;" data-toggle="collapse" data-target=".akan-berakhir"><span class="badge badge-info"> 0 </span> Tugas Akan Berakhir </a> -->
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9 todo-content">
                <form class="form-horizontal" role="form" id="form-edit-tugas">
                  <div class="form-body">
                    <div class="form-group">
                      <label class="col-md-1 control-label vcenter">
                        <img alt="" class="img-circle bg-white" style="padding:2px;width:40px;" src="../assets/images/admin_avatar.png" />
                      </label>
                      <div class="col-md-9 vcenter" style="padding-top:7px;">
                        <input class="form-control spinner input-circle" type="text" id="tambah-penugasan" name="tambah-penugasan" placeholder="Tambah penugasan..." value="">
                      </div>
                    </div>
                  </div>
                </form>
                <hr>
                <div class="note note-info">
                  <div class="mt-comments">
                    <div class="mt-comment">
                      <div class="mt-comment-body">
                        <div class="mt-comment-info">
                          <span class="mt-comment-author">Judul Penugasan</span>
                          <span class="mt-comment-date">26 Feb 2022, 10:30 WIB</span>
                        </div>
                        <div class="mt-comment-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. </div>
                        <div class="alert alert-info" style="margin-top:10px;">
                          <strong>
                            <i class="fa fa-calendar"></i> Batas Akhir 12 Desember 2023, 23:00 WIB
                          </strong>
                        </div>
                        <div class="mt-comment-details">
                          <span class="mt-comment-status mt-comment-status-pending">
                            <div class="row">
                              <div class="col-md-12">
                                <a href="javascript:;" class="btn btn-circle default green-stripe">BE02BF</a>
                                <span style="color:#327ad5;padding-top:7px;text-transform: none;">!klik untuk mengerjakan</span>
                              </div>
                            </div>
                          </span>
                          <ul class="mt-comment-actions">
                            <li>
                              <a href="#">Edit</a>
                            </li>
                            <li>
                              <a href="#">Hapus</a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
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
            <div class="form-group">
              <label class="control-label">Judul Penugasan</label>
              <input class="form-control spinner input-circle" type="text" id="judul-penugasan" name="judul-penugasan" placeholder="Judul penugasan..." value="">
            </div>
            <div class="form-group">
              <label class="control-label">Deskripsi penugasan</label>
              <textarea class="form-control input-circle" id="deskripsi-penugasan" name="deskripsi-penugasan" rows="3" placeholder="Deskripsi penugasan..."></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Jenis Tugas</label>
              <select class="form-control select2" id="jenis-tugas" name="jenis-tugas">
                <?php while ($jenis = mysqli_fetch_array($jenis_tugas)) :
                  $select = ($jenis['jenis_tugas'] == $tugas['jenis']) ? "selected" : ""; ?>
                  <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="single" class="control-label">Select2 single select</label>
              <select id="single" class="form-control select2">
                <option></option>
                <optgroup label="Alaskan">
                  <option value="AK">Alaska</option>
                  <option value="HI" disabled="disabled">Hawaii</option>
                </optgroup>
                <optgroup label="Pacific Time Zone">
                  <option value="CA">California</option>
                  <option value="NV">Nevada</option>
                  <option value="OR">Oregon</option>
                  <option value="WA">Washington</option>
                </optgroup>
              </select>
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
<?php
require('frontend/layouts/bodylayout.php');
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tambah-penugasan').on('click', function() {
      $('#modal-tambah-penugasan').modal('show');
    });
  });
</script>
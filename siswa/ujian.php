<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$id_penugasan = $_GET['tgs'];
$getpenugasan =  $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
$datapenugasan = mysqli_fetch_assoc($getpenugasan);
$kode_tugas = $datapenugasan['kode_tugas'];
$gettugas =  $conn->query("SELECT * FROM arf_tugas_cbt WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
$datatugas = mysqli_fetch_assoc($gettugas);
// $getsiswa = $conn->query(
//   "SELECT asw.*,ask.id_kelas_induk,ask.id_kelas
//   FROM arf_siswa asw
//   JOIN arf_siswa_kelashistory ask ON ask.nis=asw.nis
//   WHERE asw.nis=$nis
//   AND ask.id_thajaran=$id_thajaran
//   ANd ask.id_semester=$semester"
// );
// $datasiswa = mysqli_fetch_assoc($getsiswa);
// $kelas_siswa = $datasiswa['id_kelas_induk'];
// $subkelas_siswa = $datasiswa['id_kelas'];
// $id_staf = $_GET['g'];
// $id_mapel = $_GET['mpl'];
?>
<!-- BEGIN CONTENT -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Container-->
  <div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <div class="card">
      <!--begin::Card body-->
      <div class="card-body p-0">
        <!--begin::Wrapper-->
        <div class="card-px text-center py-20 my-10">
          <!--begin::Title-->
          <h2 class="fs-2x fw-bolder mb-10">Mulai Mengerjakan!</h2>
          <!--end::Title-->
          <!--begin::Description-->
          <div id="show_detail_penugasan">
            <p class="text-gray-400 fs-4 fw-bold mb-10">Pastikan Kode Soal sudah sesuai<br>
              <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $penugasan['kode_tugas'] ?>">
                <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
                <span class="d-flex flex-column align-items-start ms-2">
                  <span class="fs-3 fw-bolder"><?= $datatugas['kode_tugas'] ?></span>
                </span>
              </a>
              <br>Batas waktu mengerjakan adalah
              <br> <b class="text-primary fs-1"><?= $datapenugasan['durasi_menit'] ?> menit</b>
              <br>Tugas akan berakhir pada
              <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($datapenugasan['waktu_selesai']))) ?> pukul <?= date("H:i", strtotime($datapenugasan['waktu_selesai'])) ?> WIB</b>
            </p>
          </div>
          <!--end::Description-->
          <!--begin::Action-->
          <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Mulai</a>
          <!--end::Action-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Illustration-->
        <div class="text-center px-4">
          <img class="mw-100 mh-300px" alt="" src="assets/media/illustrations/sigma-1/2.png" />
        </div>
        <!--end::Illustration-->
      </div>
      <!--end::Card body-->
    </div>
    <!--end::Card-->
  </div>
  <!--end::Container-->
</div>
<!-- END CONTENT -->
<?php
require('layouts/bodylayout.php');
?>
<script type="text/javascript">
  function get_penugasan() {
    var kelas_siswa = '<?= $kelas_siswa ?>';
    var subkelas_siswa = '<?= $subkelas_siswa ?>';
    var id_staf = '<?= $id_staf ?>';
    var id_mapel = '<?= $id_mapel ?>';
    $.ajax({
      url: 'backend/function.php?action=get_data&get=data_penugasan',
      type: 'post',
      data: {
        kelas_siswa: kelas_siswa,
        subkelas_siswa: subkelas_siswa,
        id_staf: id_staf,
        id_mapel: id_mapel
      },
      success: function(data) {
        $('#show_penugasan').html(data);
      }
    });
  }
  $(document).ready(function() {
    get_penugasan();
  })
</script>
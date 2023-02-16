<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$id_tugas_penugasan = $_GET['tgs'];
$get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id='$id_tugas_penugasan' AND tgl_hapus IS NULL");
$tugas = mysqli_fetch_assoc($get_tugas_penugasan);
$id_penugasan = $tugas['id_penugasan'];
$getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
$datapenugasan = mysqli_fetch_assoc($getpenugasan);
?>
<!-- BEGIN CONTENT -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Container-->
  <div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <?php
    $max_jam = new DateTime($tugas['batas_tugas']);
    $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
    $getprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id_siswa='$nis' AND id_tugas_penugasan=$id_tugas_penugasan");
    if ($getprosesujian->num_rows == 0) {
      if ($jam_sekarang < $max_jam) {
        require('views/ujian/mulai_ujian.php');
      } else {
        require('views/ujian/telat_ujian.php');
      }
    } else {
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      if (empty($dataprosesujian['selesai_ujian'])) {
        $durasi = $tugas['durasi_tugas'];
        $mulai_ujian = $dataprosesujian['mulai_ujian'];
        $jam_mulai = new DateTime($mulai_ujian);
        $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
        $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
        if ($jam_sekarang < $jam_berakhir) {
          require('views/ujian/proses_ujian.php');
        } else {
          require('views/ujian/selesai_ujian.php');
        }
      } else {
        require('views/ujian/selesai_ujian.php');
      }
    }
    ?>
    <!--end::Card-->
  </div>
  <!--end::Container-->
</div>
<!-- END CONTENT -->
<?php
require('layouts/bodylayout.php');
?>
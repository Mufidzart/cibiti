<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$id_penugasan = $_GET['tgs'];
$getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
$datapenugasan = mysqli_fetch_assoc($getpenugasan);
$max_jam = new DateTime($datapenugasan['batas_tugas_awal']);
$jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
$idpenugasan = $datapenugasan['id'];
$kode_tugas = $datapenugasan['tugas_awal'];
$gettugas =  $conn->query("SELECT * FROM arf_tugas_cbt WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
$datatugas = mysqli_fetch_assoc($gettugas);
$getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$idpenugasan");
?>
<!-- BEGIN CONTENT -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Container-->
  <div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <?php
    if ($getprosesujian->num_rows == 0) {
      if ($jam_sekarang < $max_jam) {
        require('views/ujian/mulai_ujian.php');
      } else {
        require('views/ujian/telat_ujian.php');
      }
    } else {
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      if (empty($dataprosesujian['selesai_ujian'])) {
        $durasi = $datapenugasan['durasi_menit_tugas_awal'];
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
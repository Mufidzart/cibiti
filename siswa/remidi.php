<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$id_penugasan = $_GET['tgs'];
$jenis_ujian = $_GET['act'];
$getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
$datapenugasan = mysqli_fetch_assoc($getpenugasan);
?>
<!-- BEGIN CONTENT -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Container-->
  <div class="container-xxl" id="kt_content_container">
    <!--begin::Card-->
    <?php
    if ($_GET['act'] == "r1") {
      $title = "Remidi 1";
      $kode_tugas = $datapenugasan['r1'];
      $durasi = $datapenugasan['durasi_menit_r1'];
      $batas = $datapenugasan['batas_r1'];
    } elseif ($_GET['act'] == "r2") {
      $title = "Remidi 2";
      $kode_tugas = $datapenugasan['r2'];
      $durasi = $datapenugasan['durasi_menit_r2'];
      $batas = $datapenugasan['batas_r2'];
    }
    $max_jam = new DateTime($batas);
    $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
    $idpenugasan = $datapenugasan['id'];
    $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$idpenugasan AND jenis_ujian='$jenis_ujian'");
    if ($getprosesujian->num_rows == 0) {
      if ($jam_sekarang < $max_jam) {
        require('views/remidi/mulai_ujian.php');
      } else {
        require('views/remidi/telat_ujian.php');
      }
    } else {
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      if (empty($dataprosesujian['selesai_ujian'])) {
        $mulai_ujian = $dataprosesujian['mulai_ujian'];
        $jam_mulai = new DateTime($mulai_ujian);
        $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
        $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
        if ($jam_sekarang < $jam_berakhir) {
          require('views/remidi/proses_ujian.php');
        } else {
          require('views/remidi/selesai_ujian.php');
        }
      } else {
        require('views/remidi/selesai_ujian.php');
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
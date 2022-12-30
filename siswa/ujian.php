<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$id_penugasan = $_GET['tgs'];
$getpenugasan =  $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
$datapenugasan = mysqli_fetch_assoc($getpenugasan);
$idpenugasan = $datapenugasan['id'];
$kode_tugas = $datapenugasan['kode_tugas'];
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
      require('views/ujian/mulai_ujian.php');
    } else {
      $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
      require('views/ujian/proses_ujian.php');
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
<script type="text/javascript">
  $(document).ready(function() {
    $('#mulai_ujian').on('click', function(event) {
      var id_penugasan = $(this).attr("data-penugasan");
      $.ajax({
        url: 'backend/function.php?action=mulai_ujian',
        type: 'post',
        data: {
          id_penugasan: id_penugasan
        },
        success: function(data) {
          // console.log(id_penugasan);
          location.reload();
        }
      });
    })
  })
</script>
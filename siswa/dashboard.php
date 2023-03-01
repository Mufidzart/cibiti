<?php
require '../config/lms_connection.php';
include '../helpers/helpers.php';
include '../helpers/tanggal_helper.php';
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$getsiswa = $conn->query("SELECT * FROM arf_siswa WHERE nis=$nis");
$datasiswa = mysqli_fetch_assoc($getsiswa);
?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="container-xxl" id="kt_content_container">
    <div class="row g-5 g-xl-8">
      <div class="col-xl-4">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
          <div class="card-body p-9">
            <div class="row mb-7">
              <div class="symbol symbol-100px symbol-lg-160px symbol-fixed text-center">
                <img src="assets/images/person_avatar.png" alt="image" />
              </div>
            </div>
            <div class="row mb-7">
              <label class="col-lg-4 fw-bold text-muted">NAMA</label>
              <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800"><?= $datasiswa['nama_siswa'] ?></span>
              </div>
            </div>
            <div class="row mb-7">
              <label class="col-lg-4 fw-bold text-muted">NIS</label>
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= $datasiswa['nis'] ?></span>
              </div>
            </div>
            <div class="row mb-7">
              <label class="col-lg-4 fw-bold text-muted">NISN</label>
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= ($datasiswa['nisn'] ? $datasiswa['nisn'] : "-") ?></span>
              </div>
            </div>
            <div class="row mb-7">
              <label class="col-lg-4 fw-bold text-muted">EMAIL</label>
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= ($datasiswa['email_siswa'] ? $datasiswa['email_siswa'] : "-") ?></span>
              </div>
            </div>
            <div class="row mb-7">
              <label class="col-lg-4 fw-bold text-muted">TTL</label>
              <?php
              $tanggal = explode("/", $datasiswa['tanggal_lahir']);
              $day = $tanggal[1];
              $month = $tanggal[0];
              $year = $tanggal[2];
              $tgl_lahir = tgl_indo($year . "-" . $month . "-" . $day);
              ?>
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= ucwords(strtolower($datasiswa['tempat_lahir'])) . ", " . $tgl_lahir ?></span>
              </div>
            </div>
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
              <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                  <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black" />
                  <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black" />
                </svg>
              </span>
              <div class="d-flex flex-stack flex-grow-1">
                <div class="fw-bold">
                  <h4 class="text-gray-900 fw-bolder">Perhatian!</h4>
                  <div class="fs-6 text-gray-700">Segera lengkapi biodata Anda dengan menghubungi Wali Kelas.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-8 ps-xl-12">
        <div class="card bgi-position-y-bottom bgi-position-x-end bgi-no-repeat bgi-size-cover min-h-250px bg-primary mb-5 mb-xl-8" style="background-position: 100% 50px;background-size: 500px auto;background-image:url('assets/media/misc/city.png')">
          <div class="card-body d-flex flex-column justify-content-center">
            <?php
            $dat = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $date = $dat->format('H');
            if ($date < 10)
              $selamat = "Selamat Pagi";
            else if ($date < 15)
              $selamat = "Selamat Siang";
            else if ($date < 19)
              $selamat = "Selamat Sore";
            else
              $selamat = "Selamat Malam";
            ?>
            <h3 class="text-white fs-2x fw-bolder line-height-lg mb-5"><?= $selamat ?>
              <br /><?= ucwords(strtolower($datasiswa['nama_siswa'])) ?>
            </h3>
            <div class="m-0">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-xxl" id="kt_content_container">
    <div class="row g-5 g-xl-8">
      <div class="col-xl-12">
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
          <div class="card-header border-0">
            <h3 class="card-title">
              Mata Pelajaran Kelas:
              <div class="fv-row" style="margin-left: 20px;">
                <select name="pilih-kelas" id="pilih-kelas" aria-label="Pilih kelas" data-control="select2" data-placeholder="Pilih kelas...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="form-select form-select-solid form-select-lg fw-bold">
                  <option value=""></option>
                  <?php $gethistorisiswa = $conn->query("SELECT DISTINCT id_kelas_induk,id_kelas,id_thajaran,keterangan FROM arf_siswa_kelashistory WHERE nis=$nis AND status='aktif'");
                  while ($row = mysqli_fetch_assoc($gethistorisiswa)) :
                    $id_kelas_induk = $row['id_kelas_induk'];
                    $id_kelas = $row['id_kelas'];
                    $idthajaran = $row['id_thajaran'];
                    if ($id_kelas_induk == 1) {
                      $grade = "X";
                    } elseif ($id_kelas_induk == 2) {
                      $grade = "XI";
                    } elseif ($id_kelas_induk == 3) {
                      $grade = "XII";
                    }
                    $getkelassiswa = $conn->query("SELECT * FROM arf_kelas WHERE id=$id_kelas");
                    $kelas = mysqli_fetch_assoc($getkelassiswa);
                    $kelas_deskripsi = $kelas['deskripsi'];
                    $nama_kelas = $kelas['nama_kelas'];
                    $getthajaran = $conn->query("SELECT * FROM arf_thajaran WHERE id=$idthajaran");
                    $thajaran = mysqli_fetch_assoc($getthajaran);
                    $tahun_pelajaran = $thajaran['tahun_pelajaran'];
                    $select = ($idthajaran == $_SESSION['id_thajaran']) ? "selected" : "";
                  ?>
                    <option value="<?= $id_kelas_induk . '/' . $id_kelas . '/' . $idthajaran ?>" <?= $select ?>><?= $grade . " - " . $kelas_deskripsi . "(" . $nama_kelas . ") - " . str_replace("-", "/", $tahun_pelajaran) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </h3>
            <div class="card-toolbar">
              <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <span class="svg-icon svg-icon-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                      <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
                      <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                      <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                      <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
                    </g>
                  </svg>
                </span>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div id="tampil-mapel">
              <div class="d-flex flex-column flex-root">
                <div class="d-flex flex-column flex-center flex-column-fluid p-10">
                  <img src="assets/media/illustrations/sigma-1/18.png" alt="" class="mw-100 mb-10 h-lg-450px" />
                  <h1 class="fw-bold mb-10" style="color: #A3A3C7">Tidak ada data Mata Pelajaran, silahkan pilih kelas dahulu.</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require('layouts/bodylayout.php');
?>
<script>
  function get_mapel() {
    var data_kelas = $("#pilih-kelas").val();
    if (data_kelas) {
      $.ajax({
        url: 'backend/function.php?action=get_mapel',
        type: 'post',
        data: {
          data_kelas: data_kelas
        },
        cache: false,
        success: function(data) {
          $("#tampil-mapel").html(data);
        }
      });
    }
  }

  $(document).ready(function() {
    get_mapel();

    $('#pilih-kelas').on('select2:select', function(e) {
      get_mapel();
    });
  });
</script>
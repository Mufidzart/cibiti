<?php
$id_penugasan = $_GET['tgs'];
$getpenugasan = $conn->query("SELECT * FROM arf_history_penugasan WHERE id=$id_penugasan AND tgl_hapus IS NULL");
$datapenugasan = mysqli_fetch_assoc($getpenugasan);
$max_jam = new DateTime($datapenugasan['waktu_selesai']);
$jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
if ($jam_sekarang < $max_jam) :
?>
  <div class="card">
    <!--begin::Card body-->
    <div class="card-body p-0">
      <!--begin::Wrapper-->
      <div class="card-px text-center py-20 my-10">
        <!--begin::Title-->
        <h2 class="fs-2x fw-bolder mb-10">Mulai Mengerjakan!</h2>
        <!--end::Title-->
        <!--begin::Description-->
        <p class="text-gray-400 fs-4 fw-bold mb-10">Pastikan Kode Soal sudah sesuai<br>
          <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $penugasan['kode_tugas'] ?>">
            <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
            <span class="d-flex flex-column align-items-start ms-2">
              <span class="fs-3 fw-bolder"><?= $datatugas['kode_tugas'] ?></span>
            </span>
          </a>
          <?php if ($datapenugasan['durasi_menit'] == 0) : ?>
            <br>Kerjakan sebelum
          <?php else : ?>
            <br>Batas waktu mengerjakan adalah
            <br> <b class="text-primary fs-1"><?= $datapenugasan['durasi_menit'] ?> menit</b>
            <br>Tugas akan berakhir pada
          <?php endif; ?>
          <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($datapenugasan['waktu_selesai']))) ?> pukul <?= date("H:i", strtotime($datapenugasan['waktu_selesai'])) ?> WIB</b>
        </p>
        <!--end::Description-->
        <!--begin::Action-->
        <a href="javascript:;" class="btn btn-primary" id="mulai_ujian" data-penugasan="<?= $datapenugasan['id'] ?>">Mulai</a>
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
<?php else : ?>
  <div class="card">
    <!--begin::Card body-->
    <div class="card-body p-0">
      <!--begin::Wrapper-->
      <div class="card-px text-center py-20 my-10">
        <!--begin::Title-->
        <h2 class="fs-2x fw-bolder mb-10">Anda telah melewati batas pengisian <?= $datapenugasan['judul'] ?></h2>
        <!--end::Title-->
        <!--begin::Description-->
        <p class="text-gray-400 fs-4 fw-bold mb-10">Kode Soal<br>
          <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $penugasan['kode_tugas'] ?>">
            <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
            <span class="d-flex flex-column align-items-start ms-2">
              <span class="fs-3 fw-bolder"><?= $datatugas['kode_tugas'] ?></span>
            </span>
          </a>
          <?php if ($datapenugasan['durasi_menit'] == 0) : ?>
            <br>Kerjakan sebelum
          <?php else : ?>
            <br>Batas waktu mengerjakan adalah
            <br> <b class="text-primary fs-1"><?= $datapenugasan['durasi_menit'] ?> menit</b>
            <br>Tugas berakhir pada
          <?php endif; ?>
          <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($datapenugasan['waktu_selesai']))) ?> pukul <?= date("H:i", strtotime($datapenugasan['waktu_selesai'])) ?> WIB</b>
        </p>
        <!--end::Description-->
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
<?php endif; ?>
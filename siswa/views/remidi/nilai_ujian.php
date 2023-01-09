<!--begin::Wrapper-->
<div class="card-px text-center">
  <div id="spinner" style="display: none;">
    <h2 class="fs-2x my-8" id="judul_selesai">Tugas selesai!</h2>
    <div class="spinner-grow text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-secondary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-success" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-danger" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-warning" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow text-info" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-gray-400 fs-4 fw-bold">
      <br>Menghitung nilai Anda</b>
    </p>
  </div>
  <div id="penilaian" style="display: none;">
    <!--begin::Title-->
    <h2 class="fs-2x fw-bolder mb-10">Anda telah selesai mengerjakan!</h2>
    <!--end::Title-->
    <!--begin::Description-->
    <p class="text-gray-400 fs-4 fw-bold">Anda mendapat nilai<br>
      <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $datanewnilai['kode-tugas'] ?>">
        <!-- <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span> -->
        <span class="d-flex flex-column align-items-start ms-2">
          <?php
          if ($jenis_ujian == "r1") {
            $title = "Remidi 1";
            $nilai = $datanewnilai['nilai_r1'];
          } elseif ($jenis_ujian == "r2") {
            $title = "Remidi 2";
            $nilai = $datanewnilai['nilai_r2'];
          }
          ?>
          <span class="fs-3 fw-bolder"> <b class="text-primary fs-1"><?= $nilai ?></b></span>
        </span>
      </a>
      <br>Penugasan
      <br> <b class="text-primary"><?= $title ?></b>
      <br>Anda mengerjakan soal pada
      <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($dataprosesujian['mulai_ujian']))) ?> pukul <?= date("H:i", strtotime($dataprosesujian['mulai_ujian'])) ?> WIB</b>
    </p>
    <!--end::Description-->
  </div>
</div>
<!--end::Wrapper-->
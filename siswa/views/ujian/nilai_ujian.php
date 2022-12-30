<div class="card">
  <!--begin::Card body-->
  <div class="card-body p-0">
    <!--begin::Wrapper-->
    <div class="card-px text-center py-20 my-10">
      <!--begin::Title-->
      <h2 class="fs-2x fw-bolder mb-10">Anda Telah Mengerjakan!</h2>
      <!--end::Title-->
      <!--begin::Description-->
      <p class="text-gray-400 fs-4 fw-bold mb-10">Anda mendapat nilai<br>
        <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $penugasan['kode_tugas'] ?>">
          <!-- <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span> -->
          <span class="d-flex flex-column align-items-start ms-2">
            <span class="fs-3 fw-bolder"> <b class="text-primary fs-1"><?= $datapenugasan['durasi_menit'] ?></b></span>
          </span>
        </a>

        <br>Kode Soal
        <br> <b class="text-primary"><?= $datatugas['kode_tugas'] ?></b>
        <br>Anda mengerjakan soal pada
        <br> <b class="text-primary"><?= tgl_indo(date_format($jam_mulai, "d-m-Y")) ?> pukul <?= date_format($jam_mulai, "H:i") ?> WIB</b>
        <br>Sampai
        <br> <b class="text-primary"><?= tgl_indo(date_format($jam_berakhir, "d-m-Y")) ?> pukul <?= date_format($jam_berakhir, "H:i") ?> WIB</b>
      </p>
      <!--end::Description-->
      <!--begin::Action-->
      <a href="javascript:;" class="btn btn-primary" id="lihat_jawaban" data-penugasan="<?= $datapenugasan['id'] ?>">Lihat Jawaban Anda</a>
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
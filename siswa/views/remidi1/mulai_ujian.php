  <div class="card">
    <!--begin::Card body-->
    <div class="card-body p-0">
      <!--begin::Wrapper-->
      <div class="card-px text-center py-20 my-10">
        <!--begin::Title-->
        <h2 class="fs-2x fw-bolder mb-10">Mulai Mengerjakan Remidi 1!</h2>
        <!--end::Title-->
        <!--begin::Description-->
        <p class="text-gray-400 fs-4 fw-bold mb-10">Pastikan Kode Soal sudah sesuai<br>
          <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $penugasan['kode_tugas'] ?>">
            <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
            <span class="d-flex flex-column align-items-start ms-2">
              <span class="fs-3 fw-bolder"><?= $datatugas['kode_tugas'] ?></span>
            </span>
          </a>
          <?php if ($datapenugasan['durasi_menit_r1'] == 0) : ?>
            <br>Kerjakan sebelum
          <?php else : ?>
            <br>Batas waktu mengerjakan adalah
            <br> <b class="text-primary fs-1"><?= $datapenugasan['durasi_menit_r1'] ?> menit</b>
            <br>Tugas akan berakhir pada
          <?php endif; ?>
          <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($datapenugasan['batas_r1']))) ?> pukul <?= date("H:i", strtotime($datapenugasan['batas_r1'])) ?> WIB</b>
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
  <script type="text/javascript">
    $(document).ready(function() {
      $('#mulai_ujian').on('click', function(event) {
        var id_penugasan = $(this).attr("data-penugasan");
        var jenis_ujian = "r1";
        $.ajax({
          url: 'backend/function.php?action=mulai_ujian',
          type: 'post',
          data: {
            id_penugasan: id_penugasan,
            jenis_ujian: jenis_ujian
          },
          success: function(data) {
            location.reload();
          }
        });
      })
    })
  </script>
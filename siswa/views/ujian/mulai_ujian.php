  <div class="card">
    <div class="card-body p-0">
      <div class="card-px text-center py-20 my-10">
        <h2 class="fs-2x fw-bolder mb-10">Mulai Mengerjakan!</h2>
        <p class="text-gray-400 fs-4 fw-bold mb-10">Pastikan tugas sudah sesuai<br>
          <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3" data-kode="<?= $tugas['sub_tugas'] ?>">
            <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
            <span class="d-flex flex-column align-items-start ms-2">
              <span class="fs-3 fw-bolder"><?= $tugas['jenis_tugas'] . ": " . $tugas['judul']  ?></span>
            </span>
          </a>
          <?php if ($tugas['durasi_tugas'] == 0) : ?>
            <br>Kerjakan sebelum
          <?php else : ?>
            <br>Batas waktu mengerjakan adalah
            <br> <b class="text-primary fs-1"><?= $tugas['durasi_tugas'] ?> menit</b>
            <br>Tugas akan berakhir pada
          <?php endif; ?>
          <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($tugas['batas_tugas']))) ?> pukul <?= date("H:i", strtotime($tugas['batas_tugas'])) ?> WIB</b>
        </p>
        <a href="javascript:;" class="btn btn-primary" id="mulai_ujian" data-penugasan="<?= $id_tugas_penugasan ?>">Mulai</a>
      </div>
      <div class="text-center px-4">
        <img class="mw-100 mh-300px" alt="" src="assets/media/illustrations/sigma-1/2.png" />
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#mulai_ujian').on('click', function(event) {
        Swal.fire({
          html: `Apakah anda akan <strong>mulai mengerjakan</strong>`,
          icon: "info",
          buttonsStyling: false,
          showCancelButton: true,
          confirmButtonText: "Mulai",
          cancelButtonText: 'Tutup',
          customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-danger'
          }
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            var id_tugas_penugasan = $(this).attr("data-penugasan");
            $.ajax({
              url: 'backend/function.php?action=mulai_ujian',
              type: 'post',
              data: {
                id_tugas_penugasan: id_tugas_penugasan,
              },
              success: function(data) {
                location.reload();
              }
            });
          } else if (result.isDenied) {
            Swal.close()
          }
        });
      })
    })
  </script>
<div class="card">
  <!--begin::Card body-->
  <div class="card-body p-0">
    <!--begin::Wrapper-->
    <div class="card-px my-10">
      <?php
      $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
      if ($getsoal->num_rows == 0) : ?>
        <!--begin::Notice-->
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
          <!--begin::Icon-->
          <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
          <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
              <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black" />
              <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black" />
            </svg>
          </span>
          <!--end::Svg Icon-->
          <!--end::Icon-->
          <!--begin::Wrapper-->
          <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-bold">
              <h4 class="text-gray-900 fw-bolder">Soal tidak ditemukan!</h4>
            </div>
          </div>
          <!--end::Content-->
        </div>
        <!--end::Notice-->
      <?php else : ?>
        <?php $no = 1;
        while ($soal = mysqli_fetch_assoc($getsoal)) : ?>
          <div class="d-flex my-10">
            <!--begin::Arrow-->
            <div class="me-3">
              <div class="btn btn-light py-2 px-5 fw-bold">
                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                <?= $no ?>
                <!--end::Svg Icon-->
              </div>
            </div>
            <!--end::Arrow-->
            <!--begin::Summary-->
            <div class="me-3 mt-2">
              <div class="d-flex align-items-center fw-bold mb-4"><?= $soal['pertanyaan'] ?></div>
              <?php
              $id_soal = $soal['id'];
              $getjawaban = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
              if ($getjawaban->num_rows !== 0) : ?>
                <?php while ($jawaban = mysqli_fetch_assoc($getjawaban)) : ?>
                  <div class="form-check form-check-custom form-check-solid p-2">
                    <input class="form-check-input" type="radio" value="<?= $jawaban['jawaban'] ?>" name="jawaban_<?= $id_soal ?>">
                    <label class="form-check-label" for="flexRadioDefault"><?= $jawaban['jawaban'] ?></label>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
            <!--end::Summary-->
          </div>
        <?php $no++;
        endwhile; ?>
      <?php endif; ?>
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Card body-->
</div>

<!--begin::Exolore drawer toggle-->
<button id="timer" class="btn btn-sm bg-body btn-color-gray-700 btn-active-primary shadow-sm position-fixed px-5 fw-bolder zindex-2 top-50 mt-10 end-0" title="Explore Metronic" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover">
  <span class="fs-6">Sisa Waktu</span><br>
  <span class="fs-1" id="waktu"></span>
</button>
<!--end::Exolore drawer toggle-->
<script>
  function waktu() {
    var sisa_menit = 120;
    var countdown = sisa_menit * 60 * 1000;
    var timerId = setInterval(function() {
      countdown -= 1000;
      var min = Math.floor(countdown / (60 * 1000));
      //var sec = Math.floor(countdown - (min * 60 * 1000));  // wrong
      var sec = Math.floor((countdown - (min * 60 * 1000)) / 1000); //correct
      var menit = (min < 10) ? "0" + min : min;
      var detik = (sec < 10) ? "0" + sec : sec;
      if (countdown <= 600000 && countdown >= 1000) {
        $("#timer").removeClass("bg-body");
        $("#timer").addClass("bg-danger");
        $("#timer").addClass("text-white");
        $("#waktu").html(menit + " : " + detik);
      } else if (countdown <= 0) {
        alert("30 min!");
        clearInterval(timerId);
        //doSomething();
      } else {
        var minute_count = min.length;
        if (minute_count == 1) {
          var menit = "0" + min;
        } else {
          var menit = min;
        }
        $("#waktu").html(menit + " : " + detik);
      }

    }, 1000); //1000ms. = 1sec.
  }

  $(document).ready(function() {
    waktu();
  });
</script>
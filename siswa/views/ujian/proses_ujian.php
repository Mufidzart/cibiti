<div class="card">
  <!--begin::Card body-->
  <div class="card-body p-0">
    <!--begin::Wrapper-->
    <div class="card-px my-10">
      <div class="col-xl-6 mb-15 mb-xl-0 pe-5">
        <h4 class="mb-0"><?= $datapenugasan['judul'] ?></h4>
        <p class="fs-6 fw-bold text-gray-600 py-4 m-0">
          <?= $datapenugasan['deskripsi'] ?>
        </p>
      </div>
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
                    <input class="form-check-input radio_jawaban" type="radio" value="<?= $jawaban['jawaban'] ?>" name="jawaban_<?= $id_soal ?>" data-id-penugasan="<?= $idpenugasan ?>" data-kode="<?= $kode_tugas ?>" data-id-soal="<?= $id_soal ?>" data-id-kunci="<?= $jawaban['id'] ?>">
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
<button id="timer" class="btn btn-sm bg-success btn-color-gray-700 btn-active-primary shadow-sm position-fixed px-5 fw-bolder zindex-2 mt-10 end-0 text-white" title="Jawaban tersimpan otomatis" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" style="top: 20%;">
  <span class="fs-6">Sisa Waktu</span><br>
  <span class="fs-1" id="waktu"></span>
</button>
<!--end::Exolore drawer toggle-->
<?php
$jam_mulai = $dataprosesujian['mulai_ujian'];
$durasi = 46;
$jam_berakhir = (new DateTime($jam_mulai))->modify('+' . $durasi . " minutes");
?>
<script>
  function timer() {
    // // Set the date we're counting down to
    var countDownDate = new Date("<?= $jam_berakhir->format("D M d Y H:i:s O") ?>").getTime();
    // Update the count down every 1 second

    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the element with id="timer"
      hours = "" + hours;
      minutes = "" + minutes;
      seconds = "" + seconds;
      var timerText = '';
      if (hours.length == 1) {
        timerText += "0" + hours + ":";
      } else {
        timerText += hours + ":";
      }
      if (minutes.length == 1) {
        timerText += "0" + minutes + ":";
      } else {
        timerText += minutes + ":";
      }
      if (seconds.length == 1) {
        timerText += "0" + seconds;
      } else {
        timerText += seconds;
      }
      document.getElementById("waktu").innerHTML = timerText;

      // If the count down is finished, write some text
      if (distance <= 0) {
        clearInterval(x);
        document.getElementById("waktu").innerHTML = "00:00:00";
      }
      if (distance <= 600000 && distance >= 1000) {
        $("#timer").removeClass("bg-body");
        $("#timer").addClass("bg-danger");
      } else if (distance <= 0) {
        alert("30 min!");
        clearInterval(x);
        //doSomething();
      }
    }, 1000);
  }
  $(document).ready(function() {
    timer();

    $('.radio_jawaban').on('click', function() {
      var jawaban = $(this).val();
      var id_penugasan = $(this).attr('data-id-penugasan');
      var kode_tugas = $(this).attr('data-kode');
      var id_soal = $(this).attr('data-id-soal');
      var id_kunci = $(this).attr('data-id-kunci');
      $.ajax({
        url: 'backend/function.php?action=push_jawaban',
        type: 'post',
        data: {
          jawaban: jawaban,
          id_penugasan: id_penugasan,
          kode_tugas: kode_tugas,
          id_soal: id_soal,
          id_kunci: id_kunci
        },
        success: function(data) {}
      });
    })
  });
</script>
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
              $getkunci = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
              if ($getkunci->num_rows !== 0) : ?>
                <?php while ($kunci = mysqli_fetch_assoc($getkunci)) :
                  $getjawaban = mysqli_query($conn, "SELECT * FROM arf_jawaban_siswa WHERE id_siswa='$nis_siswa' AND id_penugasan=$idpenugasan AND kode_tugas='$kode_tugas' AND id_soal=$id_soal AND tgl_hapus IS NULL");
                  if ($kunci['kunci'] == 1) {
                    // var_dump($kunci['jawaban']);
                  }
                  if ($getjawaban->num_rows !== 0) {
                    $datajawaban = mysqli_fetch_assoc($getjawaban);
                    if ($datajawaban['id_jawaban'] == $kunci['id']) {
                      if ($kunci['kunci'] == 1) {
                        $selected = "checked";
                      } else {
                        $selected = "checked";
                      }
                    } else {
                      $selected = "";
                    }
                  } else {
                    $selected = "";
                  } ?>
                  <div class="form-check form-check-custom form-check-solid p-2">
                    <input class="form-check-input radio_jawaban" type="radio" value="<?= $kunci['jawaban'] ?>" name="jawaban_<?= $id_soal ?>" data-id-penugasan="<?= $idpenugasan ?>" data-kode="<?= $kode_tugas ?>" data-id-soal="<?= $id_soal ?>" data-id-kunci="<?= $kunci['id'] ?>" <?= $selected ?>>
                    <label class="form-check-label text-dark opacity-100" for="flexRadioDefault"><?= $kunci['jawaban'] ?></label>
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
    <!--begin::Wrapper-->
    <div id="info-ujian">
      <div class="rounded border p-10 pb-0 d-flex flex-column flex-center">
        <div class="alert alert-dismissible bg-light-primary d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
          <!--end::Close-->
          <!--begin::Icon-->
          <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
          <span class="svg-icon svg-icon-5tx svg-icon-primary mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"></rect>
              <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black"></rect>
              <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black"></rect>
            </svg>
          </span>
          <!--end::Svg Icon-->
          <!--end::Icon-->
          <!--begin::Content-->
          <div class="text-center text-dark">
            <h1 class="fw-bolder mb-5">Sudah selesai mengerjakan?</h1>
            <div class="separator separator-dashed border-primary opacity-25 mb-5"></div>
            <div class="mb-9">Pastikan anda telah mengisi semua jawaban sebelum menyelesaikan tugas ini
              <br>Setelah anda klik tombol <strong class="text-primary">Submit</strong>
              <br>Nilai akan tampil
              <br><strong class="text-warning">Anda tidak dapat merubah jawaban Anda</strong>.
            </div>
            <!--begin::Buttons-->
            <div class="d-flex flex-center flex-wrap">
              <a href="javascript:;" data-kt-scrolltop="true" class="btn btn-outline btn-outline-primary btn-active-primary m-2">Cek Jawaban</a>
              <button class="btn btn-primary m-2" id="selesai">Submit</button>
            </div>
            <!--end::Buttons-->
          </div>
          <!--end::Content-->
        </div>
      </div>
    </div>
  </div>
  <!--end::Wrapper-->
  <!--end::Card body-->
</div>

<!--begin::Exolore drawer toggle-->
<button id="timer" class="btn btn-sm bg-success btn-color-gray-700 btn-active-primary shadow-sm position-fixed px-5 fw-bolder zindex-2 mt-10 end-0 text-white" title="Jawaban tersimpan otomatis" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" style="top: 20%;">
  <span class="fs-6">Sisa Waktu</span><br>
  <span class="fs-1" id="waktu"></span>
</button>
<!--end::Exolore drawer toggle-->

<!--begin::Modal -->
<div class="modal fade" id="modal-nilai" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <!--begin::Modal content-->
    <div class="modal-content">
      <!--begin::Form-->
      <form class="form" action="#" id="kt_modal_add_event_form">
        <!--begin::Modal header-->
        <div class="modal-header">
          <!--begin::Modal title-->
          <h2 class="fw-bolder" data-kt-calendar="title"></h2>
          <!--end::Modal title-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-10 px-lg-17" id="show_nilai">
        </div>
        <!--end::Modal body-->
        <!--begin::Modal footer-->
        <div class="modal-footer flex-center">
          <!--begin::Button-->
          <button type="button" id="lihat-jawaban" class="btn btn-primary" data-kt-scrolltop="true" data-bs-dismiss="modal">
            <span class="indicator-label">Lihat Jawaban</span>
          </button>
          <!--end::Button-->
        </div>
        <!--end::Modal footer-->
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>
<!--end::Modal -->
<script>
  function timeout() {
    var id_penugasan = "<?= $idpenugasan ?>";
    var id_proses = "<?= $dataprosesujian['id'] ?>";
    var kode_tugas = "<?= $kode_tugas ?>";
    var jenis_ujian = "r2";
    $.ajax({
      url: 'backend/function.php?action=get_data&get=nilai_ujian',
      type: 'post',
      data: {
        jenis_ujian: jenis_ujian,
        id_penugasan: id_penugasan,
        id_proses: id_proses,
        kode_tugas: kode_tugas
      },
      success: function(data) {
        $('#show_nilai').html(data);
        $('#modal-nilai').modal('show');
        $('#spinner').css("display", "block");
        setTimeout(function() {
          $('#spinner').css("display", "none");
          $('#penilaian').css("display", "block");
        }, 3000);
      }
    });
  }

  function timer() {
    // Set the date we're counting down to
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
        clearInterval(x);
        $("input[type=radio]").attr('disabled', true);
        timeout();
        $("#info-ujian").html("");
        $("#judul_selesai").html("Waktu telah selesai");
        //doSomething();
      }
    }, 1000);
  }
  $(document).ready(function() {
    timer();
    $('.radio_jawaban').on('click', function() {
      var jenis_ujian = "r2";
      var jawaban = $(this).val();
      var id_penugasan = $(this).attr('data-id-penugasan');
      var kode_tugas = $(this).attr('data-kode');
      var id_soal = $(this).attr('data-id-soal');
      var id_kunci = $(this).attr('data-id-kunci');
      $.ajax({
        url: 'backend/function.php?action=push_jawaban',
        type: 'post',
        data: {
          jenis_ujian: jenis_ujian,
          jawaban: jawaban,
          id_penugasan: id_penugasan,
          kode_tugas: kode_tugas,
          id_soal: id_soal,
          id_kunci: id_kunci
        },
        success: function(data) {}
      });
    });

    $('#modal-nilai').modal({
      backdrop: 'static',
      keyboard: false
    })
    $('#lihat-jawaban').on('click', function() {
      location.reload(true);
    });

    $('#selesai').on('click', function() {
      Swal.fire({
        html: `Apakah Anda telah menyelesaikan tugas ini?`,
        icon: "question",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Selesai",
        cancelButtonText: 'Batal',
        customClass: {
          confirmButton: "btn btn-primary",
          cancelButton: 'btn btn-danger'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          timeout();
        }
      });
    });
  });
</script>
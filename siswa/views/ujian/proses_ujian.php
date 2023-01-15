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
      <?php $no = 1;
      $id_soal = json_decode($dataprosesujian['id_soal']);
      $split_soal = sizeof($id_soal) / 2;
      $split_soal_explode = explode(".", $split_soal);
      if (isset($split_soal_explode[1])) {
        $jumlah_tab = $split_soal_explode[0] + 1;
      } else {
        $jumlah_tab = $split_soal_explode[0];
      }
      $array_terpecah = array_split($id_soal, $jumlah_tab);
      $no_tab = 1;
      $no = 1;
      ?>
      <form class="form" id="form-jawaban">
        <input type="hidden" name="id_penugasan" value="<?= $idpenugasan ?>">
        <input type="hidden" name="id_prosesujian" value="<?= $dataprosesujian['id'] ?>">
        <div class="stepper stepper-pills stepper-column">
          <div class="stepper-nav ps-lg-10">
            <?php foreach ($array_terpecah as $item) : ?>
              <?php if ($no_tab == 1) {
                $display = "block";
              } else {
                $display = "none";
              } ?>
              <div id="soal_<?= $no_tab ?>" style="display: <?= $display ?>;">
                <?php foreach ($item as $key => $value) :
                  $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE id='$value' AND tgl_hapus IS NULL");
                  $soal = mysqli_fetch_assoc($getsoal); ?>
                  <div class="d-flex my-10">
                    <!--begin::Arrow-->
                    <div class="me-3">
                      <div class="stepper-item">
                        <div class="stepper-icon w-40px h-40px">
                          <i class="stepper-check fas fa-check"></i>
                          <span class="stepper-number"><?= $no ?></span>
                        </div>
                      </div>
                    </div>
                    <!--end::Arrow-->
                    <!--begin::Summary-->
                    <div class="me-3 mt-2">
                      <div class="d-flex align-items-center fw-bold mb-4"><?= $soal['pertanyaan'] ?></div>
                      <?php
                      $id_soal = $soal['id'];
                      $getkunci = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL ORDER BY RAND()");
                      if ($getkunci->num_rows !== 0) : ?>
                        <?php while ($kunci = mysqli_fetch_assoc($getkunci)) :
                          $getjawaban = mysqli_query($conn, "SELECT * FROM arf_jawaban_siswa WHERE id_siswa='$nis_siswa' AND id_penugasan=$idpenugasan AND kode_tugas='$tugas_awal' AND id_soal=$id_soal AND tgl_hapus IS NULL");
                          if ($kunci['kunci'] == 1) {
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
                            <input class="form-check-input radio_jawaban" type="radio" value="<?= $kunci['id'] ?>" name="jawaban_<?= $id_soal ?>" <?= $selected ?>>
                            <label class="form-check-label text-dark opacity-100" for="flexRadioDefault"><?= $kunci['jawaban'] ?></label>
                          </div>
                        <?php endwhile; ?>
                      <?php endif; ?>
                    </div>
                    <!--end::Summary-->
                  </div>
                <?php $no++;
                endforeach; ?>
              </div>
              <div id="next_<?= $no_tab ?>" style="display: <?= $display ?>;">
                <!--begin::Actions-->
                <div class="d-flex justify-content-end">
                  <!--begin::Wrapper-->
                  <button type="button" class="btn btn-primary btn_next" data-no="<?= $no_tab ?>">
                    <span class="indicator-label label-next-<?= $no_tab ?>">Selanjutnya
                      <span class="svg-icon svg-icon-3 ms-1 me-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                          <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                        </svg>
                      </span>
                    </span>
                    <span class="indicator-progress progress-next-<?= $no_tab ?>">Mohon tunggu...
                      <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                  </button>
                  <!--end::Wrapper-->
                </div>
                <!--end::Actions-->
              </div>
            <?php $no_tab++;
            endforeach; ?>
          </div>
        </div>
      </form>
    </div>
    <!--begin::Wrapper-->
    <div id="info-ujian" style="display: none;">
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
  function form_post() {
    var formdata = $('#form-jawaban').serialize();
    $.ajax({
      url: 'backend/function.php?action=simpan_data_jawaban',
      type: 'post',
      data: formdata,
      dataType: 'json',
      success: function(data) {}
    });
  }

  function timeout() {
    var id_penugasan = "<?= $idpenugasan ?>";
    var id_proses = "<?= $dataprosesujian['id'] ?>";
    var kode_tugas = "<?= $tugas_awal ?>";
    $.ajax({
      url: 'backend/function.php?action=get_data&get=nilai_ujian_awal',
      type: 'post',
      data: {
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
        form_post();
        $("#info-ujian").html("");
        $("#judul_selesai").html("Waktu telah selesai");
        //doSomething();
      }
    }, 1000);
  }


  $(document).ready(function() {
    timer();
    $('.btn_next').on('click', function() {
      var max_tab = parseInt("<?= $jumlah_tab ?>");
      var nomor = $(this).attr("data-no");
      let new_nomor = parseInt(nomor) + 1;
      $('.label-next-' + nomor).css("display", "none");
      $('.progress-next-' + nomor).css("display", "block");
      setTimeout(function() {
        form_post();
        $('#next_' + nomor).css("display", "none");
        $('#soal_' + new_nomor).css("display", "block");
        if (new_nomor < max_tab) {
          $('#next_' + new_nomor).css("display", "block");
        }
        if (new_nomor >= max_tab) {
          $('#info-ujian').css("display", "block");
        }
        $('.label-next-' + nomor).css("display", "block");
        $('.progress-next-' + nomor).css("display", "none");
      }, 500);
    });

    $('#modal-nilai').modal({
      backdrop: 'static',
      keyboard: false
    });

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
          form_post();
          timeout();
        }
      });
    });
  });
</script>
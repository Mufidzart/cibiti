<div class="card">
  <!--begin::Card body-->
  <div class="card-body p-0">
    <!--begin::Wrapper-->
    <div class="card-px my-10">
      <div class="col-xl-6 mb-15 mb-xl-0 pe-5">
        <h4 class="mb-0"><?= $tugas['judul'] ?></h4>
        <p class="fs-6 fw-bold text-gray-600 py-4 m-0">
          <?= $tugas['deskripsi'] ?>
        </p>
      </div>
      <div class="stepper stepper-pills stepper-column">
        <div class="stepper-nav ps-lg-10">
          <?php
          $no = 1;
          $id_soal = json_decode($dataprosesujian['id_soal']);
          foreach ($id_soal as $value) :
            $getsoal = mysqli_query($conn, "SELECT * FROM soal_tugas_penugasan WHERE id='$value' AND tgl_hapus IS NULL");
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
                $get_jawaban_soal = mysqli_query($conn, "SELECT * FROM jawaban_soal_tugas_penugasan WHERE id_soal='$id_soal' AND tgl_hapus IS NULL ORDER BY RAND()");
                if ($get_jawaban_soal->num_rows !== 0) : ?>
                  <?php while ($kunci = mysqli_fetch_assoc($get_jawaban_soal)) :
                    $getjawabansiswa = mysqli_query($conn, "SELECT * FROM jawaban_siswa WHERE id_siswa='$nis_siswa' AND id_soal=$id_soal AND tgl_hapus IS NULL");
                    if ($kunci['kunci'] == 1) {
                    }
                    $background = "bg-secondary";
                    if ($getjawabansiswa->num_rows !== 0) {
                      $datajawaban = mysqli_fetch_assoc($getjawabansiswa);
                      if ($datajawaban['id_jawaban'] == $kunci['id']) {
                        if ($kunci['kunci'] == 1) {
                          $selected = "checked";
                          $background = "bg-success";
                        } else {
                          $selected = "checked";
                          $background = "bg-danger";
                        }
                      } else {
                        $selected = "";
                      }
                    } else {
                      $selected = "";
                    }  ?>
                    <div class="form-check form-check-custom form-check-solid p-2">
                      <input class="form-check-input radio_jawaban <?= $background ?>" type="radio" value="<?= $kunci['id'] ?>" name="jawaban_<?= $id_soal ?>" <?= $selected ?> disabled>
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
      </div>
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
            <h1 class="fw-bolder mb-5">Anda telah menyelesaikan <?= $tugas['judul'] ?></h1>
            <div class="separator separator-dashed border-primary opacity-25 mb-5"></div>
            <div class="mb-9">Anda mendapatkan nilai <br>
              <?php if (!empty($dataprosesujian['nilai'])) : ?>
                <br> <strong class="text-primary fs-1"><?= $dataprosesujian['nilai'] ?></strong>
              <?php endif; ?>
            </div>
            <!--begin::Buttons-->
            <div class="d-flex flex-center flex-wrap">
              <button class="btn btn-outline btn-outline-primary btn-active-primary m-2" data-kt-scrolltop="true">Cek Jawaban</button>
              <button class="btn btn-primary m-2" id="lihat-nilai" data-bs-toggle="modal" data-bs-target="#modal-nilai">Lihat Detail Nilai</button>
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
  <span class="fs-1" id="waktu">00:00:00</span>
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
          <div class="card-px text-center">
            <!--begin::Title-->
            <h2 class="fs-2x fw-bolder mb-10">Anda telah selesai mengerjakan!</h2>
            <!--end::Title-->
            <!--begin::Description-->
            <p class="text-gray-400 fs-4 fw-bold">Anda mendapat nilai<br>
              <?php if (!empty($dataprosesujian['nilai'])) : ?>
                <a href="javascript:;" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3">
                  <!-- <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span> -->
                  <span class="d-flex flex-column align-items-start ms-2">
                    <span class="fs-3 fw-bolder"> <b class="text-primary fs-1"><?= $dataprosesujian['nilai'] ?></b></span>
                  </span>
                </a>
                <br>Penugasan
                <br> <b class="text-primary"><?= $tugas['jenis_tugas'] . ": " . $tugas['judul']   ?></b>
                <br>Anda mengerjakan soal pada
                <br> <b class="text-primary"><?= tgl_indo(date("d-m-Y", strtotime($dataprosesujian['mulai_ujian']))) ?> pukul <?= date("H:i", strtotime($dataprosesujian['mulai_ujian'])) ?> WIB</b>
              <?php endif; ?>
            </p>
            <!--end::Description-->
          </div>
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
    $.ajax({
      url: 'backend/function.php?action=get_data&get=nilai_ujian',
      type: 'post',
      data: {
        id_penugasan: id_penugasan,
        id_proses: id_proses,
        kode_tugas: kode_tugas
      },
      success: function(data) {
        $('#show_nilai').html(data);
        $('#modal-nilai').modal('show');
        $('#spinner').css("display", "none");
        $('#penilaian').css("display", "block");
      }
    });
  }
</script>
<?php if (empty($dataprosesujian['nilai'])) : ?>
  <script>
    $(document).ready(function() {
      timeout();

      $('#modal-nilai').modal({
        backdrop: 'static',
        keyboard: false
      });

    });
  </script>
<?php else : ?>
  <script>
    $(document).ready(function() {
      $('#modal-nilai').modal('show');
    });
  </script>
<?php endif; ?>
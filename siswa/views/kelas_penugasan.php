<div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 500px;">
  <?php while ($penugasan = mysqli_fetch_assoc($getpenugasan)) : ?>
    <?php
    $tgl_input = new DateTime(date("Y-m-d", strtotime($penugasan['tgl_input'])));
    $today = new DateTime(date("Y-m-d"));
    $interval = $tgl_input->diff($today);
    $selisih = $interval->format('%a');
    if ($selisih != 0) {
      $tgl = tgl_indo(date("d-m-Y", strtotime($penugasan['tgl_input'])));
      $jam = date("H:i", strtotime($penugasan['tgl_input']));
      $tanggal = $tgl . ", " . $jam . "WIB";
    } else {
      $tanggal = humanize($penugasan['tgl_input']);
    }
    ?>
    <!--begin::Message(in)-->
    <div class="d-flex justify-content-start mb-10">
      <!--begin::Wrapper-->
      <div class="d-flex flex-column align-items-start">
        <!--begin::User-->
        <div class="d-flex align-items-center mb-2">
          <!--begin::Avatar-->
          <div class="symbol symbol-35px symbol-circle">
            <img alt="Pic" src="../../guru/assets/images/admin_avatar.png">
          </div>
          <!--end::Avatar-->
          <!--begin::Details-->
          <div class="ms-3">
            <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1"><?= $penugasan['nama_lengkap'] ?></a>
            <span class="text-muted fs-7 mb-1"><?= $tanggal ?></span>
          </div>
          <!--end::Details-->
        </div>
        <!--end::User-->
        <!--begin::Text-->
        <div class="p-5 rounded bg-light-info text-dark fw-bold text-start" data-kt-element="message-text">
          <h3><?= $penugasan['judul'] ?></h3>
          <p><?= $penugasan['deskripsi'] ?></p>
          <div class="row">
            <div class="col-md-12 my-2">
              <?php
              $id_penugasan = $penugasan['id'];
              $getnewnilai = $conn->query(
                "SELECT anp.*,ahp.judul,ahp.tugas_awal,ahp.r1,ahp.r2 FROM arf_nilai_penugasan anp
                JOIN arf_history_penugasan ahp ON ahp.id=anp.id_penugasan
                WHERE anp.id_penugasan=$id_penugasan AND anp.tgl_hapus IS NULL"
              );
              $datanilai = mysqli_fetch_assoc($getnewnilai);
              $status_ujian = "";
              $status_penilaian = "";
              $remidi_1 = false;
              $remidi_2 = false;
              if ($getnewnilai->num_rows !== 0) {
                $nilai_awal = $datanilai['nilai_awal'];
                $nilai_r1 = $datanilai['nilai_r1'];
                $nilai_r2 = $datanilai['nilai_r2'];
                if (isset($nilai_awal)) {
                  $status_ujian = "<span class='badge badge-light-success fs-7 my-3'>Sudah dikerjakan</span>";
                } else {
                  $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                }
                if ($nilai_awal < $penugasan['kkm_tugas_awal']) {
                  $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini, silahkan kerjakan Remidi 1.</span>";
                  $remidi_1 = true;
                } else {
                  $status_penilaian = "<span class='badge badge-light-success fs-7 my-3'>Anda lulus di tugas ini.</span>";
                  $remidi_1 = false;
                }
              } else {
                $batas = new DateTime(date("Y-m-d", strtotime($penugasan['batas_tugas_awal'])));
                if ($today > $batas) {
                  $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                  $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini, silahkan kerjakan Remidi 1.</span>";
                  $remidi_1 = true;
                }
              }

              $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$id_penugasan AND jenis_ujian='tugas_awal'");
              $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
              if ($getprosesujian->num_rows !== 0) {
                if (empty($dataprosesujian['selesai_ujian'])) {
                  $durasi = $penugasan['durasi_menit_tugas_awal'];
                  $mulai_ujian = $dataprosesujian['mulai_ujian'];
                  $jam_mulai = new DateTime($mulai_ujian);
                  $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
                  $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
                  if ($jam_sekarang <= $jam_berakhir) {
                    $status_ujian = "<span class='badge badge-light-info fs-7 my-3'>Sedang dikerjakan</span>";
                  }
                }
              }

              ?>
              <a href="ujian.php?tgs=<?= $penugasan['id'] ?>" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-success btn-active-light-success px-6" data-kode="<?= $penugasan['tugas_awal'] ?>">
                <span class=""><i class="bi bi-file-earmark-richtext-fill text-success fs-1"></i></span>
                <span class="d-flex flex-column align-items-start ms-2">
                  <span class="fs-3 fw-bolder">Tugas: <?= $penugasan['tugas_awal'] ?></span>
                  <span class="fs-7">klik untuk mengerjakan</span>
                </span>
              </a>
              <?= $status_ujian ?>
              <?= $status_penilaian ?>
            </div>
            <?php
            if ($remidi_1 == true) :
              if (!empty($penugasan['r1'])) {
            ?>
                <?php
                $status_ujian = "";
                $status_penilaian = "";
                $remidi_2 = false;
                if (isset($nilai_r1)) {
                  $status_ujian = "<span class='badge badge-light-info fs-7 my-3'>Sudah dikerjakan</span>";
                  if ($nilai_r1 < $penugasan['kkm_r1']) {
                    $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini, silahkan kerjakan Remidi 2.</span>";
                    $remidi_2 = true;
                  } else {
                    $status_penilaian = "<span class='badge badge-light-info fs-7 my-3'>Anda lulus di tugas ini.</span>";
                    $remidi_2 = false;
                  }
                } else {
                  $batas = new DateTime(date("Y-m-d", strtotime($penugasan['batas_r1'])));
                  if ($today > $batas) {
                    $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                    $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini, silahkan kerjakan Remidi 2.</span>";
                    $remidi_2 = true;
                  }
                }

                $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$id_penugasan AND jenis_ujian='r1'");
                $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
                if ($getprosesujian->num_rows !== 0) {
                  if (empty($dataprosesujian['selesai_ujian'])) {
                    $durasi = $penugasan['durasi_menit_r1'];
                    $mulai_ujian = $dataprosesujian['mulai_ujian'];
                    $jam_mulai = new DateTime($mulai_ujian);
                    $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
                    $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
                    if ($jam_sekarang <= $jam_berakhir) {
                      $status_ujian = "<span class='badge badge-light-info fs-7 my-3'>Sedang dikerjakan</span>";
                    }
                  }
                }

                ?>
                <div class="col-md-12 my-2">
                  <a href="remidi.php?tgs=<?= $penugasan['id'] ?>&act=r1" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-info btn-active-light-info px-6" data-kode="<?= $penugasan['r1'] ?>">
                    <span class=""><i class="bi bi-file-earmark-richtext-fill text-info fs-1"></i></span>
                    <span class="d-flex flex-column align-items-start ms-2">
                      <span class="fs-3 fw-bolder">Remidi 1: <?= $penugasan['r1'] ?></span>
                      <span class="fs-7">klik untuk mengerjakan</span>
                    </span>
                  </a>
                  <?= $status_ujian ?>
                  <?= $status_penilaian ?>
                </div>
            <?php
              }
            endif;
            ?>

            <?php
            if ($remidi_2 == true) :
              if (!empty($penugasan['r2'])) {
            ?>
                <?php
                $status_ujian = "";
                $status_penilaian = "";
                if (isset($nilai_r2)) {
                  $status_ujian = "<span class='badge badge-light-primary fs-7 my-3'>Sudah dikerjakan</span>";
                  if ($nilai_r2 < $penugasan['kkm_r2']) {
                    $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini.</span>";
                  } else {
                    $status_penilaian = "<span class='badge badge-light-primary fs-7 my-3'>Anda lulus di tugas ini.</span>";
                  }
                } else {
                  $batas = new DateTime(date("Y-m-d", strtotime($penugasan['batas_r2'])));
                  if ($today > $batas) {
                    $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                    $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini.</span>";
                  }
                }

                $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$id_penugasan AND jenis_ujian='r2'");
                $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
                if ($getprosesujian->num_rows !== 0) {
                  if (empty($dataprosesujian['selesai_ujian'])) {
                    $durasi = $penugasan['durasi_menit_r2'];
                    $mulai_ujian = $dataprosesujian['mulai_ujian'];
                    $jam_mulai = new DateTime($mulai_ujian);
                    $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
                    $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
                    if ($jam_sekarang <= $jam_berakhir) {
                      $status_ujian = "<span class='badge badge-light-primary fs-7 my-3'>Sedang dikerjakan</span>";
                    }
                  }
                }

                ?>
                <div class="col-md-12 my-2">
                  <a href="remidi.php?tgs=<?= $penugasan['id'] ?>&act=r2" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6" data-kode="<?= $penugasan['r2'] ?>">
                    <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
                    <span class="d-flex flex-column align-items-start ms-2">
                      <span class="fs-3 fw-bolder">Remidi 2: <?= $penugasan['r2'] ?></span>
                      <span class="fs-7">klik untuk mengerjakan</span>
                    </span>
                  </a>
                  <?= $status_ujian ?>
                  <?= $status_penilaian ?>
                </div>
            <?php
              }
            endif;
            ?>


          </div>
        </div>
        <!--end::Text-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Message(in)-->
  <?php endwhile; ?>
</div>
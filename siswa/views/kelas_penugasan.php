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
              $nis = $_SESSION['username'];
              $id_penugasan = $penugasan['id'];
              $id_mapel = $penugasan['id_mapel'];
              $getmapel = $conn->query("SELECT * FROM arf_mapel WHERE id=$id_mapel");
              $datamapel = mysqli_fetch_assoc($getmapel);
              $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_penugasan='$id_penugasan' AND tgl_hapus IS NULL");
              while ($tugas = mysqli_fetch_assoc($get_tugas_penugasan)) :
              ?>
                <?php
                $id_tugas_penugasan = $tugas['id'];
                $getprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id_siswa='$nis' AND id_tugas_penugasan=$id_tugas_penugasan");
                $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
                $status_ujian = "";
                $status_penilaian = "";
                if ($getprosesujian->num_rows !== 0) {
                  if (empty($dataprosesujian['selesai_ujian'])) {
                    $durasi = $tugas['durasi_tugas'];
                    $mulai_ujian = $dataprosesujian['mulai_ujian'];
                    $jam_mulai = new DateTime($mulai_ujian);
                    $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
                    $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
                    if ($jam_sekarang <= $jam_berakhir) {
                      $status_ujian = "<span class='badge badge-light-info fs-7 my-3'>Sedang dikerjakan</span>";
                    }
                  } else {
                    $nilai = $dataprosesujian['nilai'];
                    if (!empty($nilai)) {
                      $status_ujian = "<span class='badge badge-light-success fs-7 my-3'>Sudah dikerjakan</span>";
                    } else {
                      $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                    }
                    if ($nilai < $datamapel['kb_pengetahuan']) {
                      $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini.</span>";
                    } else {
                      $status_penilaian = "<span class='badge badge-light-success fs-7 my-3'>Anda lulus di tugas ini.</span>";
                    }
                  }
                } else {
                  $batas = new DateTime(date("Y-m-d H:i", strtotime($tugas['batas_tugas'])));
                  $now = new DateTime(date("Y-m-d H:i"));
                  if ($now > $batas) {
                    $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                    $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini.</span>";
                  }
                }
                $badge = $status_ujian . " " . $status_penilaian;
                ?>
                <a href="ujian.php?tgs=<?= $tugas['id'] ?>" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-success btn-active-light-success px-6" data-kode="<?= $tugas['sub_tugas'] ?>">
                  <span class=""><i class="bi bi-file-earmark-richtext-fill text-success fs-1"></i></span>
                  <span class="d-flex flex-column align-items-start ms-2">
                    <span class="fs-3 fw-bolder"><?= $tugas['sub_tugas'] ?></span>
                    <span class="fs-7">klik untuk mengerjakan</span>
                  </span>
                </a>
                <?= $badge ?>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
        <!--end::Text-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Message(in)-->
  <?php endwhile; ?>
</div>
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
        <?php
        $id_penugasan = $penugasan['id'];
        $getnewnilai = $conn->query(
          "SELECT anp.*,ahp.judul,ahp.tugas_awal FROM arf_nilai_penugasan anp
            JOIN arf_history_penugasan ahp ON ahp.id=anp.id_penugasan
            WHERE anp.id_penugasan=$id_penugasan AND anp.tgl_hapus IS NULL"
        );
        $badge = "";
        if ($getnewnilai->num_rows !== 0) {
          $color = "success";
          $badge = "<span class='badge badge-light-success fs-7 ms-2'>Sudah dikerjakan</span>";
        } else {
          $batas = new DateTime(date("Y-m-d", strtotime($penugasan['batas_tugas_awal'])));
          if ($today > $batas) {
            $color = "danger";
            $badge = "<span class='badge badge-light-danger fs-7 ms-2'>Terlewat</span>";
          } else {
            $color = "primary";
          }
        }

        $getprosesujian =  $conn->query("SELECT * FROM arf_proses_ujian WHERE id_penugasan=$id_penugasan");
        $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
        if (empty($dataprosesujian['selesai_ujian'])) {
          $durasi = $penugasan['durasi_menit_tugas_awal'];
          $mulai_ujian = $dataprosesujian['mulai_ujian'];
          $jam_mulai = new DateTime($mulai_ujian);
          $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
          $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
          if ($jam_sekarang <= $jam_berakhir) {
            $color = "info";
            $badge = "<span class='badge badge-light-info fs-7 ms-2'>Sedang dikerjakan</span>";
          }
        }

        ?>
        <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-900px text-start" data-kt-element="message-text">
          <h3><?= $penugasan['judul'] ?></h3>
          <p><?= $penugasan['deskripsi'] ?></p>
          <a href="ujian.php?tgs=<?= $penugasan['id'] ?>" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-<?= $color ?> btn-active-light-<?= $color ?> px-6" data-kode="<?= $penugasan['tugas_awal'] ?>">
            <span class=""><i class="bi bi-file-earmark-richtext-fill text-<?= $color ?> fs-1"></i></span>
            <span class="d-flex flex-column align-items-start ms-2">
              <span class="fs-3 fw-bolder"><?= $penugasan['tugas_awal'] ?></span>
              <span class="fs-7">klik untuk mengerjakan</span>
            </span>
          </a>
          <?= $badge ?>
        </div>
        <!--end::Text-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Message(in)-->
  <?php endwhile; ?>
</div>
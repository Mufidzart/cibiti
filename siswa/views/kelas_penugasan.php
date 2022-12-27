<div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 238px;">
  <?php while ($penugasan = mysqli_fetch_assoc($getpenugasan)) : ?>
    <?php
    $tanggal = humanize($penugasan['tgl_input']);
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
        <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">
          <h3><?= $penugasan['judul'] ?></h3>
          <p><?= $penugasan['deskripsi'] ?></p>
          <a href="#" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6" data-kode="<?= $penugasan['kode_tugas'] ?>">
            <span class=""><i class="bi bi-file-earmark-richtext-fill text-primary fs-1"></i></span>
            <span class="d-flex flex-column align-items-start ms-2">
              <span class="fs-3 fw-bolder"><?= $penugasan['kode_tugas'] ?></span>
              <span class="fs-7">klik untuk mengerjakan</span>
            </span>
          </a>
        </div>
        <!--end::Text-->
      </div>
      <!--end::Wrapper-->
    </div>
    <!--end::Message(in)-->
  <?php endwhile; ?>
</div>
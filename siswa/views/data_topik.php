<div class="card mb-5 mb-xl-10">
  <!--begin::Card header-->
  <div class="card-header cursor-pointer">
    <h3 class="card-title fw-bolder text-dark">Topik Pembelajaran</h3>
    <div class="card-toolbar">
      <!--begin::Menu-->
      <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
        <span class="svg-icon svg-icon-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
              <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
              <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
              <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
            </g>
          </svg>
        </span>
        <!--end::Svg Icon-->
      </button>
      <!--end::Menu-->
    </div>
  </div>
  <!--begin::Card header-->
  <!--begin::Card body-->
  <div class="card-body">
    <!--begin::Messages-->
    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 500px;">
      <?php while ($topik = mysqli_fetch_assoc($gettopik)) : ?>
        <?php
        $tgl_input = new DateTime(date("Y-m-d", strtotime($topik['tgl_input'])));
        $today = new DateTime(date("Y-m-d"));
        $interval = $tgl_input->diff($today);
        $selisih = $interval->format('%a');
        if ($selisih != 0) {
          $tgl = tgl_indo(date("d-m-Y", strtotime($topik['tgl_input'])));
          $jam = date("H:i", strtotime($topik['tgl_input']));
          $tanggal = $tgl . ", " . $jam . "WIB";
        } else {
          $tanggal = humanize($topik['tgl_input']);
        }
        ?>
        <!--begin::Message(in)-->
        <div class="d-flex justify-content-start mb-10">
          <!--begin::Wrapper-->
          <div class="d-flex flex-column align-items-start">
            <!--begin::Text-->
            <div class="p-5 rounded bg-light-info text-dark fw-bold text-start" data-kt-element="message-text">
              <h3><?= $topik['judul'] ?></h3>
              <p><?= $topik['deskripsi'] ?></p>
            </div>
            <!--end::Text-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Message(in)-->
      <?php endwhile; ?>
    </div>
    <!--end::Messages-->
  </div>
  <!--end::Card body-->
</div>
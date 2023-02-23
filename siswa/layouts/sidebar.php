<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
  <!--begin::Logo-->
  <div class="aside-logo flex-column-auto pt-10 pt-lg-20" id="kt_aside_logo">
    <a href="<?= $baseurl ?>">
      <img alt="Logo" src="../favicon.png" class="h-40px" />
    </a>
  </div>
  <!--end::Logo-->
  <!--begin::Nav-->
  <div class="aside-menu flex-column-fluid pt-0 pb-5 py-lg-5" id="kt_aside_menu">
    <!--begin::Aside menu-->
    <div id="kt_aside_menu_wrapper" class="w-100 hover-scroll-overlay-y scroll-ps d-flex" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="0">
      <div id="kt_aside_menu" class="menu menu-column menu-title-gray-600 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-icon-gray-400 menu-arrow-gray-400 fw-bold fs-6" data-kt-menu="true">
        <div class="menu-item py-3">
          <a class="menu-link active" href="<?= $baseurl ?>" title="Dashboard" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
            <span class="menu-icon">
              <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
              <span class="svg-icon svg-icon-2x">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                  <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                  <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                  <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                </svg>
              </span>
              <!--end::Svg Icon-->
            </span>
          </a>
        </div>
      </div>
    </div>
    <!--end::Aside menu-->
  </div>
  <!--end::Nav-->
</div>
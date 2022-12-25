<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$getsiswa = $conn->query("SELECT * FROM arf_siswa WHERE nis=$nis");
$datasiswa = mysqli_fetch_assoc($getsiswa);
?>
<!-- BEGIN CONTENT -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <!--begin::Container-->
  <div class="container-xxl" id="kt_content_container">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
      <!--begin::Col-->
      <div class="col-xl-4">
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
          <!--begin::Card header-->
          <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
              <h3 class="fw-bolder m-0">Profile Details</h3>
            </div>
            <!--end::Card title-->
          </div>
          <!--begin::Card header-->
          <!--begin::Card body-->
          <div class="card-body p-9">
            <!--begin::Row-->
            <div class="row mb-7">
              <div class="symbol symbol-100px symbol-lg-160px symbol-fixed text-center">
                <img src="assets/media/avatars/150-26.jpg" alt="image" />
              </div>
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row mb-7">
              <!--begin::Label-->
              <label class="col-lg-4 fw-bold text-muted">NAMA</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800"><?= $datasiswa['nama_siswa'] ?></span>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Input group-->
            <div class="row mb-7">
              <!--begin::Label-->
              <label class="col-lg-4 fw-bold text-muted">NIS</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= $datasiswa['nis'] ?></span>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-7">
              <!--begin::Label-->
              <label class="col-lg-4 fw-bold text-muted">NISN</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= ($datasiswa['nisn'] ? $datasiswa['nisn'] : "-") ?></span>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-7">
              <!--begin::Label-->
              <label class="col-lg-4 fw-bold text-muted">EMAIL</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= ($datasiswa['email_siswa'] ? $datasiswa['email_siswa'] : "-") ?></span>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-7">
              <!--begin::Label-->
              <label class="col-lg-4 fw-bold text-muted">TTL</label>
              <!--end::Label-->
              <?php
              $tanggal = explode("/", $datasiswa['tanggal_lahir']);
              $day = $tanggal[1];
              $month = $tanggal[0];
              $year = $tanggal[2];
              $tgl_lahir = tgl_indo($year . "-" . $month . "-" . $day);
              ?>
              <!--begin::Col-->
              <div class="col-lg-8 fv-row">
                <span class="fw-bold text-gray-800 fs-6"><?= ucwords(strtolower($datasiswa['tempat_lahir'])) . ", " . $tgl_lahir ?></span>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->
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
                  <h4 class="text-gray-900 fw-bolder">We need your attention!</h4>
                  <div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please
                    <a class="fw-bolder" href="../../demo9/dist/account/billing.html">Add Payment Method</a>.
                  </div>
                </div>
                <!--end::Content-->
              </div>
              <!--end::Wrapper-->
            </div>
            <!--end::Notice-->
          </div>
          <!--end::Card body-->
        </div>
        <!--end::details View-->
      </div>
      <!--end::Col-->
      <!--begin::Col-->
      <div class="col-xl-8 ps-xl-12">
        <!--begin::Engage widget 1-->
        <div class="card bgi-position-y-bottom bgi-position-x-end bgi-no-repeat bgi-size-cover min-h-250px bg-primary mb-5 mb-xl-8" style="background-position: 100% 50px;background-size: 500px auto;background-image:url('assets/media/misc/city.png')">
          <!--begin::Body-->
          <div class="card-body d-flex flex-column justify-content-center">
            <!--begin::Title-->
            <h3 class="text-white fs-2x fw-bolder line-height-lg mb-5">Brilliant App Ideas
              <br />for Startups
            </h3>
            <!--end::Title-->
            <!--begin::Action-->
            <div class="m-0">
              <a href='#' class="btn btn-success fw-bold px-6 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create an App</a>
            </div>
            <!--begin::Action-->
          </div>
          <!--end::Body-->
        </div>
        <!--end::Engage widget 1-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
          <!--begin::Col-->
          <div class="col-xl-6">
            <!--begin::Mixed Widget 5-->
            <div class="card card-xl-stretch mb-xl-8">
              <!--begin::Beader-->
              <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                  <span class="card-label fw-bolder fs-3 mb-1">Trends</span>
                  <span class="text-muted fw-bold fs-7">Latest trends</span>
                </h3>
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
                  <!--begin::Menu 3-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Create Invoice</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link flex-stack px-3">Create Payment
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i></a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Generate Bill</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                      <a href="#" class="menu-link px-3">
                        <span class="menu-title">Subscription</span>
                        <span class="menu-arrow"></span>
                      </a>
                      <!--begin::Menu sub-->
                      <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Plans</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Billing</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Statements</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <div class="menu-content px-3">
                            <!--begin::Switch-->
                            <label class="form-check form-switch form-check-custom form-check-solid">
                              <!--begin::Input-->
                              <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                              <!--end::Input-->
                              <!--end::Label-->
                              <span class="form-check-label text-muted fs-6">Recuring</span>
                              <!--end::Label-->
                            </label>
                            <!--end::Switch-->
                          </div>
                        </div>
                        <!--end::Menu item-->
                      </div>
                      <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Settings</a>
                    </div>
                    <!--end::Menu item-->
                  </div>
                  <!--end::Menu 3-->
                  <!--end::Menu-->
                </div>
              </div>
              <!--end::Header-->
              <!--begin::Body-->
              <div class="card-body d-flex flex-column">
                <!--begin::Chart-->
                <div class="mixed-widget-5-chart card-rounded-top" data-kt-chart-color="primary" style="height: 150px"></div>
                <!--end::Chart-->
                <!--begin::Items-->
                <div class="mt-5">
                  <!--begin::Item-->
                  <div class="d-flex flex-stack mb-5">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                      <!--begin::Symbol-->
                      <div class="symbol symbol-50px me-3">
                        <div class="symbol-label bg-light">
                          <img src="assets/media/svg/brand-logos/plurk.svg" class="h-50" alt="" />
                        </div>
                      </div>
                      <!--end::Symbol-->
                      <!--begin::Title-->
                      <div>
                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Top Authors</a>
                        <div class="fs-7 text-muted fw-bold mt-1">Ricky Hunt, Sandra Trepp</div>
                      </div>
                      <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label-->
                    <div class="badge badge-light fw-bold py-4 px-3">+82$</div>
                    <!--end::Label-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack mb-5">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                      <!--begin::Symbol-->
                      <div class="symbol symbol-50px me-3">
                        <div class="symbol-label bg-light">
                          <img src="assets/media/svg/brand-logos/figma-1.svg" class="h-50" alt="" />
                        </div>
                      </div>
                      <!--end::Symbol-->
                      <!--begin::Title-->
                      <div>
                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Top Sales</a>
                        <div class="fs-7 text-muted fw-bold mt-1">PitStop Emails</div>
                      </div>
                      <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label-->
                    <div class="badge badge-light fw-bold py-4 px-3">+82$</div>
                    <!--end::Label-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack">
                    <!--begin::Section-->
                    <div class="d-flex align-items-center me-2">
                      <!--begin::Symbol-->
                      <div class="symbol symbol-50px me-3">
                        <div class="symbol-label bg-light">
                          <img src="assets/media/svg/brand-logos/vimeo.svg" class="h-50" alt="" />
                        </div>
                      </div>
                      <!--end::Symbol-->
                      <!--begin::Title-->
                      <div class="py-1">
                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bolder">Top Engagement</a>
                        <div class="fs-7 text-muted fw-bold mt-1">KT.com</div>
                      </div>
                      <!--end::Title-->
                    </div>
                    <!--end::Section-->
                    <!--begin::Label-->
                    <div class="badge badge-light fw-bold py-4 px-3">+82$</div>
                    <!--end::Label-->
                  </div>
                  <!--end::Item-->
                </div>
                <!--end::Items-->
              </div>
              <!--end::Body-->
            </div>
            <!--end::Mixed Widget 5-->
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-xl-6">
            <!--begin::List Widget 3-->
            <div class="card card-xl-stretch mb-xl-8">
              <!--begin::Header-->
              <div class="card-header border-0">
                <h3 class="card-title fw-bolder text-dark">Todo</h3>
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
                  <!--begin::Menu 3-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Create Invoice</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link flex-stack px-3">Create Payment
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i></a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Generate Bill</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                      <a href="#" class="menu-link px-3">
                        <span class="menu-title">Subscription</span>
                        <span class="menu-arrow"></span>
                      </a>
                      <!--begin::Menu sub-->
                      <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Plans</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Billing</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Statements</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <div class="menu-content px-3">
                            <!--begin::Switch-->
                            <label class="form-check form-switch form-check-custom form-check-solid">
                              <!--begin::Input-->
                              <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                              <!--end::Input-->
                              <!--end::Label-->
                              <span class="form-check-label text-muted fs-6">Recuring</span>
                              <!--end::Label-->
                            </label>
                            <!--end::Switch-->
                          </div>
                        </div>
                        <!--end::Menu item-->
                      </div>
                      <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Settings</a>
                    </div>
                    <!--end::Menu item-->
                  </div>
                  <!--end::Menu 3-->
                  <!--end::Menu-->
                </div>
              </div>
              <!--end::Header-->
              <!--begin::Body-->
              <div class="card-body pt-2">
                <!--begin::Item-->
                <div class="d-flex align-items-center mb-8">
                  <!--begin::Bullet-->
                  <span class="bullet bullet-vertical h-40px bg-success"></span>
                  <!--end::Bullet-->
                  <!--begin::Checkbox-->
                  <div class="form-check form-check-custom form-check-solid mx-5">
                    <input class="form-check-input" type="checkbox" value="" />
                  </div>
                  <!--end::Checkbox-->
                  <!--begin::Description-->
                  <div class="flex-grow-1">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Create FireStone Logo</a>
                    <span class="text-muted fw-bold d-block">Due in 2 Days</span>
                  </div>
                  <!--end::Description-->
                  <span class="badge badge-light-success fs-8 fw-bolder">New</span>
                </div>
                <!--end:Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center mb-8">
                  <!--begin::Bullet-->
                  <span class="bullet bullet-vertical h-40px bg-primary"></span>
                  <!--end::Bullet-->
                  <!--begin::Checkbox-->
                  <div class="form-check form-check-custom form-check-solid mx-5">
                    <input class="form-check-input" type="checkbox" value="" />
                  </div>
                  <!--end::Checkbox-->
                  <!--begin::Description-->
                  <div class="flex-grow-1">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Stakeholder Meeting</a>
                    <span class="text-muted fw-bold d-block">Due in 3 Days</span>
                  </div>
                  <!--end::Description-->
                  <span class="badge badge-light-primary fs-8 fw-bolder">New</span>
                </div>
                <!--end:Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center mb-8">
                  <!--begin::Bullet-->
                  <span class="bullet bullet-vertical h-40px bg-warning"></span>
                  <!--end::Bullet-->
                  <!--begin::Checkbox-->
                  <div class="form-check form-check-custom form-check-solid mx-5">
                    <input class="form-check-input" type="checkbox" value="" />
                  </div>
                  <!--end::Checkbox-->
                  <!--begin::Description-->
                  <div class="flex-grow-1">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Scoping &amp; Estimations</a>
                    <span class="text-muted fw-bold d-block">Due in 5 Days</span>
                  </div>
                  <!--end::Description-->
                  <span class="badge badge-light-warning fs-8 fw-bolder">New</span>
                </div>
                <!--end:Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center mb-8">
                  <!--begin::Bullet-->
                  <span class="bullet bullet-vertical h-40px bg-primary"></span>
                  <!--end::Bullet-->
                  <!--begin::Checkbox-->
                  <div class="form-check form-check-custom form-check-solid mx-5">
                    <input class="form-check-input" type="checkbox" value="" />
                  </div>
                  <!--end::Checkbox-->
                  <!--begin::Description-->
                  <div class="flex-grow-1">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">KPI App Showcase</a>
                    <span class="text-muted fw-bold d-block">Due in 2 Days</span>
                  </div>
                  <!--end::Description-->
                  <span class="badge badge-light-primary fs-8 fw-bolder">New</span>
                </div>
                <!--end:Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center mb-8">
                  <!--begin::Bullet-->
                  <span class="bullet bullet-vertical h-40px bg-danger"></span>
                  <!--end::Bullet-->
                  <!--begin::Checkbox-->
                  <div class="form-check form-check-custom form-check-solid mx-5">
                    <input class="form-check-input" type="checkbox" value="" />
                  </div>
                  <!--end::Checkbox-->
                  <!--begin::Description-->
                  <div class="flex-grow-1">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Project Meeting</a>
                    <span class="text-muted fw-bold d-block">Due in 12 Days</span>
                  </div>
                  <!--end::Description-->
                  <span class="badge badge-light-danger fs-8 fw-bolder">New</span>
                </div>
                <!--end:Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center">
                  <!--begin::Bullet-->
                  <span class="bullet bullet-vertical h-40px bg-success"></span>
                  <!--end::Bullet-->
                  <!--begin::Checkbox-->
                  <div class="form-check form-check-custom form-check-solid mx-5">
                    <input class="form-check-input" type="checkbox" value="" />
                  </div>
                  <!--end::Checkbox-->
                  <!--begin::Description-->
                  <div class="flex-grow-1">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Customers Update</a>
                    <span class="text-muted fw-bold d-block">Due in 1 week</span>
                  </div>
                  <!--end::Description-->
                  <span class="badge badge-light-success fs-8 fw-bolder">New</span>
                </div>
                <!--end:Item-->
              </div>
              <!--end::Body-->
            </div>
            <!--end:List Widget 3-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Tables Widget 5-->
        <div class="card mb-xl-8">
          <!--begin::Header-->
          <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
              <span class="card-label fw-bolder fs-3 mb-1">Latest Products</span>
              <span class="text-muted mt-1 fw-bold fs-7">More than 400 new products</span>
            </h3>
            <div class="card-toolbar">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark active fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_1">Month</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_2">Week</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4" data-bs-toggle="tab" href="#kt_table_widget_5_tab_3">Day</a>
                </li>
              </ul>
            </div>
          </div>
          <!--end::Header-->
          <!--begin::Body-->
          <div class="card-body py-3">
            <div class="tab-content">
              <!--begin::Tap pane-->
              <div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
                <!--begin::Table container-->
                <div class="table-responsive">
                  <!--begin::Table-->
                  <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                      <tr class="border-0">
                        <th class="p-0 w-50px"></th>
                        <th class="p-0 min-w-150px"></th>
                        <th class="p-0 min-w-140px"></th>
                        <th class="p-0 min-w-110px"></th>
                        <th class="p-0 min-w-50px"></th>
                      </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/plurk.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Brad Simmons</a>
                          <span class="text-muted fw-bold d-block">Movie Creator</span>
                        </td>
                        <td class="text-end text-muted fw-bold">React, HTML</td>
                        <td class="text-end">
                          <span class="badge badge-light-success">Approved</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/telegram.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Popular Authors</a>
                          <span class="text-muted fw-bold d-block">Most Successful</span>
                        </td>
                        <td class="text-end text-muted fw-bold">Python, MySQL</td>
                        <td class="text-end">
                          <span class="badge badge-light-warning">In Progress</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/vimeo.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">New Users</a>
                          <span class="text-muted fw-bold d-block">Awesome Users</span>
                        </td>
                        <td class="text-end text-muted fw-bold">Laravel,Metronic</td>
                        <td class="text-end">
                          <span class="badge badge-light-primary">Success</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/bebo.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Active Customers</a>
                          <span class="text-muted fw-bold d-block">Movie Creator</span>
                        </td>
                        <td class="text-end text-muted fw-bold">AngularJS, C#</td>
                        <td class="text-end">
                          <span class="badge badge-light-danger">Rejected</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/kickstarter.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Bestseller Theme</a>
                          <span class="text-muted fw-bold d-block">Best Customers</span>
                        </td>
                        <td class="text-end text-muted fw-bold">ReactJS, Ruby</td>
                        <td class="text-end">
                          <span class="badge badge-light-warning">In Progress</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                    </tbody>
                    <!--end::Table body-->
                  </table>
                </div>
                <!--end::Table-->
              </div>
              <!--end::Tap pane-->
              <!--begin::Tap pane-->
              <div class="tab-pane fade" id="kt_table_widget_5_tab_2">
                <!--begin::Table container-->
                <div class="table-responsive">
                  <!--begin::Table-->
                  <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                      <tr class="border-0">
                        <th class="p-0 w-50px"></th>
                        <th class="p-0 min-w-150px"></th>
                        <th class="p-0 min-w-140px"></th>
                        <th class="p-0 min-w-110px"></th>
                        <th class="p-0 min-w-50px"></th>
                      </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/plurk.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Brad Simmons</a>
                          <span class="text-muted fw-bold d-block">Movie Creator</span>
                        </td>
                        <td class="text-end text-muted fw-bold">React, HTML</td>
                        <td class="text-end">
                          <span class="badge badge-light-success">Approved</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/telegram.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Popular Authors</a>
                          <span class="text-muted fw-bold d-block">Most Successful</span>
                        </td>
                        <td class="text-end text-muted fw-bold">Python, MySQL</td>
                        <td class="text-end">
                          <span class="badge badge-light-warning">In Progress</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/bebo.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Active Customers</a>
                          <span class="text-muted fw-bold d-block">Movie Creator</span>
                        </td>
                        <td class="text-end text-muted fw-bold">AngularJS, C#</td>
                        <td class="text-end">
                          <span class="badge badge-light-danger">Rejected</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                    </tbody>
                    <!--end::Table body-->
                  </table>
                </div>
                <!--end::Table-->
              </div>
              <!--end::Tap pane-->
              <!--begin::Tap pane-->
              <div class="tab-pane fade" id="kt_table_widget_5_tab_3">
                <!--begin::Table container-->
                <div class="table-responsive">
                  <!--begin::Table-->
                  <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                      <tr class="border-0">
                        <th class="p-0 w-50px"></th>
                        <th class="p-0 min-w-150px"></th>
                        <th class="p-0 min-w-140px"></th>
                        <th class="p-0 min-w-110px"></th>
                        <th class="p-0 min-w-50px"></th>
                      </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/kickstarter.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Bestseller Theme</a>
                          <span class="text-muted fw-bold d-block">Best Customers</span>
                        </td>
                        <td class="text-end text-muted fw-bold">ReactJS, Ruby</td>
                        <td class="text-end">
                          <span class="badge badge-light-warning">In Progress</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/bebo.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Active Customers</a>
                          <span class="text-muted fw-bold d-block">Movie Creator</span>
                        </td>
                        <td class="text-end text-muted fw-bold">AngularJS, C#</td>
                        <td class="text-end">
                          <span class="badge badge-light-danger">Rejected</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/vimeo.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">New Users</a>
                          <span class="text-muted fw-bold d-block">Awesome Users</span>
                        </td>
                        <td class="text-end text-muted fw-bold">Laravel,Metronic</td>
                        <td class="text-end">
                          <span class="badge badge-light-primary">Success</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="symbol symbol-45px me-2">
                            <span class="symbol-label">
                              <img src="assets/media/svg/brand-logos/telegram.svg" class="h-50 align-self-center" alt="" />
                            </span>
                          </div>
                        </td>
                        <td>
                          <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">Popular Authors</a>
                          <span class="text-muted fw-bold d-block">Most Successful</span>
                        </td>
                        <td class="text-end text-muted fw-bold">Python, MySQL</td>
                        <td class="text-end">
                          <span class="badge badge-light-warning">In Progress</span>
                        </td>
                        <td class="text-end">
                          <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-2">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                              </svg>
                            </span>
                            <!--end::Svg Icon-->
                          </a>
                        </td>
                      </tr>
                    </tbody>
                    <!--end::Table body-->
                  </table>
                </div>
                <!--end::Table-->
              </div>
              <!--end::Tap pane-->
            </div>
          </div>
          <!--end::Body-->
        </div>
        <!--end::Tables Widget 5-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
          <!--begin::Col-->
          <div class="col-xl-6">
            <!--begin::Mixed Widget 8-->
            <div class="card card-xl-stretch mb-xl-8">
              <!--begin::Body-->
              <div class="card-body">
                <!--begin::Heading-->
                <div class="d-flex flex-stack">
                  <!--begin:Info-->
                  <div class="d-flex align-items-center">
                    <!--begin:Image-->
                    <div class="symbol symbol-60px me-5">
                      <span class="symbol-label bg-danger-light">
                        <img src="assets/media/svg/brand-logos/plurk.svg" class="h-50 align-self-center" alt="" />
                      </span>
                    </div>
                    <!--end:Image-->
                    <!--begin:Title-->
                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                      <a href="#" class="text-dark fw-bolder text-hover-primary fs-5">Monthly Subscription</a>
                      <span class="text-muted fw-bold">Due: 27 Apr 2020</span>
                    </div>
                    <!--end:Title-->
                  </div>
                  <!--begin:Info-->
                  <!--begin:Menu-->
                  <div class="ms-1">
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
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Quick Actions</div>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu separator-->
                      <div class="separator mb-3 opacity-75"></div>
                      <!--end::Menu separator-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Ticket</a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Customer</a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <!--begin::Menu item-->
                        <a href="#" class="menu-link px-3">
                          <span class="menu-title">New Group</span>
                          <span class="menu-arrow"></span>
                        </a>
                        <!--end::Menu item-->
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                          <!--begin::Menu item-->
                          <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Admin Group</a>
                          </div>
                          <!--end::Menu item-->
                          <!--begin::Menu item-->
                          <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Staff Group</a>
                          </div>
                          <!--end::Menu item-->
                          <!--begin::Menu item-->
                          <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Member Group</a>
                          </div>
                          <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Contact</a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu separator-->
                      <div class="separator mt-3 opacity-75"></div>
                      <!--end::Menu separator-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                          <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                        </div>
                      </div>
                      <!--end::Menu item-->
                    </div>
                    <!--end::Menu 2-->
                  </div>
                  <!--end::Menu-->
                </div>
                <!--end::Heading-->
                <!--begin:Stats-->
                <div class="d-flex flex-column w-100 mt-12">
                  <span class="text-dark me-2 fw-bolder pb-3">Progress</span>
                  <div class="progress h-5px w-100">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <!--end:Stats-->
                <!--begin:Team-->
                <div class="d-flex flex-column mt-10">
                  <div class="text-dark me-2 fw-bolder pb-4">Team</div>
                  <div class="d-flex">
                    <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="Ana Stone">
                      <img src="assets/media/avatars/150-1.jpg" alt="" />
                    </a>
                    <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="Mark Larson">
                      <img src="assets/media/avatars/150-4.jpg" alt="" />
                    </a>
                    <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="Sam Harris">
                      <img src="assets/media/avatars/150-8.jpg" alt="" />
                    </a>
                    <a href="#" class="symbol symbol-35px" data-bs-toggle="tooltip" title="Alice Micto">
                      <img src="assets/media/avatars/150-9.jpg" alt="" />
                    </a>
                  </div>
                </div>
                <!--end:Team-->
              </div>
              <!--end::Body-->
            </div>
            <!--end::Mixed Widget 8-->
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-xl-6">
            <!--begin::Mixed Widget 8-->
            <div class="card card-xl-stretch mb-xl-8">
              <!--begin::Body-->
              <div class="card-body">
                <!--begin::Heading-->
                <div class="d-flex flex-stack">
                  <!--begin:Info-->
                  <div class="d-flex align-items-center">
                    <!--begin:Image-->
                    <div class="symbol symbol-60px me-5">
                      <span class="symbol-label bg-primary-light">
                        <img src="assets/media/svg/brand-logos/vimeo.svg" class="h-50 align-self-center" alt="" />
                      </span>
                    </div>
                    <!--end:Image-->
                    <!--begin:Title-->
                    <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 pr-3">
                      <a href="#" class="text-dark fw-bolder text-hover-primary fs-5">Monthly Subscription</a>
                      <span class="text-muted fw-bold">Due: 27 Apr 2020</span>
                    </div>
                    <!--end:Title-->
                  </div>
                  <!--begin:Info-->
                  <!--begin:Menu-->
                  <div class="ms-1">
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
                    <!--begin::Menu 2-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Quick Actions</div>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu separator-->
                      <div class="separator mb-3 opacity-75"></div>
                      <!--end::Menu separator-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Ticket</a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Customer</a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                        <!--begin::Menu item-->
                        <a href="#" class="menu-link px-3">
                          <span class="menu-title">New Group</span>
                          <span class="menu-arrow"></span>
                        </a>
                        <!--end::Menu item-->
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                          <!--begin::Menu item-->
                          <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Admin Group</a>
                          </div>
                          <!--end::Menu item-->
                          <!--begin::Menu item-->
                          <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Staff Group</a>
                          </div>
                          <!--end::Menu item-->
                          <!--begin::Menu item-->
                          <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Member Group</a>
                          </div>
                          <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">New Contact</a>
                      </div>
                      <!--end::Menu item-->
                      <!--begin::Menu separator-->
                      <div class="separator mt-3 opacity-75"></div>
                      <!--end::Menu separator-->
                      <!--begin::Menu item-->
                      <div class="menu-item px-3">
                        <div class="menu-content px-3 py-3">
                          <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                        </div>
                      </div>
                      <!--end::Menu item-->
                    </div>
                    <!--end::Menu 2-->
                  </div>
                  <!--end::Menu-->
                </div>
                <!--end::Heading-->
                <!--begin:Stats-->
                <div class="d-flex flex-column w-100 mt-12">
                  <span class="text-dark me-2 fw-bolder pb-3">Progress</span>
                  <div class="progress h-5px w-100">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <!--end:Stats-->
                <!--begin:Team-->
                <div class="d-flex flex-column mt-10">
                  <div class="text-dark me-2 fw-bolder pb-4">Team</div>
                  <div class="d-flex">
                    <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="Ana Stone">
                      <img src="assets/media/avatars/150-1.jpg" alt="" />
                    </a>
                    <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="Mark Larson">
                      <img src="assets/media/avatars/150-4.jpg" alt="" />
                    </a>
                    <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="Sam Harris">
                      <img src="assets/media/avatars/150-8.jpg" alt="" />
                    </a>
                    <a href="#" class="symbol symbol-35px" data-bs-toggle="tooltip" title="Alice Micto">
                      <img src="assets/media/avatars/150-9.jpg" alt="" />
                    </a>
                  </div>
                </div>
                <!--end:Team-->
              </div>
              <!--end::Body-->
            </div>
            <!--end::Mixed Widget 8-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Col-->
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>
<!-- END CONTENT -->
<?php
require('layouts/bodylayout.php');
?>
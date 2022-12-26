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
            <?php
            $dat = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $date = $dat->format('H');
            if ($date < 10)
              $selamat = "Selamat Pagi";
            else if ($date < 15)
              $selamat = "Selamat Siang";
            else if ($date < 19)
              $selamat = "Selamat Sore";
            else
              $selamat = "Selamat Malam";
            ?>
            <h3 class="text-white fs-2x fw-bolder line-height-lg mb-5"><?= $selamat ?>
              <br /><?= ucwords(strtolower($datasiswa['nama_siswa'])) ?>
            </h3>
            <!--end::Title-->
            <!--begin::Action-->
            <div class="m-0">
              <!-- <a href='#' class="btn btn-success fw-bold px-6 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create an App</a> -->
            </div>
            <!--begin::Action-->
          </div>
          <!--end::Body-->
        </div>
        <!--end::Engage widget 1-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
          <!--begin::Col-->
          <div class="col-xl-12">
            <!--begin::List Widget 3-->
            <div class="card card-xl-stretch mb-xl-8">
              <!--begin::Header-->
              <div class="card-header border-0">
                <h3 class="card-title fw-bolder text-dark">Tugas</h3>
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
                  <!--begin::Description-->
                  <div class="flex-grow-1 ms-3">
                    <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">Create FireStone Logo</a>
                    <span class="text-muted fw-bold d-block">Due in 2 Days</span>
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
      </div>
      <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
      <!--begin::Col-->
      <div class="col-xl-12 ps-xl-12">
        <!--begin::Engage widget 1-->
        <div class="card card-xl-stretch mb-xl-8">
          <!--begin::Header-->
          <div class="card-header border-0">
            <h3 class="card-title fw-bolder text-dark">Mata Pelajaran</h3>
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
            <div class="col-xl-4 ps-xl-12">
              <div class="card bg-primary">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column justify-content-center">
                  <!--begin::Title-->
                  <?php
                  $dat = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                  $date = $dat->format('H');
                  if ($date < 10)
                    $selamat = "Selamat Pagi";
                  else if ($date < 15)
                    $selamat = "Selamat Siang";
                  else if ($date < 19)
                    $selamat = "Selamat Sore";
                  else
                    $selamat = "Selamat Malam";
                  ?>
                  <h3 class="text-white fs-2x fw-bolder line-height-lg mb-5"><?= $selamat ?>
                    <br /><?= ucwords(strtolower($datasiswa['nama_siswa'])) ?>
                  </h3>
                  <!--end::Title-->
                  <!--begin::Action-->
                  <div class="m-0">
                    <!-- <a href='#' class="btn btn-success fw-bold px-6 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create an App</a> -->
                  </div>
                  <!--begin::Action-->
                </div>
                <!--end::Body-->
              </div>
            </div>
            <!--end:Item-->
          </div>
          <!--end::Body-->
        </div>
        <!--end::Engage widget 1-->
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
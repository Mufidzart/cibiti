<?php
require('backend/connection.php');
$page_title = "Learning Management System (LMS)";
require('layouts/headlayout.php');
$nis = $_SESSION['username'];
$getsiswa = $conn->query(
  "SELECT asw.*,ask.id_kelas_induk,ask.id_kelas
  FROM arf_siswa asw
  JOIN arf_siswa_kelashistory ask ON ask.nis=asw.nis
  WHERE asw.nis=$nis
  AND ask.id_thajaran=$id_thajaran
  ANd ask.id_semester=$semester"
);
$datasiswa = mysqli_fetch_assoc($getsiswa);
$kelas_siswa = $datasiswa['id_kelas_induk'];
$subkelas_siswa = $datasiswa['id_kelas'];
$getgurumapel = $conn->query(
  "SELECT agm.id_staf,agm.id_mapel,asf.nama_lengkap,am.nama_mapel
  FROM arf_guru_mapel agm
  JOIN arf_staf asf ON asf.nip=agm.id_staf
  JOIN arf_mapel am ON am.id=agm.id_mapel
  WHERE agm.id_kelas=$kelas_siswa
  AND agm.id_subkelas=$subkelas_siswa
  AND agm.id_thajaran=$id_thajaran"
);


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
  </div>
  <!--end::Container-->
  <!--begin::Container-->
  <div class="container-xxl" id="kt_content_container">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
      <!--begin::Col-->
      <div class="col-xl-12">
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
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
          <!--begin::Card body-->
          <div class="card-body">
            <div class="row">
              <?php
              $colorbg = ["bg-light-primary", "bg-secondary", "bg-light", "bg-light-success", "bg-light-warning", "bg-light-danger", "bg-light-dark"];
              $i = 0;
              while ($datamapel = mysqli_fetch_assoc($getgurumapel)) :
                if ($i == 7) {
                  $i = 0;
                } else {
                  $i = $i;
                }
                $no = substr($i, -1);
                $bg = $colorbg[$no];
              ?>
                <div class="col-xl-4 ps-xl-12 pb-2">
                  <a class="d-flex align-items-center rounded py-5 px-4 <?= $bg ?>" href="detail_mapel.php?kls=<?= $kelas_siswa ?>&skls=<?= $subkelas_siswa ?>&g=<?= $datamapel['id_staf'] ?>&mpl=<?= $datamapel['id_mapel'] ?>">
                    <!--begin::Icon-->
                    <div class="d-flex h-80px w-80px flex-shrink-0 flex-center">
                      <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                      <span class="svg-icon svg-icon-info position-absolute opacity-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70px" height="70px" viewBox="0 0 70 70" fill="none" class="w-80px h-80px">
                          <path d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z" fill="#000000"></path>
                        </svg>
                      </span>
                      <!--end::Svg Icon-->
                      <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                      <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path opacity="0.3" d="M22 19V17C22 16.4 21.6 16 21 16H8V3C8 2.4 7.6 2 7 2H5C4.4 2 4 2.4 4 3V19C4 19.6 4.4 20 5 20H21C21.6 20 22 19.6 22 19Z" fill="black"></path>
                          <path d="M20 5V21C20 21.6 19.6 22 19 22H17C16.4 22 16 21.6 16 21V8H8V4H19C19.6 4 20 4.4 20 5ZM3 8H4V4H3C2.4 4 2 4.4 2 5V7C2 7.6 2.4 8 3 8Z" fill="black"></path>
                        </svg>
                      </span>
                      <!--end::Svg Icon-->
                    </div>
                    <div class="text-gray-800 text-hover-primary fw-bolder fs-3 ms-3">
                      <?= $datamapel['nama_mapel'] ?>
                      <span class="text-muted fw-bold fs-6 d-block"><?= $datamapel['nama_lengkap'] ?></span>
                    </div>
                    <!--end::Icon-->
                  </a>
                </div>
              <?php
                $i++;
              endwhile; ?>
            </div>
          </div>
          <!--end::Card body-->
        </div>
        <!--end::details View-->
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
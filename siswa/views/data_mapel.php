<div class="row">
  <?php
  // $colorbg = ["bg-light-primary", "bg-secondary", "bg-light", "bg-light-success", "bg-light-warning", "bg-light-danger", "bg-light-dark"];
  $colorbg = ["bg-light-info"];
  $i = 0;
  while ($datamapel = mysqli_fetch_assoc($getgurumapel)) :
    if ($i == 1) {
      $i = 0;
    } else {
      $i = $i;
    }
    $no = substr($i, -1);
    $bg = $colorbg[$no];
  ?>
    <div class="col-xl-4 ps-xl-12 pb-2">
      <a class="d-flex align-items-center rounded py-5 px-4 <?= $bg ?>" href="detail_mapel.php?kls=<?= $id_kelas_induk ?>&skls=<?= $id_kelas ?>&g=<?= $datamapel['id_staf'] ?>&mpl=<?= $datamapel['id_mapel'] ?>">
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
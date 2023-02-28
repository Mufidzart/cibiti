<div class="card-px">
  <h2 class="fs-2x fw-bolder mb-10"><?= $data_materi['judul'] ?></h2>
  <p class="text-gray-400 fs-4 fw-bold"><?= $data_materi['deskripsi'] ?></p>
  <p class="text-center">
    <a href="backend/download.php?action=download-materi&id=<?= $data_materi['id'] ?>" target="_blank" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary px-6 my-3">
      <span class="d-flex flex-column align-items-start ms-2">
        <span class="fs-3 fw-bolder"> <b class="text-primary fs-1"><?= $data_materi['file'] ?></b></span>
      </span>
    </a>
  </p>
</div>
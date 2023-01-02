<?php if ($getpenugasan->num_rows == 0) : ?>
  <div class="row">
    <div class="col-md-12 text-center" style="opacity: 0.5;">
      <img src="assets/images/no-content.png" alt="No Content">
      <h3>Belum ada penugasan</h3>
    </div>
  </div>
  <?php else :
  while ($row = mysqli_fetch_assoc($getpenugasan)) :
    $pecahtglinput = explode(" ", $row['tgl_input']);
    $tgl_input = date("d-m-Y", strtotime($pecahtglinput[0]));
    $jam_input = date("H:i", strtotime($pecahtglinput[1]));
    $pecahtglselesai = explode(" ", $row['waktu_selesai']);
    $tgl_selesai = date("Y-m-d", strtotime($pecahtglselesai[0]));
    $jam_selesai = date("H:i", strtotime($pecahtglselesai[1]));
    $batas = new DateTime(date("Y-m-d", strtotime($row['waktu_selesai'])));
    $today = new DateTime(date("Y-m-d"));
    if ($today > $batas) {
      $color = "danger";
    } else {
      $color = "info";
    }
  ?>
    <div class="note note-<?= $color ?>">
      <div class="mt-comments">
        <div class="mt-comment">
          <div class="mt-comment-body">
            <div class="mt-comment-<?= $color ?>">
              <span class="mt-comment-author"><?= $row['judul'] ?></span>
              <span class="mt-comment-date"><?= $tgl_input . ", " . $jam_input ?> WIB</span>
            </div>
            <div class="mt-comment-text"> <?= $row['deskripsi'] ?> </div>
            <div class="alert alert-<?= $color ?>" style="margin-top:10px;">
              <strong>
                <i class="fa fa-calendar"></i> Batas Akhir <?= tgl_indo($tgl_selesai) . ", " . $jam_selesai ?> WIB
              </strong>
            </div>
            <div class="mt-comment-details">
              <span class="mt-comment-status mt-comment-status-pending">
                <div class="row">
                  <div class="col-md-12">
                    <a href="javascript:;" class="btn btn-circle default green-stripe lihat_tugas" id="lihat_tugas" data-kode="<?= $row['kode_tugas'] ?>"><?= $row['kode_tugas'] ?></a>
                    <span style="color:#327ad5;padding-top:7px;text-transform: none;">!klik untuk melihat</span>
                  </div>
                </div>
              </span>
              <ul class="mt-comment-actions">
                <li>
                  <a href="javascript:;" class="edit-penugasan" data-id="<?= $row['id'] ?>">Edit</a>
                </li>
                <li>
                  <a href="javascript:;" class="hapus-penugasan" data-id="<?= $row['id'] ?>">Hapus</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  endwhile;
endif; ?>
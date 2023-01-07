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
    $pecahtglselesai = explode(" ", $row['batas_tugas_awal']);
    $tgl_selesai = date("Y-m-d", strtotime($pecahtglselesai[0]));
    $jam_selesai = date("H:i", strtotime($pecahtglselesai[1]));
    $batas = new DateTime(date("Y-m-d", strtotime($row['batas_tugas_awal'])));
    $today = new DateTime(date("Y-m-d"));
    if ($today > $batas) {
      $color = "danger";
    } else {
      $color = "info";
    }
  ?>
    <div class="note note-info">
      <div class="mt-comments">
        <div class="mt-comment">
          <div class="mt-comment-body">
            <div class="mt-comment-info">
              <span class="mt-comment-author"><?= $row['judul'] ?></span>
              <span class="mt-comment-date"><?= $tgl_input . ", " . $jam_input ?> WIB</span>
            </div>
            <div class="mt-comment-text"> <?= $row['deskripsi'] ?> </div>
            <div class="alert alert-info text-<?= $color ?>" style="margin-top:10px;">
              <strong>
                <i class="fa fa-calendar"></i> Batas Akhir <?= tgl_indo($tgl_selesai) . ", " . $jam_selesai ?> WIB
              </strong>
            </div>
            <div class="mt-comment-details">
              <span class="mt-comment-status mt-comment-status-pending">
                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                  <div class="col-md-12">
                    <a href="javascript:;" class="btn btn-circle default green-stripe lihat_tugas" id="lihat_tugas" data-kode="<?= $row['tugas_awal'] ?>" style="background-color: #d9edf7;">Tugas Awal: <?= $row['tugas_awal'] ?></a>
                    <?php if (!empty($row['tugas_awal'])) { ?>
                      <span class="text-info" style="padding-top:7px;text-transform: none;">!klik untuk melihat</span>
                    <?php } else { ?>
                      <span class="text-danger" style="padding-top:7px;text-transform: none;">!Belum diatur, pilih edit untuk mengatur</span>
                    <?php } ?>
                  </div>
                </div>
                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                  <div class="col-md-12">
                    <a href="javascript:;" class="btn btn-circle default yellow-stripe bg-info lihat_tugas" id="lihat_tugas" data-kode="<?= $row['r1'] ?>" style="background-color: #fcf8e3;">Remidi 1: <?= $row['r1'] ?></a>
                    <?php if (!empty($row['r1'])) { ?>
                      <span class="text-info" style="padding-top:7px;text-transform: none;">!klik untuk melihat</span>
                    <?php } else { ?>
                      <span class="text-danger" style="padding-top:7px;text-transform: none;">!Belum diatur, pilih edit untuk mengatur</span>
                    <?php } ?>
                  </div>
                </div>
                <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                  <div class="col-md-12">
                    <a href="javascript:;" class="btn btn-circle default yellow-stripe bg-info lihat_tugas" id="lihat_tugas" data-kode="<?= $row['r2'] ?>" style="background-color: #fcf8e3;">Remidi 2: <?= $row['r2'] ?></a>
                    <?php if (!empty($row['r2'])) { ?>
                      <span class="text-info" style="padding-top:7px;text-transform: none;">!klik untuk melihat</span>
                    <?php } else { ?>
                      <span class="text-danger" style="padding-top:7px;text-transform: none;">!Belum diatur, pilih edit untuk mengatur</span>
                    <?php } ?>
                  </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                  <div class="col-md-12">
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-success nilai-penugasan" data-id="<?= $row['id'] ?>">Nilai <i class="fa fa-font"></i></button>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-primary edit-penugasan" data-id="<?= $row['id'] ?>">Edit <i class="fa fa-edit"></i></button>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-danger hapus-penugasan" data-id="<?= $row['id'] ?>">Hapus <i class="fa fa-trash"></i></button>
                  </div>
                </div>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  endwhile;
endif; ?>
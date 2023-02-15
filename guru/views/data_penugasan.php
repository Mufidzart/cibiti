<?php if ($getpenugasan->num_rows == 0) : ?>
  <div class="row">
    <div class="col-md-12 text-center" style="opacity: 0.5;">
      <img src="assets/images/no-content.png" alt="No Content">
      <h3>Belum ada penugasan</h3>
    </div>
  </div>
  <?php else :
  while ($data_penugasan = mysqli_fetch_assoc($getpenugasan)) :
    $id_penugasan = $data_penugasan['id'];
    $pecahtglinput = explode(" ", $data_penugasan['tgl_input']);
    $tgl_input = date("d-m-Y", strtotime($pecahtglinput[0]));
    $jam_input = date("H:i", strtotime($pecahtglinput[1]));
    // $pecahtglselesai = explode(" ", $data_penugasan['batas_tugas_awal']);
    // $tgl_selesai = date("Y-m-d", strtotime($pecahtglselesai[0]));
    // $jam_selesai = date("H:i", strtotime($pecahtglselesai[1]));
    // $today = new DateTime(date("Y-m-d"));
    // if ($today > $batas) {
    //   $color = "danger";
    // } else {
    //   $color = "info";
    // }
  ?>
    <div class="note note-info">
      <div class="mt-comments">
        <div class="mt-comment">
          <div class="mt-comment-body">
            <div class="mt-comment-info">
              <span class="mt-comment-author"><?= $data_penugasan['judul'] ?></span>
              <span class="mt-comment-date"><?= $tgl_input . ", " . $jam_input ?> WIB</span>
            </div>
            <div class="mt-comment-text"> <?= $data_penugasan['deskripsi'] ?> </div>
            <div class="mt-comment-details">
              <span class="mt-comment-status mt-comment-status-pending">
                <?php
                $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_penugasan='$id_penugasan' AND tgl_hapus IS NULL");
                while ($tugas = mysqli_fetch_assoc($get_tugas_penugasan)) : ?>
                  <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="col-md-12">
                      <a href="javascript:;" class="btn btn-circle default green-stripe lihat_tugas" id="lihat_tugas" data-id="<?= $tugas['id'] ?>" style="background-color: #d9edf7;"><?= $tugas['sub_tugas'] ?></a>
                      <span class="text-info" style="padding-top:7px;text-transform: none;">!klik untuk melihat soal</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="mt-comment-actions" style="margin: 0px 0px 0px 20px; float:left;">
                      <button type="button" class="btn btn-xs btn-circle btn-primary"> Edit <?= $tugas['sub_tugas'] ?> <i class="fa fa-edit"></i></button>
                    </div>
                  </div>
                <?php endwhile; ?>
                <div class="row" style="margin-top: 30px;">
                  <div class="col-md-12">
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-success nilai-penugasan" data-id="<?= $data_penugasan['id'] ?>">Nilai <i class="fa fa-font"></i></button>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-primary edit-penugasan" data-id="<?= $data_penugasan['id'] ?>">Edit <i class="fa fa-edit"></i></button>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-danger hapus-penugasan" data-id="<?= $data_penugasan['id'] ?>">Hapus <i class="fa fa-trash"></i></button>
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
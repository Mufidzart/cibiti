<?php if ($gettopik->num_rows == 0) : ?>
  <div class="row">
    <div class="col-md-12 text-center" style="opacity: 0.5;">
      <img src="assets/images/no-content.png" alt="No Content">
      <h3>Belum ada Topik Pembelajaran</h3>
    </div>
  </div>
  <?php else :
  $no = 1;
  while ($data_topik = mysqli_fetch_assoc($gettopik)) :
    $id_topik = $data_topik['id'];
    $pecahtglinput = explode(" ", $data_topik['tgl_input']);
    $tgl_input = date("d-m-Y", strtotime($pecahtglinput[0]));
    $jam_input = date("H:i", strtotime($pecahtglinput[1]));
  ?>
    <div class="note note-info">
      <div class="mt-comments">
        <div class="mt-comment">
          <div class="mt-comment-body">
            <div class="mt-comment-info">
              <span class="mt-comment-author">Topik <?= $no ?>: <?= $data_topik['judul'] ?></span>
              <span class="mt-comment-date"><?= $tgl_input . ", " . $jam_input ?> WIB</span>
            </div>
            <div class="mt-comment-text"> <?= $data_topik['deskripsi'] ?> </div>
            <div class="mt-comment-details">
              <span class="mt-comment-status mt-comment-status-pending">
                <?php
                $no = 1;
                $get_penugasan = mysqli_query($conn, "SELECT * FROM arf_history_penugasan WHERE id_topik='$id_topik' AND tgl_hapus IS NULL");
                while ($penugasan = mysqli_fetch_assoc($get_penugasan)) :
                  $id_penugasan = $penugasan['id'];
                  $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_penugasan='$id_penugasan' AND tgl_hapus IS NULL");
                  $tugas_penugasan = mysqli_fetch_assoc($get_tugas_penugasan); ?>
                  <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="col-md-12">
                      <a href="javascript:;" class="btn btn-circle default green-stripe lihat_tugas" data-id="<?= $tugas_penugasan['id'] ?>" style="background-color: #d9edf7;"><?= $tugas_penugasan['sub_tugas'] . " KE " . $no . ": " . $penugasan['judul'] ?></a>
                      <span class="text-info" style="padding-top:7px;text-transform: none;">!klik untuk melihat soal</span>
                    </div>
                  </div>
                  <!-- <div class="row">
                    <div class="mt-comment-actions" style="margin: 0px 0px 0px 20px; float:left;">
                      <button type="button" class="btn btn-xs btn-circle btn-primary"> Edit <?= $tugas_penugasan['sub_tugas'] ?> <i class="fa fa-edit"></i></button>
                    </div>
                  </div> -->
                <?php $no++;
                endwhile; ?>
                <div class="clearfix">
                  <div class="btn-group btn-group-solid">
                    <button type="button" class="btn green tambah-penugasan" data-id="<?= $data_topik['id'] ?>"><i class="fa fa-plus"></i> Penugasan</button>
                  </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                  <div class="col-md-12">
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-primary edit-topik" data-id="<?= $id_topik ?>">Edit <i class="fa fa-edit"></i></button>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-danger hapus-topik" data-id="<?= $id_topik ?>">Hapus <i class="fa fa-trash"></i></button>
                  </div>
                </div>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
    $no++;
  endwhile;
endif; ?>
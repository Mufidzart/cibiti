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
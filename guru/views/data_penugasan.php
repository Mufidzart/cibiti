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
                  <!-- <div class="row">
                    <div class="mt-comment-actions" style="margin: 0px 0px 0px 20px; float:left;">
                      <button type="button" class="btn btn-xs btn-circle btn-primary"> Edit <?= $tugas['sub_tugas'] ?> <i class="fa fa-edit"></i></button>
                    </div>
                  </div> -->
                <?php endwhile; ?>
                <div class="row" style="margin-top: 30px;">
                  <div class="col-md-12">
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-info nilai-penugasan" data-id="<?= $id_penugasan ?>">Nilai <i class="fa fa-font"></i></button>
                    <?php
                    $get_tugas_penugasan_r1 = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_penugasan='$id_penugasan' AND sub_tugas='Remidi 1' AND tgl_hapus IS NULL");
                    ?>
                    <?php if ($get_tugas_penugasan_r1->num_rows == 0) : ?>
                      <!-- <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-success tambah-subtugas" data-id="<?= $id_penugasan ?>" data-subtugas="Remidi 1">Remidi 1 <i class="fa fa-plus"></i></button> -->
                    <?php else : ?>
                      <?php
                      $get_tugas_penugasan_r2 = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_penugasan='$id_penugasan' AND sub_tugas='Remidi 2' AND tgl_hapus IS NULL");
                      ?>
                      <?php if ($get_tugas_penugasan_r2->num_rows == 0) : ?>
                        <!-- <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-success tambah-subtugas" data-id="<?= $id_penugasan ?>" data-subtugas="Remidi 2">Remidi 2 <i class="fa fa-plus"></i></button> -->
                      <?php endif; ?>
                    <?php endif; ?>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-primary edit-penugasan" data-id="<?= $id_penugasan ?>">Edit <i class="fa fa-edit"></i></button>
                    <button type="button" style="margin: 5px;" class="btn btn-circle btn-sm btn-danger hapus-penugasan" data-id="<?= $id_penugasan ?>">Hapus <i class="fa fa-trash"></i></button>
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

<!-- MODAL TAMBAH PENUGASAN -->
<div class="modal fade bs-modal-lg" id="modal-tambah-subtugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="title-modal">Tambah SubTugas</h4>
      </div>
      <form role="form" id="form-tambah-subtugas">
        <div class="modal-body form">
          <div class="form-body">
            <input class="form-control" type="hidden" id="id_topik" name="id_topik" value="">
            <input class="form-control" type="hidden" id="id_penugasan" name="id_penugasan" value="">
            <input class="form-control" type="hidden" id="subtugas" name="subtugas" value="">
            <!-- Tambah SubTugas -->
            <div class="note note-info">
              <div class="row col-md-12">
                <div class="form-group" id="form-tugas-awal">
                  <label for="label-tugas" class="control-label" id="label-tugas"><strong>Tugas</strong></label>
                  <input type="file" class="form-control col-md-4" style="margin-bottom: 10px;" name="fileexcel-tugas" id="fileexcel-tugas">
                  <div id="pesan-fileexcel-tugas"></div>
                </div>
              </div>
              <div class="form-group" id="form-batas-tugas">
                <label class="control-label">Batas akhir</label><br>
                <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
                  <input type="text" class="form-control" id="batas-tugas" name="batas-tugas">
                  <span class="input-group-btn">
                    <button class="btn default date-reset" type="button">
                      <i class="fa fa-times"></i>
                    </button>
                    <button class="btn default date-set" type="button">
                      <i class="fa fa-calendar"></i>
                    </button>
                  </span>
                </div>
                <div id="pesan-batas-tugas"></div>
              </div>
              <div class="form-group" id="form-durasi">
                <label class="control-label">Waktu pengerjaan</label><br>
                <div class="input-group">
                  <input type="text" class="form-control text-right" id="durasi" name="durasi">
                  <span class="input-group-btn">
                    <button class="btn default date-set" type="button">
                      menit
                    </button>
                  </span>
                </div>
                <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
                <div id="pesan-durasi"></div>
              </div>
              <div class="form-group" id="form-jumlah_soal">
                <label class="control-label">Jumlah Soal ditampilkan</label><br>
                <div class="input-group">
                  <input type="text" class="form-control text-right" id="jumlah_soal" name="jumlah_soal">
                  <span class="input-group-btn">
                    <button class="btn default date-set" type="button">
                      soal
                    </button>
                  </span>
                </div>
                <div id="pesan-jumlah_soal"></div>
              </div>
            </div>
            <!-- End -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn green">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL TAMBAH PENUGASAN -->
<!-- MODAL NILAI PENUGASAN -->
<div class="modal fade bs-modal-lg" id="modal-nilai" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="title-modal">Nilai Penugasan</h4>
      </div>
      <div class="modal-body" id="tampil-nilai">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- END MODAL NILAI PENUGASAN -->
<script>
  $(document).ready(function() {

    $('.tambah-subtugas').on('click', function(event) {
      var id_penugasan = $(this).attr('data-id');
      var subtugas = $(this).attr('data-subtugas');
      $('#id_penugasan').val(id_penugasan);
      $('#subtugas').val(subtugas);
      $('#label-tugas').html('Tugas ' + subtugas);
      $('#title-modal').html('Tambah Tugas ' + subtugas);
      $('#modal-tambah-subtugas').modal('show');
    });

    $("#form-tambah-subtugas").on("submit", function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        url: 'backend/function.php?action=tambah_subtugas',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            $('#form-tambah-subtugas').trigger("reset");
            $('#modal-tambah-penugasan').modal('hide');
            get_penugasan();
            get_penugasan_akanberakhir();
            for (i = 0; i < data.success.length; i++) {
              $('#pesan-' + data.success[i]).html('')
              $('#form-' + data.success[i]).removeClass('has-error');
            }
          } else {
            for (i = 0; i < data.errors.length; i++) {
              $('#pesan-' + data.errors[i].input).html('<span class="help-block" style="color:red;">' + data.errors[i].message + '</span>')
              $('#form-' + data.errors[i].input).addClass('has-error');
            }
            for (i = 0; i < data.success.length; i++) {
              $('#pesan-' + data.success[i]).html('')
              $('#form-' + data.success[i]).removeClass('has-error');
            }
          }
        }
      });
    });

    $(".nilai-penugasan").on("click", function() {
      var id_penugasan = $(this).attr('data-id');
      $.ajax({
        url: 'backend/function.php?action=get_nilai_penugasan',
        type: 'post',
        data: {
          id_penugasan: id_penugasan,
        },
        success: function(data) {
          $('#tampil-nilai').html(data);
          $('#modal-nilai').modal('show');
        }
      });
    });
  });
</script>
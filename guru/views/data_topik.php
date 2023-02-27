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
                    <button type="button" class="btn green tambah-penugasan" data-id-topik="<?= $data_topik['id'] ?>" data-judul="<?= $data_topik['judul'] ?>"><i class="fa fa-plus"></i> Penugasan</button>
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


<!-- MODAL TAMBAH PENUGASAN -->
<div class="modal fade bs-modal-lg" id="modal-tambah-tugas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="title-modal">Tambah Tugas</h4>
      </div>
      <form role="form" id="form-tambah-tugas">
        <div class="modal-body form">
          <div class="form-body">
            <input class="form-control" type="hidden" id="id_topik" name="id_topik" value="">
            <!-- Tambah SubTugas -->
            <div class="note">
              <div class="form-group">
                <a class="btn btn-circle green" data-toggle="modal" href="#modal-template-soal">Template Soal <i class="icon-wrench"></i></a>
              </div>
              <div class="row col-md-12">
                <div class="form-group" id="form-tugas">
                  <label for="label-tugas" class="control-label" id="label-tugas"><strong>Tugas</strong></label>
                  <input type="file" class="form-control col-md-4" style="margin-bottom: 10px;" name="fileexcel" id="fileexcel">
                  <div id="pesan-fileexcel"></div>
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
                  <input type="text" class="form-control text-right" id="durasi-tugas" name="durasi-tugas">
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

<script>
  $(document).ready(function() {
    $('.tambah-penugasan').on('click', function(event) {
      var id_topik = $(this).attr('data-id-topik');
      var judul_topik = $(this).attr('data-judul');
      $('#modal-tambah-tugas').find('#id_topik').val(id_topik);
      $('#modal-tambah-tugas').find('#label-tugas').html('Tugas ' + judul_topik);
      $('#modal-tambah-tugas').modal('show');
    });

    $("#form-tambah-tugas").on("submit", function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        url: 'backend/function.php?action=tambah_tugas_topik',
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
  });
</script>
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
    // $pecahtglselesai = explode(" ", $data_topik['batas_tugas_awal']);
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
              <span class="mt-comment-author">Topik <?= $no ?>: <?= $data_topik['judul'] ?></span>
              <span class="mt-comment-date"><?= $tgl_input . ", " . $jam_input ?> WIB</span>
            </div>
            <div class="mt-comment-text"> <?= $data_topik['deskripsi'] ?> </div>
            <div class="mt-comment-details">
              <span class="mt-comment-status mt-comment-status-pending">
                <!-- <button type="button" class="btn green tambah-penugasan" data-id-topik="<?= $data_topik['id'] ?>">Tambah Penugasan</button> -->
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
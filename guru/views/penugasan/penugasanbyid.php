<form role="form" class="form-edit-penugasan" id="form-edit-penugasan">
  <input type="hidden" class="form-control" name="id_tugas_penugasan" id="id_tugas_penugasan" value="<?= $data_penugasan['id'] ?>">
  <div class="form-body">
    <div class="form-group" id="form-judul">
      <label class="control-label">Judul Penugasan</label>
      <input class="form-control spinner" type="text" id="judul" name="judul" placeholder="Judul penugasan..." value="<?= $data_penugasan['judul'] ?>">
      <div id="pesan-judul"></div>
    </div>
    <div class="form-group" id="form-deskripsi">
      <label class="control-label">Deskripsi penugasan</label>
      <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi penugasan..."><?= $data_penugasan['deskripsi'] ?></textarea>
      <div id="pesan-deskripsi"></div>
    </div>
    <div class="form-group" id="form-jenis-tugas">
      <label class="control-label">Jenis Tugas</label>
      <select class="form-control jenis" id="jenis-tugas" name="jenis-tugas">
        <option></option>
        <?php
        $getjenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
        while ($jenis = mysqli_fetch_array($getjenis_tugas)) :
          $select = ($jenis['jenis_tugas'] == $data_penugasan['jenis_tugas']) ? "selected" : ""; ?>
          <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
        <?php endwhile; ?>
      </select>
      <div id="pesan-jenis-tugas"></div>
    </div>
    <div class="note note-info">
      <div class="form-group" id="form-batas-tugas">
        <label class="control-label">Batas akhir</label><br>
        <?php
        $get_date = date('Y-m-d');
        $get_time = date('H:i:s');
        $current_date = $get_date . 'T' . $get_time . 'Z'; ?>
        <div class="input-group date form_datetime" data-date="<?= $current_date ?>">
          <input type="text" class="form-control" id="batas-tugas" name="batas-tugas" value="<?= $data_penugasan['batas_tugas'] ?>">
          <span class="input-group-btn">
            <button class="btn default date-reset" type="button">
              <i class="fa fa-times"></i>
            </button>
            <button class="btn default date-set" type="button">
              <i class="fa fa-calendar"></i>
            </button>
          </span>
        </div>
        <div class="pesan" id="pesan-batas-tugas"></div>
      </div>
      <div class="form-group" id="form-durasi-tugas">
        <label class="control-label">Waktu pengerjaan</label><br>
        <div class="input-group">
          <input type="text" class="form-control text-right" id="durasi-tugas" name="durasi-tugas" value="<?= $data_penugasan['durasi_tugas'] ?>">
          <span class="input-group-btn">
            <button class="btn default date-set" type="button">
              menit
            </button>
          </span>
        </div>
        <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
        <div class="pesan" id="pesan-durasi-tugas"></div>
      </div>
      <div class="form-group" id="form-jumlah-soal-tugas">
        <label class="control-label">Jumlah Soal ditampilkan</label><br>
        <div class="input-group">
          <input type="text" class="form-control text-right" id="jumlah-soal-tugas" name="jumlah-soal-tugas" value="<?= $data_penugasan['jumlah_soal'] ?>">
          <span class="input-group-btn">
            <button class="btn default date-set" type="button">
              soal
            </button>
          </span>
        </div>
        <div class="pesan" id="pesan-jumlah-soal-tugas"></div>
      </div>
    </div>
  </div>
  <div class="form-actions right">
    <button type="submit" class="btn green btn_simpan_edit">Simpan</button>
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
  </div>
</form>
<script>
  $(document).ready(function() {
    $("#form-edit-penugasan").find("#jenis-tugas").select2({
      placeholder: "Pilih jenis tugas..",
      width: "100%"
    });

    $("#form-edit-penugasan").on("submit", function(event) {
      event.preventDefault();
      var formdata = $(this).serialize();
      var id_tugas_penugasan = $('#form-edit-penugasan').find('#id_tugas_penugasan').val();
      $.ajax({
        url: 'backend/function.php?action=proses_penugasan&run=update_penugasan',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            $('#modal-edit-penugasan').modal('hide');
            lihat_tugas(id_tugas_penugasan);
          } else {
            for (i = 0; i < data.errors.length; i++) {
              $('#form-edit-penugasan').find('#pesan-' + data.errors[i].input).html('<span class="help-block" style="color:red;">' + data.errors[i].message + '</span>')
              $('#form-edit-penugasan').find('#form-' + data.errors[i].input).addClass('has-error');
            }
            for (i = 0; i < data.success.length; i++) {
              $('#form-edit-penugasan').find('#pesan-' + data.success[i]).html('')
              $('#form-edit-penugasan').find('#form-' + data.success[i]).removeClass('has-error');
            }
          }
        }
      });
    });

    $('.form_datetime').datetimepicker();
  });
</script>
<form role="form" class="form-edit-penugasan" id="form-edit-penugasan">
  <input type="hidden" class="form-control" name="id-editpenugasan" value="<?= $data_penugasan['id'] ?>">
  <div class="form-body">
    <div class="form-group" id="form-judul-editpenugasan">
      <label class="control-label">Judul Penugasan</label>
      <input class="form-control spinner" type="text" id="judul-editpenugasan" name="judul-editpenugasan" placeholder="Judul penugasan..." value="<?= $data_penugasan['judul'] ?>">
      <div id="pesan-judul-editpenugasan"></div>
    </div>
    <div class="form-group" id="form-deskripsi-editpenugasan">
      <label class="control-label">Deskripsi penugasan</label>
      <textarea class="form-control" id="deskripsi-editpenugasan" name="deskripsi-editpenugasan" rows="3" placeholder="Deskripsi penugasan..."><?= $data_penugasan['deskripsi'] ?></textarea>
      <div id="pesan-deskripsi-editpenugasan"></div>
    </div>
    <div class="form-group" id="form-jenis-editpenugasan">
      <label class="control-label">Jenis Tugas</label>
      <select class="form-control jenis-editpenugasan" id="jenis-editpenugasan" name="jenis-editpenugasan">
        <option></option>
        <?php
        $getjenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
        while ($jenis = mysqli_fetch_array($getjenis_tugas)) :
          $select = ($jenis['jenis_tugas'] == $data_penugasan['jenis_tugas']) ? "selected" : ""; ?>
          <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
        <?php endwhile; ?>
      </select>
      <div id="pesan-jenis-editpenugasan"></div>
    </div>
  </div>
  <div class="form-actions right">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
    <button type="submit" class="btn green btn_simpan_edit">Simpan</button>
  </div>
</form>
<script>
  $(document).ready(function() {
    $("#jenis-editpenugasan").select2({
      placeholder: "Pilih jenis tugas..",
      allowClear: true,
      width: "100%"
    });
    $("#tugas-awal-editpenugasan").select2({
      placeholder: "Pilih tugas..",
      width: "100%"
    });
    $("#r1-editpenugasan").select2({
      placeholder: "Pilih tugas..",
      allowClear: true,
      width: "100%"
    });
    $("#r2-editpenugasan").select2({
      placeholder: "Pilih tugas..",
      allowClear: true,
      width: "100%"
    });
    $('#jenis-editpenugasan').on('select2:select', function(e) {
      var id_mapel = '<?= $data_penugasan['id_mapel'] ?>';
      var jenis_tugas = $(this).val();
      $.ajax({
        url: 'backend/function.php?action=get_data&get=data_tugas',
        type: 'post',
        data: {
          jenis_tugas: jenis_tugas,
          id_mapel: id_mapel
        },
        dataType: 'json',
        success: function(data) {
          var html = '';
          for (i = 0; i < data.length; i++) {
            html += '<option value="' + data[i].kode_tugas + '">(' + data[i].kode_tugas + ') ' + data[i].judul + '</option>';
          }
          $('#tugas-awal-editpenugasan').html(html);
          $('#r1-editpenugasan').html('<option value="">Pilih tugas</option>' + html);
          $('#r2-editpenugasan').html('<option value="">Pilih tugas</option>' + html);
          $('#tugas-awal-editpenugasan').trigger('change');
          $('#r1-editpenugasan').trigger('change');
          $('#r2-editpenugasan').trigger('change');
        }
      });
    });
    $("#form-edit-penugasan").on("submit", function(event) {
      event.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=edit_data_penugasan',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            $('#modal-edit-penugasan').modal('hide');
            get_penugasan();
            get_penugasan_akanberakhir();
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
    $('.form_datetime').datetimepicker();
  });
</script>
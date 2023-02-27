<form role="form" id="form-edit-topik">
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="control-label">Judul Topik</label>
        <input class="form-control" type="hidden" id="id_topik" name="id_topik" value="<?= $data_topik['id'] ?>">
        <input class="form-control spinner" type="text" id="judul-topik" name="judul-topik" placeholder="Judul topik..." value="<?= $data_topik['judul'] ?>">
        <div id="pesan-judul-topik"></div>
      </div>
      <div class="form-group" id="form-deskripsi-topik">
        <label class="control-label">Deskripsi Topik</label>
        <textarea class="form-control" id="deskripsi-topik" name="deskripsi-topik" rows="3" placeholder="Deskripsi topik..."><?= $data_topik['deskripsi'] ?></textarea>
        <div id="pesan-deskripsi-topik"></div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn green">Simpan</button>
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Batal</button>
  </div>
</form>

<script>
  $(document).ready(function() {

    $("#form-edit-topik").on("submit", function(event) {
      event.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=proses_topik&run=update_topik',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            $('#modal-edit-topik').modal('hide');
            get_topik();
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
<form role="form" class="form-edit-penugasan" id="form-edit-penugasan">
  <input type="hidden" class="form-control" name="id-editpenugasan" value="<?= $penugasan['id'] ?>">
  <div class="form-body">
    <div class="form-group" id="form-judul-editpenugasan">
      <label class="control-label">Judul Penugasan</label>
      <input class="form-control spinner" type="text" id="judul-editpenugasan" name="judul-editpenugasan" placeholder="Judul penugasan..." value="<?= $penugasan['judul'] ?>">
      <div id="pesan-judul-editpenugasan"></div>
    </div>
    <div class="form-group" id="form-deskripsi-editpenugasan">
      <label class="control-label">Deskripsi penugasan</label>
      <textarea class="form-control" id="deskripsi-editpenugasan" name="deskripsi-editpenugasan" rows="3" placeholder="Deskripsi penugasan..."><?= $penugasan['deskripsi'] ?></textarea>
      <div id="pesan-deskripsi-editpenugasan"></div>
    </div>
    <div class="form-group" id="form-jenis-edittugas">
      <label class="control-label">Jenis Tugas</label>
      <select class="form-control jenis-edittugas" id="jenis-edittugas" name="jenis-edittugas">
        <option></option>
        <?php while ($jenis = mysqli_fetch_array($getjenis_tugas)) :
          $select = ($jenis['jenis_tugas'] == $jenis_tugas) ? "selected" : ""; ?>
          <option value="<?= $jenis['jenis_tugas'] ?>" <?= $select ?>><?= $jenis['jenis_tugas'] ?></option>
        <?php endwhile; ?>
      </select>
      <div id="pesan-jenis-edittugas"></div>
    </div>
    <div class="note note-info">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group" id="form-tugas-awal-editpenugasan">
            <label for="tugas-awal" class="control-label"><strong>Tugas Awal</strong></label>
            <select class="form-control" id="tugas-awal-editpenugasan" name="tugas-awal-editpenugasan">
              <?php while ($tugas = mysqli_fetch_array($gettugas_all)) :
                $select = ($tugas['kode_tugas'] == $tugas_awal) ? "selected" : ""; ?>
                <option value="<?= $tugas['kode_tugas'] ?>" <?= $select ?>>(<?= $tugas['kode_tugas'] ?>) <?= $tugas['judul'] ?></option>
              <?php endwhile; ?>
            </select>
            <div id="pesan-tugas-awal-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-5 col-xl-12">
          <div class="form-group" id="form-batas-tugas-awal-editpenugasan">
            <label class="control-label">Batas akhir penugasan</label><br>
            <div class="input-group date form_datetime" data-date="<?= $date_tugas_awal ?>">
              <input type="text" class="form-control" id="batas-tugas-awal-editpenugasan" name="batas-tugas-awal-editpenugasan" value="<?= $penugasan['batas_tugas_awal'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-reset" type="button">
                  <i class="fa fa-times"></i>
                </button>
                <button class="btn default date-set" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
            <div id="pesan-batas-tugas-awal-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-4 col-xl-12">
          <div class="form-group" id="form-durasi-tugas-awal-editpenugasan">
            <label class="control-label">Waktu pengerjaan</label><br>
            <div class="input-group">
              <input type="text" class="form-control text-right" id="durasi-tugas-awal-editpenugasan" name="durasi-tugas-awal-editpenugasan" value="<?= $penugasan['durasi_menit_tugas_awal'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-set" type="button">
                  menit
                </button>
              </span>
            </div>
            <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
            <div id="pesan-durasi-tugas-awal-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-3 col-xl-12">
          <div class="form-group" id="form-jumlah_soal-tugas-awal-editpenugasan">
            <label class="control-label">Jumlah Soal</label><br>
            <div class="input-group">
              <input type="text" class="form-control text-right" id="jumlah_soal-tugas-awal-editpenugasan" name="jumlah_soal-tugas-awal-editpenugasan" value="<?= $penugasan['jumlah_soal_tugas_awal'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-set" type="button">
                  soal
                </button>
              </span>
            </div>
            <div id="pesan-jumlah_soal-tugas-awal-editpenugasan"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="note note-warning" style="background-color: #fcf8e3;">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group" id="form-r1-editpenugasan">
            <label for="r1" class="control-label"><strong>Remidi 1</strong></label>
            <select class="form-control" id="r1-editpenugasan" name="r1-editpenugasan">
              <option value="">Pilih tugas..</option>
              <?php $gettugas_all = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE jenis='$jenis_tugas' AND tgl_hapus IS NULL"); ?>
              <?php while ($tugas = mysqli_fetch_array($gettugas_all)) :
                $select = ($tugas['kode_tugas'] == $r1) ? "selected" : ""; ?>
                <option value="<?= $tugas['kode_tugas'] ?>" <?= $select ?>>(<?= $tugas['kode_tugas'] ?>) <?= $tugas['judul'] ?></option>
              <?php endwhile; ?>
            </select>
            <div id="pesan-r1-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-6 col-xl-12">
          <div class="form-group" id="form-batas-r1-editpenugasan">
            <label class="control-label">Batas akhir penugasan</label><br>
            <div class="input-group date form_datetime" data-date="<?= $date_r1 ?>">
              <input type="text" class="form-control" id="batas-r1-editpenugasan" name="batas-r1-editpenugasan" value="<?= $penugasan['batas_r1'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-reset" type="button">
                  <i class="fa fa-times"></i>
                </button>
                <button class="btn default date-set" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
            <div id="pesan-batas-r1-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-3 col-xl-12">
          <div class="form-group" id="form-durasi-r1-editpenugasan">
            <label class="control-label">Waktu pengerjaan</label><br>
            <div class="input-group">
              <input type="text" class="form-control text-right" id="durasi-r1-editpenugasan" name="durasi-r1-editpenugasan" value="<?= $penugasan['durasi_menit_r1'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-set" type="button">
                  menit
                </button>
              </span>
            </div>
            <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
            <div id="pesan-durasi-r1-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-3 col-xl-12">
          <div class="form-group" id="form-jumlah_soal-r1-editpenugasan">
            <label class="control-label">Jumlah Soal</label><br>
            <div class="input-group">
              <input type="text" class="form-control text-right" id="jumlah_soal-r1-editpenugasan" name="jumlah_soal-r1-editpenugasan" value="<?= $penugasan['jumlah_soal_r1'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-set" type="button">
                  soal
                </button>
              </span>
            </div>
            <div id="pesan-jumlah_soal-r1-editpenugasan"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="note note-warning" style="background-color: #fcf8e3;">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group" id="form-r2-editpenugasan">
            <label for="r2" class="control-label"><strong>Remidi 2</strong></label>
            <select class="form-control" id="r2-editpenugasan" name="r2-editpenugasan">
              <option value="">Pilih tugas..</option>
              <?php $gettugas_all = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE jenis='$jenis_tugas' AND tgl_hapus IS NULL"); ?>
              <?php while ($tugas = mysqli_fetch_array($gettugas_all)) :
                $select = ($tugas['kode_tugas'] == $r2) ? "selected" : ""; ?>
                <option value="<?= $tugas['kode_tugas'] ?>" <?= $select ?>>(<?= $tugas['kode_tugas'] ?>) <?= $tugas['judul'] ?></option>
              <?php endwhile; ?>
            </select>
            <div id="pesan-r2-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-6 col-xl-12">
          <div class="form-group" id="form-batas-r2-editpenugasan">
            <label class="control-label">Batas akhir penugasan</label><br>
            <div class="input-group date form_datetime" data-date="<?= $date_r2 ?>">
              <input type="text" class="form-control" id="batas-r2-editpenugasan" name="batas-r2-editpenugasan" value="<?= $penugasan['batas_r2'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-reset" type="button">
                  <i class="fa fa-times"></i>
                </button>
                <button class="btn default date-set" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
            <div id="pesan-batas-r2-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-3 col-xl-12">
          <div class="form-group" id="form-durasi-r2-editpenugasan">
            <label class="control-label">Waktu pengerjaan</label><br>
            <div class="input-group">
              <input type="text" class="form-control text-right" id="durasi-r2-editpenugasan" name="durasi-r2-editpenugasan" value="<?= $penugasan['durasi_menit_r2'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-set" type="button">
                  menit
                </button>
              </span>
            </div>
            <span class="help-block"> isikan angka 0 jika tidak dibatasi. </span>
            <div id="pesan-durasi-r2-editpenugasan"></div>
          </div>
        </div>
        <div class="col-md-3 col-xl-12">
          <div class="form-group" id="form-jumlah_soal-r2-editpenugasan">
            <label class="control-label">Jumlah Soal</label><br>
            <div class="input-group">
              <input type="text" class="form-control text-right" id="jumlah_soal-r2-editpenugasan" name="jumlah_soal-r2-editpenugasan" value="<?= $penugasan['jumlah_soal_r2'] ?>">
              <span class="input-group-btn">
                <button class="btn default date-set" type="button">
                  soal
                </button>
              </span>
            </div>
            <div id="pesan-jumlah_soal-r2-editpenugasan"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="form-actions right">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
    <button type="submit" class="btn green btn_simpan_edit">Simpan</button>
  </div>
</form>
<script>
  $(document).ready(function() {
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
    $('#jenis-edittugas').on('select2:select', function(e) {
      var id_mapel = '<?= $penugasan['id_mapel'] ?>';
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
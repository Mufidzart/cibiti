<?php
if ($getsoal) {
  $soal = mysqli_fetch_assoc($getsoal);
?>
  <form role="form" class="form-edit-soal" id="form-edit-soal">
    <input type="hidden" class="form-control" name="id_soal" value="<?= $soal['id'] ?>">
    <div class="form-body">
      <div class="form-group" id="form-edit-tipe-soal">
        <label class="control-label">Tipe Pertanyaan</label>
        <select class="form-control" id="tipe-soal" name="tipe-soal">
          <?php while ($row = mysqli_fetch_assoc($tipe_soal)) :
            $select = ($row['tipe_soal'] == $soal['tipe_soal']) ? "selected" : ""; ?>
            <option value="<?= $row['tipe_soal'] ?>" <?= $select ?>><?= $row['tipe_soal'] ?></option>
          <?php endwhile; ?>
        </select>
        <div id="pesan-edit-tipe-soal"></div>
      </div>
      <div class="form-group" id="form-edit-pertanyaan">
        <label class="control-label">Pertanyaan</label>
        <textarea class="form-control col-md-4" id="pertanyaan" name="pertanyaan" rows="3" style="margin-bottom: 20px;"><?= $soal['pertanyaan'] ?></textarea>
        <div id="pesan-edit-pertanyaan"></div>
      </div>
      <div id="jawaban-edit" style="padding: 20px;">
        <div class="form-group">
          <label class="control-label">Pilihan Jawaban</label>
        </div>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($getjawaban)) :
          $check = ($row['kunci'] == "1") ? "checked" : ""; ?>
          <div class="form-group" id="form-edit-pilihan-<?= $no ?>">
            <div class="input-group" style="margin-top: 5px; margin-bottom: 5px;">
              <span class="input-group-addon">
                <input type="radio" name="radio-pilihan" value="<?= $no ?>" <?= $check ?>>
                <span></span>
              </span>
              <input type="text" class="form-control" name="pilihan-<?= $no ?>" value="<?= $row['jawaban'] ?>">
            </div>
            <div id="pesan-edit-pilihan-<?= $no ?>"></div>
            <?php if ($no == 4) : ?>
              <div id="pesan-edit-radio-pilihan"></div>
            <?php endif; ?>
          </div>
        <?php $no++;
        endwhile; ?>
      </div>
    </div>
    <div class="form-actions right">
      <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
      <button type="submit" class="btn green">Simpan</button>
    </div>
  </form>
<?php
} else {
  $data = "Gagal Mengambil Data :" . mysqli_error($conn);
  echo $data;
}
?>
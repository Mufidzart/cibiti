<?php if ($getsoal->num_rows == 0) : ?>
  <div class="row">
    <div class="col-md-12 text-center" style="opacity: 0.5;">
      <img src="assets/images/no-content.png" alt="No Content">
      <h3>Belum ada soal</h3>
    </div>
  </div>
<?php else : ?>
  <?php
  $no = 1;
  while ($row = mysqli_fetch_assoc($getsoal)) : ?>
    <li>
      <div class="col1">
        <div class="cont">
          <div class="cont-col1">
            <div class="label label-sm label-success" style="width: 20px; height: max-content; color:white;">
              <?= $no ?>
            </div>
          </div>
          <div class="cont-col2">
            <div class="desc" style="color:black;">
              <?= $row['pertanyaan'] ?>
            </div>
            <div class="desc" style="color:black;">
              <?php
              $id_soal = $row['id'];
              $getjawaban = mysqli_query($conn, "SELECT * FROM arf_kunci_soal WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
              if ($getjawaban) : ?>
                <div class="form-group">
                  <div class="mt-radio-list">
                    <?php while ($kunci_row = mysqli_fetch_assoc($getjawaban)) :
                      if ($kunci_row['kunci'] == "1") {
                        $check = "checked";
                        $label = "<b style='background-color:#32c5d254;padding:5px;'>" . $kunci_row['jawaban'] . "</b>";
                      } else {
                        $check = "";
                        $label = $kunci_row['jawaban'];
                      }
                    ?>
                      <label class="mt-radio">
                        <input type="radio" name="kunci_<?= $kunci_row['id'] ?>" id="kunci_<?= $kunci_row['id'] ?>" value="<?= $kunci_row['jawaban'] ?>" disabled <?= $check ?>>
                        <?= $label ?>
                        <span></span>
                      </label>
                    <?php endwhile; ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col2">
        <a href="javascript:;" class="btn btn-circle btn-icon-only green edit-soal" data-id="<?= $row['id'] ?>"><i class="fa fa-edit"></i></a>
        <a href="javascript:;" class="btn btn-circle btn-icon-only red hapus-soal" data-id="<?= $row['id'] ?>"><i class="fa fa-trash"></i></a>
      </div>
    </li>
<?php
    $no++;
  endwhile;
endif; ?>
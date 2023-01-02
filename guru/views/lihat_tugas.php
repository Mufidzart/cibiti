<?php $id_tugas = $datatugas['id']; ?>
<div class="portlet light bordered">
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12 profile-info" style="padding-right: 50px;padding-left: 50px;margin-bottom: 50px;">
        <a href="javascript:;" class="btn btn-circle default green-stripe" id="text-kode">KODE: <?= $datatugas['kode_tugas'] ?></a>
        <h2 class="font-green sbold uppercase" id="text-judul"><?= $datatugas['judul'] ?></h2>
        <p id="text-deskripsi"><?= $datatugas['deskripsi'] ?></p>
        <ul class="list-inline">
          <li id="text-jenis">
            <i class="fa fa-briefcase"></i> <?= $datatugas['jenis'] ?>
          </li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="portlet light bordered">
          <div class="portlet-title">
            <div class="caption">
              <i class="icon-bubble font-green-sharp"></i>
              <span class="caption-subject font-green-sharp bold uppercase">SOAL</span>
            </div>
          </div>
          <div class="portlet-body">
            <ul class="feeds">
              <?php
              $getsoal = mysqli_query($conn, "SELECT * FROM arf_soal WHERE kode_tugas='$kode_tugas' AND tgl_hapus IS NULL");
              if ($getsoal) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($getsoal)) {
              ?>
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
                  </li>
              <?php
                  $no++;
                }
              } else {
                $data = "Gagal Mengambil Data :" . mysqli_error($conn);
                echo $data;
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
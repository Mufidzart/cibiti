<?php
$id_tugas_penugasan = $data_tugas_penugasan['id'];
$getsoal = mysqli_query($conn, "SELECT * FROM soal_tugas_penugasan WHERE id_tugas_penugasan='$id_tugas_penugasan' AND tgl_hapus IS NULL");
$jumlah_soal = $getsoal->num_rows;
?>
<div class="portlet">
  <div class="row">
    <div class="col-md-12 profile-info" style="padding-right: 50px;padding-left: 50px;margin-bottom: 50px;">
      <h3 class="font-green sbold uppercase" id="text-judul"><?= $data_tugas_penugasan['jenis_tugas'] ?>: <?= $data_tugas_penugasan['judul'] ?></h3>
      <a href="javascript:;" class="btn btn-circle default blue-stripe" style="margin-top:10px;margin-bottom:10px;"> Batas Akhir: <?= $data_tugas_penugasan['batas_tugas'] ?></a>
      <a href="javascript:;" class="btn btn-circle default blue-stripe" style="margin-top:10px;margin-bottom:10px;"> Jumlah Soal: <?= $jumlah_soal ?></a>
      <a href="javascript:;" class="btn btn-circle default green-stripe" style="margin-top:10px;margin-bottom:10px;"> Jumlah Soal Ditampilkan: <?= $data_tugas_penugasan['jumlah_soal'] ?></a>
      <a href="javascript:;" class="btn btn-circle default green-stripe" style="margin-top:10px;margin-bottom:10px;"> Durasi: <?= $data_tugas_penugasan['durasi_tugas'] ?> Menit</a><br>
      <a href="javascript:;" class="btn btn-circle btn-sm btn-info nilai-penugasan" data-id="<?= $id_tugas_penugasan ?>">Nilai <i class="fa fa-font"></i></a>
      <a href="javascript:;" class="btn btn-circle btn-sm btn-primary edit-penugasan" data-id="<?= $id_tugas_penugasan ?>">Edit <i class="fa fa-edit"></i></a>
      <a href="javascript:;" class="btn btn-circle btn-sm btn-danger hapus-penugasan" data-id="<?= $id_tugas_penugasan ?>">Hapus <i class="fa fa-trash"></i></a>
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
                          $getjawaban = mysqli_query($conn, "SELECT * FROM jawaban_soal_tugas_penugasan WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
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
<script>
  $(document).ready(function() {
    $('.nilai-penugasan').on('click', function() {
      var id_tugas_penugasan = $(this).attr("data-id");
      $.ajax({
        url: 'backend/function.php?action=proses_penugasan&run=nilai_penugasan',
        type: 'post',
        data: {
          id_tugas_penugasan: id_tugas_penugasan,
        },
        success: function(data) {
          $('#show_nilai').html(data);
          $('#modal-lihat-nilai').modal('show');
        }
      });
    });

    $('.edit-penugasan').on('click', function() {
      var id_tugas_penugasan = $(this).attr("data-id");
      $.ajax({
        url: 'backend/function.php?action=proses_penugasan&run=penugasanbyid',
        type: 'post',
        data: {
          id_tugas_penugasan: id_tugas_penugasan,
        },
        success: function(data) {
          $('#tampil-edit-penugasan').html(data);
          $('#modal-edit-penugasan').modal('show');
        }
      });
    });

    $('.hapus-penugasan').on('click', function(event) {
      var id_tugas_penugasan = $(this).attr("data-id");
      $('#form-hapus-penugasan').find('#id_tugas_penugasan').val(id_tugas_penugasan);
      $('#modal-hapus-penugasan').modal('show');
    });
  });
</script>
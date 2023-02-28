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
          <div class="actions">
            <a class="btn btn-circle green" id="btn-tambah-soal">Tambah Soal <i class="icon-plus"></i></a>
          </div>
        </div>
        <div class="portlet-body">
          <ul class="feeds">
            <?php if ($getsoal->num_rows !== 0) : ?>
              <?php
              if ($getsoal) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($getsoal)) {
                  $id_soal = $row['id'];
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
                            <a href="javascript:;" class="btn btn-circle btn-icon-only red hapus-soal" data-id="<?= $id_soal ?>">
                              <i class="fa fa-trash"></i>
                            </a>
                          </div>
                          <div class="desc" style="color:black;">
                            <?php
                            $getjawaban = mysqli_query($conn, "SELECT * FROM jawaban_soal_tugas_penugasan WHERE id_soal='$id_soal' AND tgl_hapus IS NULL");
                            if ($getjawaban) : ?>
                              <div class="form-group" style="margin-bottom: 0px;">
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
                          <div class="desc" style="color:black; margin-top:-20px; margin-bottom:20px;">

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
            <?php else : ?>
              <div class="row">
                <div class="col-md-12 text-center" style="opacity: 0.5;">
                  <img src="assets/images/no-content.png" alt="No Content">
                  <h3>Belum ada Soal</h3>
                </div>
              </div>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH PENUGASAN -->
<div class="modal fade bs-modal-lg" id="modal-tambah-soal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah soal</h4>
      </div>
      <form role="form" id="form-tambah-soal">
        <div class="modal-body form">
          <div class="form-body">
            <!-- Tugas Awal -->
            <div class="note note-info">
              <div class="form-group" id="form-fileexcel">
                <label for="tugas" class="control-label">File Tugas</label>
                <input class="form-control" type="hidden" id="id_tugas_penugasan" name="id_tugas_penugasan" value="<?= $id_tugas_penugasan ?>">
                <input type="file" class="form-control col-md-4" style="margin-bottom: 10px;" name="fileexcel" id="fileexcel">
                <div class="pesan" id="pesan-fileexcel"></div>
              </div>
            </div>
            <!-- End -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn green">upload</button>
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END MODAL TAMBAH PENUGASAN -->
<!-- MODAL HAPUS SOAL -->
<div class="modal fade bs-modal-md" id="modal-hapus-soal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Hapus Penugasan</h4>
      </div>
      <form role="form" id="form-hapus-soal">
        <div class="modal-body">
          <div class="form-body">
            <div class="form-group">
              <input class="form-control spinner" type="hidden" id="id_soal" name="id_soal" value="">
              <div class="note note-danger">
                <h4 class="block">Peringatan Hapus!</h4>
                <p> Apakah anda yakin menghapus data ini? </p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn red">Hapus</button>
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END MODAL HAPUS SOAL -->
<script>
  $(document).ready(function() {
    $('#btn-tambah-soal').on('click', function(event) {
      $('#modal-tambah-soal').addClass("modal-tambah-soal");
      $('#modal-tambah-soal').appendTo("body").modal('show');
    });

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

    $('.hapus-soal').on('click', function(event) {
      var id_soal = $(this).attr("data-id");
      $('#form-hapus-soal').find('#id_soal').val(id_soal);
      $('#modal-hapus-soal').addClass("modal-hapus-soal");
      $('#modal-hapus-soal').appendTo("body").modal('show');
    });

    $("#form-hapus-soal").on("submit", function(event) {
      event.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: 'backend/function.php?action=proses_soal&run=hapus_soal',
        type: 'post',
        data: formdata,
        dataType: 'json',
        success: function(data) {
          lihat_tugas("<?= $id_tugas_penugasan ?>")
          $("body").find('.modal-hapus-soal').modal('hide');
        }
      });
    });

    $("#form-tambah-soal").on("submit", function(e) {
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      $.ajax({
        url: 'backend/function.php?action=proses_soal&run=tambah_soal',
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
          if (data.acc == true) {
            $('#form-tambah-soal').trigger("reset");
            lihat_tugas("<?= $id_tugas_penugasan ?>")
            $("body").find('.modal-tambah-soal').modal('hide');
            for (i = 0; i < data.success.length; i++) {
              $("body").find('.modal-tambah-soal').find("#form-tambah-soal").find('#pesan-' + data.success[i]).html('')
              $("body").find('.modal-tambah-soal').find("#form-tambah-soal").find('#form-' + data.success[i]).removeClass('has-error');
            }
          } else {
            for (i = 0; i < data.errors.length; i++) {
              $("body").find('.modal-tambah-soal').find("#form-tambah-soal").find('#pesan-' + data.errors[i].input).html('<span class="help-block" style="color:red;">' + data.errors[i].message + '</span>')
              $("body").find('.modal-tambah-soal').find("#form-tambah-soal").find('#form-' + data.errors[i].input).addClass('has-error');
            }
            for (i = 0; i < data.success.length; i++) {
              $("body").find('.modal-tambah-soal').find("#form-tambah-soal").find('#pesan-' + data.success[i]).html('')
              $("body").find('.modal-tambah-soal').find("#form-tambah-soal").find('#form-' + data.success[i]).removeClass('has-error');
            }
          }
        }
      });
    });
  });
</script>
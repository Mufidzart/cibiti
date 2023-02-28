<?php
$id_materi = $data_materi['id'];
?>
<div class="portlet">
  <div class="row">
    <div class="col-md-12 profile-info" style="padding-right: 50px;padding-left: 50px;margin-bottom: 50px;">
      <h3 class="font-yellow sbold uppercase" id="text-judul"><?= $data_materi['judul'] ?></h3>
      <p><?= $data_materi['deskripsi'] ?></p>
      <p>
        <a href="backend/download.php?action=download-materi&id=<?= $data_materi['id'] ?>" target="_blank" class="btn green-haze btn-outline sbold uppercase"><i class="fa fa-file"></i> <?= $data_materi['file'] ?></a>
      </p>
      <a href="javascript:;" class="btn btn-circle btn-sm btn-danger hapus-materi" data-id="<?= $id_materi ?>">Hapus <i class="fa fa-trash"></i></a>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    $('.hapus-materi').on('click', function(event) {
      var id_materi = $(this).attr("data-id");
      $('#form-hapus-materi').find('#id_materi').val(id_materi);
      $('#modal-hapus-materi').modal('show');
    });

    $('.download-materi').on('click', function(event) {
      var id_materi = $(this).attr("data-id");
      $.ajax({
        url: 'backend/function.php?action=proses_materi&run=download',
        type: 'post',
        data: {
          id_tugas_penugasan: id_tugas_penugasan,
        },
        success: function(data) {}
      });
    });

  });
</script>
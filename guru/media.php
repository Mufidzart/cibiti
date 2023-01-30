<?php
require('backend/connection.php');
$page_title = "Media Learning Management System (LMS)";
require('layouts/headlayout.php');
$getfile = mysqli_query($conn, "SELECT * FROM arf_media_upload");
?>
<style>
  .gallery-title {
    font-size: 36px;
    color: #42B32F;
    text-align: center;
    font-weight: 500;
    margin-bottom: 70px;
  }

  .gallery-title:after {
    content: "";
    position: absolute;
    width: 7.5%;
    left: 46.5%;
    height: 45px;
    border-bottom: 1px solid #5e5e5e;
  }

  .filter-button {
    font-size: 18px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 30px;

  }

  .filter-button:hover {
    font-size: 18px;
    border: 1px solid #42B32F;
    border-radius: 5px;
    text-align: center;
    color: #ffffff;
    background-color: #42B32F;

  }

  .btn-default:active .filter-button:active {
    background-color: #42B32F;
    color: white;
  }

  .port-image {
    width: 100%;
  }

  .gallery_product {
    margin-bottom: 30px;
  }
</style>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
  <!-- BEGIN CONTENT BODY -->
  <div class="page-content">
    <div class="page-head">
      <!-- BEGIN PAGE TITLE -->
      <div class="page-title">
        <h1><?= $page_title ?>
          <small></small>
        </h1>
      </div>
      <!-- END PAGE TITLE -->
      <!-- BEGIN PAGE TOOLBAR -->
      <div class="page-toolbar">
      </div>
      <!-- END PAGE TOOLBAR -->
    </div>
    <!-- END PAGE HEAD-->
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
      <li>
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
      </li>
      <li>
        <span class="active">Apps</span>
      </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <a class="btn btn-circle green" data-toggle="modal" href="#tambah-media">Tambah Media <i class="fa fa-plus"></i></a>
    <div class="container">
      <div class="row">
        <div align="left" style="margin-top:20px;">
          <button class="btn btn-default filter-button" data-filter="all">All</button>
          <button class="btn btn-default filter-button" data-filter="image">Gambar</button>
          <button class="btn btn-default filter-button" data-filter="record">Audio</button>
        </div>
        <br />
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($getfile)) :
          $extension  = pathinfo($row["nama"], PATHINFO_EXTENSION);
          $image = ['jpg', 'jpeg', 'png'];
          if (in_array($extension, $image)) {
            $label = "image";
            $src = $baseurl . "/guru/uploads/" . $row["nama"];
            $url_link = $src;
          } else {
            $label = "record";
            $src = $baseurl . "/guru/assets/images/audio-bg.png";
            $url_link = $baseurl . "/guru/uploads/" . $row["nama"];
          }
        ?>
          <div class="gallery_product col-lg-3 col-md-4 col-sm-4 col-xs-6 filter <?= $label ?>">
            <img src="<?= $src ?>" class="img-responsive">
            <?php if (!in_array($extension, $image)) : ?>
              <audio controls>
                <source src="<?= $baseurl . "/guru/uploads/" . $row["nama"] ?>" type="audio/mpeg">
                Your browser does not support the audio element.
              </audio>
            <?php endif; ?>
            <br>
            <a href="javascript:;" class="btn btn-sm grey-cascade copy-url-link" style="margin-top: 10px;" data-no="<?= $no ?>" url-link="<?= $url_link ?>"> Copy Link
              <i class="fa fa-link"></i>
            </a>
            <br>
            <a class=" btn btn-circle green" id="notice-<?= $no ?>" style="display: none;margin-top: 10px;">Berhasil copy url</a>
          </div>
        <?php $no++;
        endwhile; ?>
      </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
  </div>
  <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- /.modal -->
<div class=" modal fade bs-modal-lg" id="tambah-media" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Tambah Media Baru</h4>
      </div>
      <form role="form" id="form-tambah-tugas">
        <div class="modal-body">
          <div id="pesan"></div>
          <div class="form-body text-center">
            <div id="drop_zone">
              <p>Drop file here</p>
              <p>or</p>
              <p><button type="button" id="btn_file_pick" class="btn btn-primary" style="display: block;"><span class="glyphicon glyphicon-folder-open"></span> Select File</button></p>
              <p id="file_info"></p>
              <input type="file" style="display: none;" id="selectfile" multiple="true">
              <p id="message_info"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Tutup</button>
          <button type="button" id="btn_upload" class="btn green" style="display: none;">Buat Tugas</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
  var fileobj;
  $(document).ready(function() {
    $('.copy-url-link').on('click', function() {
      var temp = $("<input>");
      $("body").append(temp);
      temp.val($(this).attr('url-link')).select();
      document.execCommand("copy");
      temp.remove();
      var no = $(this).attr('data-no');
      console.log(no)
      $('#notice-' + no).attr("style", "display: block");
      setTimeout(function() {
        $('#notice-' + no).attr("style", "display: none");
      }, 2000);
    })

    $("#drop_zone").on("dragover", function(event) {
      event.preventDefault();
      event.stopPropagation();
      return false;
    });

    $("#drop_zone").on("drop", function(event) {
      event.preventDefault();
      event.stopPropagation();
      fileobj = event.originalEvent.dataTransfer.files;
      if (fileobj.length > 0) {
        for (var f = 0; f < fileobj.length; f++) {
          var fname = fileobj[f].name;
          var fsize = fileobj[f].size;
          if (fname.length > 0) {
            document.getElementById('file_info').innerHTML += "File name : " + fname + ' (<b>' + bytesToSize(fsize) + '</b>)<br>';
          }
        }
      }
      document.getElementById('selectfile').files = fileobj;
      document.getElementById('btn_upload').style.display = "inline";
    });

    $('#btn_file_pick').click(function() {
      /*normal file pick*/
      document.getElementById('selectfile').click();
      document.getElementById('selectfile').onchange = function() {
        fileobj = document.getElementById('selectfile').files;
        if (fileobj.length > 0) {
          for (var f = 0; f < fileobj.length; f++) {
            var fname = fileobj[f].name;
            var fsize = fileobj[f].size;
            if (fname.length > 0) {
              document.getElementById('file_info').innerHTML += "File name : " + fname + ' (<b>' + bytesToSize(fsize) + '</b>)<br>';
            }
          }
        }
        document.getElementById('btn_upload').style.display = "inline";
      };
    });
    $('#btn_upload').click(function() {
      if (fileobj == "" || fileobj == null) {
        alert("Please select a file");
        return false;
      } else {
        ajax_file_upload(fileobj);
      }
    });

    $(".filter-button").click(function() {
      var value = $(this).attr('data-filter');

      if (value == "all") {
        //$('.filter').removeClass('hidden');
        $('.filter').show('1000');
      } else {
        //            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
        //            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
        $(".filter").not('.' + value).hide('3000');
        $('.filter').filter('.' + value).show('3000');

      }
    });

    if ($(".filter-button").removeClass("active")) {
      $(this).removeClass("active");
    }
    $(this).addClass("active");

  });

  function ajax_file_upload(file_obj) {
    if (file_obj != undefined) {
      var form_data = new FormData();
      if (fileobj.length > 0) {
        for (var f = 0; f < fileobj.length; f++) {
          form_data.append('upload_file[]', file_obj[f]);
        }
      }
      $.ajax({
        type: 'POST',
        url: 'backend/function.php?action=media_upload',
        contentType: false,
        processData: false,
        data: form_data,
        dataType: 'json',
        beforeSend: function(response) {
          $('#message_info').html("Uploading your file, please wait...");
        },
        success: function(response) {
          if (response.acc == true) {
            $('#message_info').html("Berhasil");
            $('#selectfile').val('');
            $('#tambah-media').modal('hide');
          } else {
            $('#message_info').html("Gagal Upload");
            $('#selectfile').val('');
          }
        }
      });
    }
  }

  $('#tambah-media').on('hidden.bs.modal', function() {
    $('#file_info').html(" ");
    $('#message_info').html(" ");
    $('#selectfile').val('');
  })

  function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
  }
</script>
<?php

require 'connection.php';

switch ($_GET['action']) {
  case 'download-materi':
    $id_materi = $_GET['id'];
    $getmateri = mysqli_query($conn, "SELECT * FROM materi_pembelajaran WHERE id='$id_materi' AND tgl_hapus IS NULL");
    $data_materi = mysqli_fetch_assoc($getmateri);
    $folder = "../uploads/materi/";
    $filename = $data_materi['file'];
    $file_path = $folder . $filename;
    $ctype = "application/octet-stream";
    if (!empty($file_path) && file_exists($file_path)) { /*check keberadaan file*/
      header("Pragma:public");
      header("Expired:0");
      header("Cache-Control:must-revalidate");
      header("Content-Control:public");
      header("Content-Description: File Transfer");
      header("Content-Type: $ctype");
      header("Content-Disposition:attachment; filename=\"" . basename($file_path) . "\"");
      header("Content-Transfer-Encoding:binary");
      header("Content-Length:" . filesize($file_path));
      flush();
      readfile($file_path);
      exit();
    } else {
      echo "The File does not exist.";
    }
    break;
}

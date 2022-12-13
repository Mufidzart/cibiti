<?php
require 'connection.php';

switch ($_GET['action']) {

    case 'simpan_data_tugas':
        $judul = $_POST['judul-tugas'];
        $jenis = $_POST['jenis-tugas'];
        $deskripsi = $_POST['deskripsi-tugas'];

        $query = mysqli_query($conn, "INSERT INTO arf_tugas_cbt(judul, jenis, deskripsi) VALUES('$judul', '$jenis', '$deskripsi')");
        if ($query) {
            $last_id = $conn->insert_id;
            echo json_encode($last_id);
        } else {
            $data = "Simpan Data Gagal :" . mysqli_error($conn);
            echo json_encode($data);
        }
        break;

    case 'edit_data_tugas':
        $id = $_POST['id-tugas'];
        $judul = $_POST['judul-tugas'];
        $jenis = $_POST['jenis-tugas'];
        $deskripsi = $_POST['deskripsi-tugas'];

        $query = mysqli_query($conn, "UPDATE arf_tugas_cbt SET judul='$judul', jenis='$jenis', deskripsi='$deskripsi' WHERE id='$id'");
        if ($query) {
            $data = [
                "id" => $id,
                "judul" => $judul,
                "jenis" => $jenis,
                "deskripsi" => $deskripsi
            ];
            echo json_encode($data);
        } else {
            $data = "Simpan Data Gagal :" . mysqli_error($conn);
            echo json_encode($data);
        }
        break;
}

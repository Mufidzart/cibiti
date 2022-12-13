<?php
require 'connection.php';

switch ($_GET['action']) {
    case 'simpan_data_tugas':
        $id_staff = "197211012007011009";
        $judul = $_POST['judul-tugas'];
        $mapel = $_POST['mapel-tugas'];
        $jenis = $_POST['jenis-tugas'];
        $deskripsi = $_POST['deskripsi-tugas'];

        $query = mysqli_query($conn, "INSERT INTO arf_tugas_cbt(id_staff, id_mapel, judul, jenis, deskripsi) VALUES('$id_staff','$mapel','$judul', '$jenis', '$deskripsi')");
        if ($query) {
            $last_id = $conn->insert_id;
            $data = [
                "acc" => true,
                "last_id" => $last_id
            ];
            echo json_encode($data);
        } else {
            $data = [
                "acc" => false,
                "errors" => mysqli_error($conn)
            ];
            echo json_encode($data);
        }
        break;

    case 'edit_data_tugas':
        $id = $_POST['id-tugas'];
        $judul = $_POST['judul-tugas'];
        $jenis = $_POST['jenis-tugas'];
        $deskripsi = $_POST['deskripsi-tugas'];
        $today = date("Y-m-d h:i:s");

        $query = mysqli_query($conn, "UPDATE arf_tugas_cbt SET judul='$judul', jenis='$jenis', deskripsi='$deskripsi', tgl_edit='$today' WHERE id='$id'");
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

    case 'hapus_data_tugas';
        $id = $_POST['id-tugas'];
        $today = date("Y-m-d h:i:s");
        $query = mysqli_query($conn, "UPDATE arf_tugas_cbt SET tgl_hapus='$today' WHERE id='$id'");
        if ($query) {
            $data = "Hapus Data Sukses";
            echo json_encode($data);
        } else {
            $data = "Hapus Data Gagal: " . mysqli_error($conn);
            echo json_encode($data);
        }
        break;
}

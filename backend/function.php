<?php
require 'connection.php';

switch ($_GET['action']) {
    case 'simpan_data_tugas':
        $id_staff = "197211012007011009";
        $judul = $_POST['judul-tugas'];
        $mapel = $_POST['mapel-tugas'];
        $jenis = $_POST['jenis-tugas'];
        $deskripsi = $_POST['deskripsi-tugas'];
        // Generate Kode
        $kode = bin2hex(random_bytes(5));
        // Insert data
        $query = mysqli_query($conn, "INSERT INTO arf_tugas_cbt(kode_tugas, id_staff, id_mapel, judul, jenis, deskripsi) VALUES('$kode',$id_staff','$mapel','$judul', '$jenis', '$deskripsi')");
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
        $mapel = $_POST['mapel-tugas'];
        $jenis = $_POST['jenis-tugas'];
        $deskripsi = $_POST['deskripsi-tugas'];
        $today = date("Y-m-d h:i:s");
        $query = mysqli_query($conn, "UPDATE arf_tugas_cbt SET judul='$judul', jenis='$jenis', deskripsi='$deskripsi', tgl_edit='$today' WHERE id='$id'");
        $jenis_tugas = mysqli_query($conn, "SELECT * FROM arf_master_tugas WHERE tgl_hapus IS NULL");
        $html_jenis_tugas = '';
        while ($row = mysqli_fetch_assoc($jenis_tugas)) {
            $select = ($jenis == $row['jenis_tugas']) ? "selected" : "";
            $html_jenis_tugas .= '<option value="' . $row['jenis_tugas'] . '" ' . $select . '>' . $row['jenis_tugas'] . '</option>';
        }
        $getmapel = mysqli_query($conn, "SELECT distinct am.id,am.nama_mapel FROM arf_guru_mapel agm JOIN arf_mapel am ON am.id=agm.id_mapel WHERE agm.id_staf='197211012007011009' AND agm.id_thajaran=4");
        $html_mapel = '';
        while ($row = mysqli_fetch_assoc($getmapel)) {
            $select = ($mapel == $row['id']) ? "selected" : "";
            $html_mapel .= '<option value="' . $row['id'] . '" ' . $select . '>' . $row['nama_mapel'] . '</option>';
        }
        if ($query) {
            $data = [
                "id" => $id,
                "judul" => $judul,
                "jenis" => $jenis,
                "deskripsi" => $deskripsi,
                "jenis_tugas" => $html_jenis_tugas,
                "mapel" => $html_mapel
            ];
            echo json_encode($data);
            die;
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

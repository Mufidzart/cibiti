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
        $kode = strtoupper(bin2hex(random_bytes(3)));
        // Insert data
        $query = mysqli_query($conn, "INSERT INTO arf_tugas_cbt(kode_tugas, id_staff, id_mapel, judul, jenis, deskripsi) VALUES('$kode','$id_staff','$mapel','$judul', '$jenis', '$deskripsi')");
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

    case 'simpan_data_soal':
        // Validation
        $data['errors'] = [];
        $data['success'] = [];
        if (empty($_POST['pertanyaan'])) {
            $validation = ["input" => "pertanyaan", "message" => "Pertanyaan tidak boleh kosong."];
            array_push($data['errors'], $validation);
        } else {
            array_push($data['success'], "pertanyaan");
        }
        if (empty($_POST['radio-pilihan'])) {
            $validation = ["input" => "radio-pilihan", "message" => "Pilih salahsatu pilihan sebagai kunci jawaban."];
            array_push($data['errors'], $validation);
        } else {
            array_push($data['success'], "radio-pilihan");
        }
        if (empty($_POST['pilihan-1'])) {
            $validation = ["input" => "pilihan-1", "message" => "Pilihan ke-1 tidak boleh kosong."];
            array_push($data['errors'], $validation);
        } else {
            array_push($data['success'], "pilihan-1");
        }
        if (empty($_POST['pilihan-2'])) {
            $validation = ["input" => "pilihan-2", "message" => "Pilihan ke-2 tidak boleh kosong."];
            array_push($data['errors'], $validation);
        } else {
            array_push($data['success'], "pilihan-2");
        }
        if (empty($_POST['pilihan-3'])) {
            $validation = ["input" => "pilihan-3", "message" => "Pilihan ke-3 tidak boleh kosong."];
            array_push($data['errors'], $validation);
        } else {
            array_push($data['success'], "pilihan-3");
        }
        if (empty($_POST['pilihan-4'])) {
            $validation = ["input" => "pilihan-4", "message" => "Pilihan ke-4 tidak boleh kosong."];
            array_push($data['errors'], $validation);
        } else {
            array_push($data['success'], "pilihan-4");
        }
        // End Validation
        if (!empty($data['errors'])) {
            $data['acc'] = false;
            echo json_encode($data);
        } else {
            // Inputan Soal
            $id_staff = "197211012007011009";
            $id_mapel = $_POST['id-mapel-soal'];
            $kode_tugas = $_POST['kode-tugas-soal'];
            $tipe_soal = $_POST['tipe-soal'];
            $pertanyaan = $_POST['pertanyaan'];
            // End Inputan Soal
            // Input Soal
            $query = mysqli_query($conn, "INSERT INTO arf_soal(id_staff, id_mapel, kode_tugas, tipe_soal, pertanyaan) VALUES('$id_staff','$id_mapel','$kode_tugas','$tipe_soal', '$pertanyaan')");
            $last_id = $conn->insert_id;
            // End Input Soal
            // Inputan Kunci Jawaban
            if ($tipe_soal = "Pilihan Ganda") {
                $radio_pilih = $_POST['radio-pilihan'];
                $pilihan_1 = $_POST['pilihan-1'];
                $kunci_pilihan_1 = ($radio_pilih == 1) ? 1 : 0;
                $pilihan_2 = $_POST['pilihan-2'];
                $kunci_pilihan_2 = ($radio_pilih == 2) ? 1 : 0;
                $pilihan_3 = $_POST['pilihan-3'];
                $kunci_pilihan_3 = ($radio_pilih == 3) ? 1 : 0;
                $pilihan_4 = $_POST['pilihan-4'];
                $kunci_pilihan_4 = ($radio_pilih == 4) ? 1 : 0;
                $query = mysqli_query($conn, "INSERT INTO arf_tugas_cbt(kode_tugas, id_staff, id_mapel, judul, jenis, deskripsi) VALUES('$kode','$id_staff','$mapel','$judul', '$jenis', '$deskripsi')");
            }
            // End Inputan Kunci Jawaban
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
        }

        break;
}

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
  <div class="portlet-body">
    <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
      <thead>
        <tr>
          <th>NO</th>
          <th>NIS</th>
          <th>NAMA</th>
          <th>KELAS</th>
          <th>NILAI</th>
          <!-- <th>TUGAS AWAL</th>
          <th>REMIDI 1</th>
          <th>REMIDI 2</th> -->
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        while ($row = mysqli_fetch_assoc($getsiswa)) :
          $nis = $row['nis'];
          $id_kelas_induk = $row['id_kelas_induk'];
          if ($id_kelas_induk == 1) {
            $grade = "X";
          } elseif ($id_kelas_induk == 2) {
            $grade = "XI";
          } elseif ($id_kelas_induk == 3) {
            $grade = "XII";
          }
          $gethasilawal = mysqli_query($conn, "SELECT * FROM proses_ujian pj JOIN tugas_penugasan tp ON tp.id=pj.id_tugas_penugasan WHERE pj.id_siswa='$nis' AND tp.id_penugasan='$id_penugasan' AND tp.sub_tugas='Tugas Awal'");
          $gethasilrem1 = mysqli_query($conn, "SELECT * FROM proses_ujian pj JOIN tugas_penugasan tp ON tp.id=pj.id_tugas_penugasan WHERE pj.id_siswa='$nis' AND tp.id_penugasan='$id_penugasan' AND tp.sub_tugas='Remidi 1'");
          $gethasilrem2 = mysqli_query($conn, "SELECT * FROM proses_ujian pj JOIN tugas_penugasan tp ON tp.id=pj.id_tugas_penugasan WHERE pj.id_siswa='$nis' AND tp.id_penugasan='$id_penugasan' AND tp.sub_tugas='Remidi 2'");
          if ($gethasilawal->num_rows == 0) {
            $nilai_awal =  "Belum Mengerjakan";
          } else {
            $dataprosesawal = mysqli_fetch_assoc($gethasilawal);
            $nilai_awal =  $dataprosesawal['nilai'];
          }
          if ($gethasilrem1->num_rows == 0) {
            $nilairem1 =  "0";
          } else {
            $dataprosesrem1 = mysqli_fetch_assoc($gethasilrem1);
            $nilairem1 =  $dataprosesrem1['nilai'];
          }
          if ($gethasilrem2->num_rows == 0) {
            $nilairem2 =  "0";
          } else {
            $dataprosesrem2 = mysqli_fetch_assoc($gethasilrem2);
            $nilairem2 =  $dataprosesrem2['nilai'];
          }
        ?>
          <tr>
            <td><?= $no ?></td>
            <td><?= $nis ?></td>
            <td><?= $row['nama_siswa'] ?></td>
            <td><?= $grade . " " . $row['nama_kelas'] ?></td>
            <td><?= $nilai_awal ?></td>
            <!-- <td><?= $nilairem1 ?></td>
            <td><?= $nilairem2 ?></td> -->
          </tr>
        <?php $no++;
        endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
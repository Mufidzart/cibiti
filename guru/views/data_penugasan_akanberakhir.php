<?php
if ($getpenugasan->num_rows == 0) {
?>
  <div class="alert alert-info" style="margin-left:30px;">
    <a href="javascript:;">
      Tidak ada penugasan!
    </a>
  </div>
  <?php
} else {
  while ($row = mysqli_fetch_assoc($getpenugasan)) :
    $id_penugasan = $row['id'];
    $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_penugasan='$id_penugasan' AND tgl_hapus IS NULL");
    while ($tugas = mysqli_fetch_assoc($get_tugas_penugasan)) :
      $pecahtgl = explode(" ", $tugas['batas_tugas']);
      $tgl_selesai = date("d-m-Y", strtotime($pecahtgl[0]));
      $jam_selesai = date("H:i", strtotime($pecahtgl[1]));
  ?>
      <?php if ($datenow <= $tugas['batas_tugas']) : ?>
        <div class="alert alert-info" style="margin-left:30px;">
          <a href="javascript:;">
            <b style="margin-left: -10px;"><?= $tgl_selesai . ", " . $jam_selesai ?> WIB</b><br>
            (<?= $tugas['sub_tugas'] ?>) <?= $row['judul'] ?>
          </a>
        </div>
      <?php endif; ?>
<?php
    endwhile;
  endwhile;
}
?>
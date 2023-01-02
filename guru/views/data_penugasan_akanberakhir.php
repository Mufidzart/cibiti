<?php
if ($getpenugasan->num_rows == 0) {
?>
  <div class="alert alert-info" style="margin-left:30px;">
    <a href="javascript:;">
      Tidak ada tugas!
    </a>
  </div>
  <?php
} else {
  while ($row = mysqli_fetch_assoc($getpenugasan)) {
    $pecahtgl = explode(" ", $row['waktu_selesai']);
    $tgl_selesai = date("d-m-Y", strtotime($pecahtgl[0]));
    $jam_selesai = date("H:i", strtotime($pecahtgl[1]));
  ?>
    <?php if ($datenow <= $row['waktu_selesai']) : ?>
      <div class="alert alert-info" style="margin-left:30px;">
        <a href="javascript:;">
          <b style="margin-left: -10px;"><?= $tgl_selesai . ", " . $jam_selesai ?> WIB</b><br>
          (<?= $row['kode_tugas'] ?>) <?= $row['judul'] ?>
        </a>
      </div>
    <?php endif; ?>
<?php
  }
}
?>
<?php if ($getkelasmapel->num_rows == 0) : ?>
  <div class="row">
    <div class="col-md-12 text-center" style="opacity: 0.5;">
      <img src="assets/images/no-content.png" alt="No Content">
      <h3>Belum ada kelas di tahun ajaran ini. Silahkan pilih tahun ajaran lain.</h3>
    </div>
  </div>
<?php else : ?>
  <div class="row widget-row">
    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
      <?php
      $arf_thajaran = mysqli_query($conn, "SELECT * FROM arf_thajaran WHERE id='$id_thajaran' AND publish='yes'");
      $tahun = mysqli_fetch_assoc($arf_thajaran);
      if ($semester == 1) {
        $sem = "Gasal";
      } else {
        $sem = "Genap";
      }
      ?>
      <h1 class="widget-thumb-heading" style="font-size: medium;">Tahun Ajaran <?= $tahun['tahun_pelajaran'] . " - " . $sem ?></h1>
      <div class="widget-thumb-wrap">
        <?php
        $colorbg = ["bg-red", "bg-blue", "bg-green", "bg-red", "bg-blue", "bg-green", "bg-red", "bg-blue", "bg-green", "bg-red"];
        $i = 0;
        while ($datakelas = mysqli_fetch_assoc($getkelasmapel)) :
          $no = substr($i, -1);
          $bg = $colorbg[$no];
          if ($datakelas['parent_id'] == 1) {
            $grade = "X";
          } elseif ($datakelas['parent_id'] == 2) {
            $grade = "XI";
          } elseif ($datakelas['parent_id'] == 3) {
            $grade = "XII";
          }
          $kelas = $grade . " " . $datakelas['nama_kelas'];
          $id_kelas = $datakelas['id_kelas'];
          $id_subkelas = $datakelas['id_subkelas'];
          $getsiswa = $conn->query("SELECT * FROM arf_siswa_kelashistory WHERE id_kelas_induk=$id_kelas AND id_kelas=$id_subkelas AND id_thajaran=$id_thajaran AND id_semester=$semester");
          $countsiswa = $getsiswa->num_rows;
        ?>
          <a href="detail_kelas.php?kelas=<?= $id_kelas ?>&subkelas=<?= $id_subkelas ?>">
            <div class="col-md-3">
              <!-- BEGIN WIDGET THUMB -->
              <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading"><?= $datakelas['nama_mapel'] ?></h4>
                <div class="widget-thumb-wrap">
                  <i class="widget-thumb-icon <?= $bg ?> icon-layers" style="margin-top: 10px;"></i>
                  <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle"><?= $kelas ?></span>
                    <span class="widget-thumb-body-stat counter" data-counter="counterup" data-value="<?= $countsiswa ?>"><?= $countsiswa ?></span> Siswa
                  </div>
                </div>
              </div>
              <!-- END WIDGET THUMB -->
            </div>
          </a>
        <?php
          $i++;
        endwhile; ?>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('.counter').counterUp();
    });
  </script>
<?php endif; ?>
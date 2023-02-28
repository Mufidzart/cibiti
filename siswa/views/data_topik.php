<div class="card mb-5 mb-xl-10">
  <div class="card-header cursor-pointer">
    <h3 class="card-title fw-bolder text-dark">Topik Pembelajaran</h3>
    <div class="card-toolbar">
      <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
        <span class="svg-icon svg-icon-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000" />
              <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
              <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
              <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3" />
            </g>
          </svg>
        </span>
      </button>
    </div>
  </div>
  <div class="card-body">
    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px" style="max-height: 500px;">
      <?php
      $no = $gettopik->num_rows;
      $nis = $_SESSION['username'];
      while ($topik = mysqli_fetch_assoc($gettopik)) : ?>
        <?php
        $id_topik = $topik['id'];
        $tgl_input = new DateTime(date("Y-m-d", strtotime($topik['tgl_input'])));
        $today = new DateTime(date("Y-m-d"));
        $interval = $tgl_input->diff($today);
        $selisih = $interval->format('%a');
        if ($selisih != 0) {
          $tgl = tgl_indo(date("d-m-Y", strtotime($topik['tgl_input'])));
          $jam = date("H:i", strtotime($topik['tgl_input']));
          $tanggal = $tgl . ", " . $jam . "WIB";
        } else {
          $tanggal = humanize($topik['tgl_input']);
        }
        ?>
        <div class="d-flex justify-content-start mb-10">
          <div class="d-flex flex-column align-items-start">
            <div class="p-5 rounded bg-light-info text-dark fw-bold text-start" data-kt-element="message-text">
              <h3>Topik Ke <?= $no . ": " . $topik['judul'] ?></h3>
              <p><?= $topik['deskripsi'] ?></p>
              <!-- Materi -->
              <?php
              $no = 1;
              $getmateri = mysqli_query($conn, "SELECT * FROM materi_pembelajaran WHERE id_topik='$id_topik' AND tgl_hapus IS NULL");
              while ($materi = mysqli_fetch_assoc($getmateri)) :
                $id_materi = $materi['id'];
              ?>
                <div class="row">
                  <div class="col-md-12 my-2">
                    <a class="btn btn-flex btn-outline btn-outline-dashed btn-outline-warning btn-active-light-warning px-6 lihat-materi" data-id="<?= $id_materi ?>">
                      <span class=""><i class="bi bi-file-earmark-text text-warning fs-1"></i></span>
                      <span class="d-flex flex-column align-items-start ms-2">
                        <span class="fs-3 fw-bolder">Materi <?= $no . " : " . $materi['judul'] ?></span>
                      </span>
                    </a>
                  </div>
                </div>
              <?php $no++;
              endwhile; ?>
              <!-- End Materi -->
              <!-- Penugasan -->
              <?php
              $get_tugas_penugasan = mysqli_query($conn, "SELECT * FROM tugas_penugasan WHERE id_topik='$id_topik' AND tgl_hapus IS NULL");
              while ($tugas = mysqli_fetch_assoc($get_tugas_penugasan)) :
                $id_tugas_penugasan = $tugas['id'];
                $getprosesujian =  $conn->query("SELECT * FROM proses_ujian WHERE id_siswa='$nis' AND id_tugas_penugasan=$id_tugas_penugasan");
                $dataprosesujian = mysqli_fetch_assoc($getprosesujian);
                $status_ujian = "";
                $status_penilaian = "";
                if ($getprosesujian->num_rows !== 0) {
                  if (empty($dataprosesujian['selesai_ujian'])) {
                    $durasi = $tugas['durasi_tugas'];
                    $mulai_ujian = $dataprosesujian['mulai_ujian'];
                    $jam_mulai = new DateTime($mulai_ujian);
                    $jam_berakhir = (new DateTime($mulai_ujian))->modify('+' . $durasi . " minutes");
                    $jam_sekarang = new DateTime(date("Y-m-d H:i:s"));
                    if ($jam_sekarang <= $jam_berakhir) {
                      $status_ujian = "<span class='badge badge-light-info fs-7 my-3'>Sedang dikerjakan</span>";
                    }
                  } else {
                    $nilai = $dataprosesujian['nilai'];
                    if (!empty($nilai)) {
                      $status_ujian = "<span class='badge badge-light-success fs-7 my-3'>Sudah dikerjakan</span>";
                    } else {
                      $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                    }

                    $id_mapel = $topik['id_mapel'];
                    $getmapel = $conn->query("SELECT * FROM arf_mapel WHERE id=$id_mapel");
                    $datamapel = mysqli_fetch_assoc($getmapel);
                    if ($nilai < $datamapel['kb_pengetahuan']) {
                      $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini.</span>";
                    } else {
                      $status_penilaian = "<span class='badge badge-light-success fs-7 my-3'>Anda lulus di tugas ini.</span>";
                    }
                  }
                } else {
                  $batas = new DateTime(date("Y-m-d H:i", strtotime($tugas['batas_tugas'])));
                  $now = new DateTime(date("Y-m-d H:i"));
                  if ($now > $batas) {
                    $status_ujian = "<span class='badge badge-light-danger fs-7 my-3'>Terlewat</span>";
                    $status_penilaian = "<span class='badge badge-light-danger fs-7 my-3'>Anda tidak lulus di tugas ini.</span>";
                  }
                }
                $badge = $status_ujian . " " . $status_penilaian;
              ?>
                <div class="row">
                  <div class="col-md-12 my-2">
                    <a href="ujian.php?tgs=<?= $id_tugas_penugasan ?>" class="btn btn-flex btn-outline btn-outline-dashed btn-outline-success btn-active-light-success px-6" data-kode="<?= $tugas['jenis_tugas'] ?>">
                      <span class=""><i class="bi bi-file-earmark-font-fill text-success fs-1"></i></span>
                      <span class="d-flex flex-column align-items-start ms-2">
                        <span class="fs-3 fw-bolder"><?= $tugas['jenis_tugas'] ?></span>
                        <span class="fs-7">klik untuk mengerjakan</span>
                      </span>
                    </a>
                  </div>
                </div>
                <?= $badge ?>
              <?php endwhile; ?>
              <!-- End Penugasan -->
            </div>
          </div>
        </div>
      <?php $no--;
      endwhile; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-lihat-materi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered mw-650px">
    <div class="modal-content">
      <form class="form" action="#" id="kt_modal_add_event_form">
        <div class="modal-header">
          <h2 class="fw-bolder" data-kt-calendar="title">Lihat Materi</h2>
          <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
            <span class="svg-icon svg-icon-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
              </svg>
            </span>
          </div>
        </div>
        <div class="modal-body py-10 px-lg-17" id="show_materi">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-kt-scrolltop="true" data-bs-dismiss="modal">
            <span class="indicator-label">Tutup</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.lihat-materi').on('click', function(e) {
      var id_materi = $(this).attr("data-id");
      $.ajax({
        url: 'backend/function.php?action=get_data&get=lihat_materi',
        type: 'post',
        data: {
          id_materi: id_materi,
        },
        success: function(data) {
          if (id_materi) {
            $('#show_materi').html(data);
            $('#modal-lihat-materi').modal('show');
          }
        }
      });
    });
  });
</script>
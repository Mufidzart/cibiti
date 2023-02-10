<?php
require('../../backend/connection.php');
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id_penugasan = $_GET['id'];
$encode = base64_encode($id_penugasan);
$tipe_soal = $_GET['ts'];
$jumlah_soal = $_GET['js'];
$jumlah_jawaban = $_GET['jj'];
$getpenugasan = mysqli_query($conn, "SELECT * FROM arf_tugas_cbt WHERE id='$id_penugasan' AND tgl_hapus IS NULL");
$tugas = mysqli_fetch_assoc($getpenugasan);
$kode_tugas = $tugas['kode_tugas'];
$judul_tugas = $tugas['judul'];
$id_mapel = $tugas['id_mapel'];
$getmapel = mysqli_query($conn, "SELECT * FROM arf_mapel WHERE id='$id_mapel'");
$datamapel = mysqli_fetch_assoc($getmapel);
$mapel = $datamapel['nama_mapel'];
$getstaf = mysqli_query($conn, "SELECT * FROM arf_staf WHERE nip='$session_id_staf'");
$datastaf = mysqli_fetch_assoc($getstaf);
$staf = $datastaf['nama_lengkap'];
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Kode Tugas: ' . $kode_tugas . "\n" . 'Judul Tugas:  ' . $judul_tugas . "\n" . 'Mata Pelajaran: ' . $mapel . "\n" . 'Guru: ' . $staf);
$sheet->setCellValue('C1', 'REF:' . $encode);
$sheet->setCellValue('C2', 'TYPE:' . $tipe_soal);
$sheet->getStyle('A1')->getAlignment()
  ->setWrapText(true)
  ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A1')->getFill()
  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
  ->getStartColor('FFC000')
  ->setARGB('FFC000');;
$sheet->mergeCells('A1:B4');

$sheet->getProtection()->setSheet(true);
$spreadsheet->getDefaultStyle()->getProtection()->setLocked(false);
$sheet->getStyle('A1:C6')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

$sheet->setCellValue('A7', 'No')
  ->setCellValue('B7', 'Soal');
$sheet->getStyle('A7:B7')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
$sheet->getColumnDimension('A')->setWidth(30, 'pt');
$sheet->getColumnDimension('B')->setWidth(300, 'pt');
$sheet->getStyle('7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Setting Jumlah Jawaban
$char = "C";
$array_pilihan_jawaban = [];
for ($i = 1; $i <= $jumlah_jawaban; $i++) {
  $col = $char . "7";
  $jawaban = 'Jawaban ' . $i;
  $sheet->setCellValue($col, $jawaban);
  $sheet->getColumnDimension($char)->setAutoSize(TRUE);
  $sheet->getStyle($col)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
  array_push($array_pilihan_jawaban, $jawaban);
  $char++;
}
// End Setting Jumlah Jawaban
// Set Posisi Kolom Kunci Jawaban
$char_kunci = $char . "7";
$new_char_kunci = $char;
$sheet->setCellValue($char_kunci, 'Kunci Jawaban');
$sheet->getColumnDimension($char)->setAutoSize(TRUE);
$sheet->getStyle($char_kunci)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
// End Posisi Kolom Kunci Jawaban


$pilihan = implode(", ", $array_pilihan_jawaban);

// Setting Jumlah Soal
$row = 8;
for ($i = 1; $i <= $jumlah_soal; $i++) {
  $col_no = "A" . $row;
  $col_kunci = $new_char_kunci . $row;
  $sheet->setCellValue($col_no, $i);
  $sheet->getStyle($col_no)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
  $sheet->getStyle($col_no)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  // Setting Pilihan Kunci Jawaban
  /**
   * Set the 'drop down list' validation on C3.
   */
  $validation = $sheet->getCell($col_kunci)->getDataValidation();
  /**
   * Since the validation is for a 'drop down list',
   * set the validation type to 'List'.
   */
  $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
  $validation->setFormula1('"' . $pilihan . '"');
  /**
   * Do not allow empty value.
   */
  $validation->setAllowBlank(false);
  /**
   * Show drop down.
   */
  $validation->setShowDropDown(true);
  /**
   * Display a cell 'note' about the
   * 'drop down list' validation.
   */
  $validation->setShowInputMessage(true);
  /**
   * Set the 'note' title.
   */
  $validation->setPromptTitle('Note');
  /**
   * Describe the note.
   */
  $validation->setPrompt('Pilih salah satu kunci jawaban.');
  /**
   * Show error message if the data entered is invalid.
   */
  $validation->setShowErrorMessage(true);
  /**
   * Do not allow any other data to be entered
   * by setting the style to 'Stop'.
   */
  $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);

  /**
   * Set descriptive error title.
   */
  $validation->setErrorTitle('Peringatan');

  /**
   * Set the error message.
   */
  $validation->setError('Pilih salah satu dari list yang ada.');

  //End Setting Pilihan Kunci Jawaban

  $row++;
}
// End Setting Jumlah Soal


$writer = new Xlsx($spreadsheet);
$file_name = "Testing.xlsx";

$writer->save($file_name);

header('Content-Type: application/x-www-form-urlencoded');

header('Content-Transfer-Encoding: Binary');

header("Content-disposition: attachment; filename=\"" . $file_name . "\"");

readfile($file_name);

unlink($file_name);

exit;

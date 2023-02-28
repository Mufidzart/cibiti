<?php
require '../../../config/lms_connection.php';
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tipe_soal = $_GET['ts'];
$jumlah_soal = $_GET['js'];
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Template Soal Essay');
$sheet->getStyle('A1')->getAlignment()
  ->setWrapText(true)
  ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A1')->getFill()
  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
  ->getStartColor('FFC000')
  ->setARGB('FFC000');
$sheet->mergeCells('A1:B2');

$sheet->getProtection()->setSheet(true);
$spreadsheet->getDefaultStyle()->getProtection()->setLocked(false);
$sheet->getStyle('A1:B3')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

$sheet->setCellValue('A4', 'No')
  ->setCellValue('B4', 'Soal');
$sheet->getStyle('A4:B4')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
$sheet->getColumnDimension('A')->setWidth(30, 'pt');
$sheet->getColumnDimension('B')->setWidth(300, 'pt');
$sheet->getStyle('4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// Setting Jumlah Soal
$char = "C";
$row = 5;
for ($i = 1; $i <= $jumlah_soal; $i++) {
  $col_no = "A" . $row;
  $col_kunci = $char . $row;
  // Setting Nomor
  $sheet->setCellValue($col_no, $i);
  $sheet->getColumnDimension('A')->setAutoSize(TRUE);
  $sheet->getStyle($col_no)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
  $sheet->getStyle($col_no)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
  $sheet->getStyle($col_no)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  // End Setting Nomor

  $row++;
}
// End Setting Jumlah Soal


$writer = new Xlsx($spreadsheet);
$file_name = "Template Soal Essay.xlsx";

$writer->save($file_name);

header('Content-Type: application/x-www-form-urlencoded');

header('Content-Transfer-Encoding: Binary');

header("Content-disposition: attachment; filename=\"" . $file_name . "\"");

readfile($file_name);

unlink($file_name);

exit;

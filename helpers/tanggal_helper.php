<?php
date_default_timezone_set('Asia/Jakarta');
function get_hari($date)
{
  $hari = date("D", strtotime($date));

  switch ($hari) {
    case 'Sun':
      $hari_ini = "Minggu";
      break;

    case 'Mon':
      $hari_ini = "Senin";
      break;

    case 'Tue':
      $hari_ini = "Selasa";
      break;

    case 'Wed':
      $hari_ini = "Rabu";
      break;

    case 'Thu':
      $hari_ini = "Kamis";
      break;

    case 'Fri':
      $hari_ini = "Jumat";
      break;

    case 'Sat':
      $hari_ini = "Sabtu";
      break;

    default:
      $hari_ini = "Tidak di ketahui";
      break;
  }

  return $hari_ini;
}

function get_hari_tanggal($date)
{
  return get_hari($date) . ", " . tgl_indo(date("d-m-Y", strtotime($date)));
}

function tgl_indo($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun

  return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
}

function tgl_MdY($date)
{
  $date = date_create_from_format("M d Y H:i:s:A", $date);
  $date = date_format($date, "d-m-Y");
  return get_hari_tanggal($date);
}

function tgl_MdYW($date, $format = "d-m-Y")
{
  $date = date_create_from_format("M d Y H:i:s:A", $date);
  $date = date_format($date, $format);
  return $date;
}

function countdown($pr)
{
  $periods = array(
    365 * 24 * 60 * 60 => 'tahun',
    30 * 24 * 60 * 60 => 'bulan',
    7 * 24 * 60 * 60 => 'minggu',
    24 * 60 * 60 => 'hari',
    60 * 60 => 'jam',
    60 => 'menit',
    1 => 'detik'
  );

  $arithmetic = strtotime(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 8)) - $pr;
  $result = array();
  if ($arithmetic < 5) {
    $result = 'kurang dari 5 detik yang lalu';
  } else {
    $stop = 0;
    foreach ($periods as $period => $unit) {
      if ($stop >= 6 || ($stop > 0 && $period < 60)) break;
      $for = floor($arithmetic / $period);
      if ($for > 0) {
        $result[] = $for . ' ' . $unit;
        $arithmetic -= $for * $period;
        $stop++;
      } elseif ($stop > 0) $stop++;
    }
    $result = implode(' ', $result) . ' yang lalu';
  }
  return $result;
}

function humanize($datetime)
{
  // Enter your code here, enjoy!
  $now  = IntlCalendar::fromDateTime(date("Y-m-d H:i:s"));
  $time = IntlCalendar::fromDateTime(date("Y-m-d H:i:s", strtotime($datetime)))->getTime();

  $years   = $now->fieldDifference($time, IntlCalendar::FIELD_YEAR);
  $months  = $now->fieldDifference($time, IntlCalendar::FIELD_MONTH);
  $days    = $now->fieldDifference($time, IntlCalendar::FIELD_DAY_OF_YEAR);
  $hours   = $now->fieldDifference($time, IntlCalendar::FIELD_HOUR_OF_DAY);
  $minutes = $now->fieldDifference($time, IntlCalendar::FIELD_MINUTE);

  $phrase = null;

  if ($years !== 0) {
    $phrase = abs($years) . " Tahun";
    $before = $years < 0;
  } elseif ($months !== 0) {
    $phrase = abs($months) . " Bulan";
    $before = $months < 0;
  } elseif ($days !== 0 && (abs($days) >= 7)) {
    $weeks  = ceil($days / 7);
    $phrase = abs($weeks) . " Minggu";
    $before = $days < 0;
  } elseif ($days !== 0) {
    $before = $days < 0;

    // Yesterday/Tomorrow special cases
    if (abs($days) === 1) {
      $phrase = $before ? "Kemarin" : "Besok";
    }

    $phrase = abs($days) . " Hari";
  } elseif ($hours !== 0) {
    $phrase = abs($hours) . " Jam";
    $before = $hours < 0;
  } elseif ($minutes !== 0) {
    $phrase = abs($minutes) . " Menit";
    $before = $minutes < 0;
  } else {
    $phrase = "Beberapa detik yang lalu";
  }
  if (!empty($before)) {
    $return = $phrase . " yang lalu";
  } else {
    $return = $phrase;
  }
  return $return;
}

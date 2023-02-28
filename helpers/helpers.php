<?php
date_default_timezone_set('Asia/Jakarta');

function array_split($array, $pieces = 2)
{
  if ($pieces < 2)
    return array($array);
  $newCount = ceil(count($array) / $pieces);
  $a = array_slice($array, 0, $newCount);
  $b = array_split(array_slice($array, $newCount), $pieces - 1);
  return array_merge(array($a), $b);
}


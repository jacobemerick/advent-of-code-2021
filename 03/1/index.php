<?php

$gamma = '';
$epsilon = '';

$zeros = [];
$ones = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($number = fgets($handle))) {
  if (count($zeros) === 0) {
    $zeros = array_fill(0, strlen($number) - 1, 0);
    $ones = array_fill(0, strlen($number) - 1, 0);
  }

  $bits = str_split($number);
  foreach ($bits as $pos => $bit) {
    if ($bit === '0') {
      $zeros[$pos]++;
    }
    if ($bit === '1') {
      $ones[$pos]++;
    }
  }
}

foreach ($zeros as $pos => $count) {
  if ($zeros[$pos] > $ones[$pos]) {
    $gamma .= '0';
    $epsilon .= '1';
  } else if ($ones[$pos] > $zeros[$pos]) {
    $gamma .= '1';
    $epsilon .= '0';
  } else {
    throw new Exception('Oh noes');
  }
}

echo bindec($gamma) * bindec($epsilon);

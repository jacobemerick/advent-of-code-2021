<?php

$easyDigits = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  [ $input, $output ] = explode(' | ', $line);
  $signals = explode(' ', $output);
  foreach ($signals as $signal) {
    if (
      (strlen($signal) === 2) || // one
      (strlen($signal) === 4) || // four
      (strlen($signal) === 3) || // seven
      (strlen($signal) === 7) // eight
    ) {
      $easyDigits++;
    }
  }
}

echo $easyDigits;

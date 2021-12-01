<?php

$deeper = 0;
$holder = [];
$window = 3;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($current = fgets($handle))) {
  $holder[] = $current;
  if ($window > 0) {
    $window--;
    continue;
  }
  if ($holder[3] > $holder[0]) {
    $deeper++;
  }
  array_shift($holder);
}

echo $deeper;

<?php

$deeper = 0;
$previous = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($current = fgets($handle))) {
  if ($previous === 0) {
    $previous = $current;
    continue;
  }
  if ($current > $previous) {
    $deeper++;
  }
  $previous = $current;
}

echo $deeper;

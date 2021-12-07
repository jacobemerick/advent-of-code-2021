<?php

$positions = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $positions = explode(',', $line);
  $positions = array_map(fn($val) => (int) $val, $positions);
  sort($positions);
}

$count = count($positions);

$median = ($count % 1) ?
  $positions[floor($count / 2)] :
  ($positions[floor($count / 2) - 1] + $positions[floor($count / 2)]) / 2;

echo array_reduce(
  $positions,
  fn($fuel, $value) => $fuel + abs($value - $median),
  0,
);

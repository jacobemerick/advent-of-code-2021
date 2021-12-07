<?php

$positions = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $positions = explode(',', $line);
  $positions = array_map(fn($val) => (int) $val, $positions);
}

$start = min($positions);
$end = max($positions);

$fuelTracker = [];

for ($i = $start; $i <= $end; $i++) {
  $fuelTracker[$i] = array_reduce(
    $positions,
    fn($fuel, $value) => $fuel + abs($value - $i) * (abs($value - $i) + 1) / 2,
    0,
  );
}

echo min($fuelTracker);

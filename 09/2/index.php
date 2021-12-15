<?php

$heightmap = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $heightmap[] = str_split($line);
}

$lowpoints = [];

foreach ($heightmap as $y => $heightrow) {
  foreach ($heightrow as $x => $height) {
    if (
      (!isset($heightmap[$y - 1][$x]) || $heightmap[$y - 1][$x] > $height) &&
      (!isset($heightmap[$y][$x + 1]) || $heightmap[$y][$x + 1] > $height) &&
      (!isset($heightmap[$y + 1][$x]) || $heightmap[$y + 1][$x] > $height) &&
      (!isset($heightmap[$y][$x - 1]) || $heightmap[$y][$x - 1] > $height)
    ) {
      $lowpoints[] = [$y, $x];
    }
  }
}

$basins = [];

function basinSize($y, $x, $size) {
  global $heightmap;

  if (
    !isset($heightmap[$y][$x]) ||
    $heightmap[$y][$x] == 9 ||
    $heightmap[$y][$x] == '.'
  ) {
    return 0;
  }

  $size = 1;

  $heightmap[$y][$x] = '.';

  $size += basinSize($y - 1, $x, $size);
  $size += basinSize($y, $x + 1, $size);
  $size += basinSize($y + 1, $x, $size);
  $size += basinSize($y, $x - 1, $size);
  return $size;
}

foreach ($lowpoints as $dimensions) {
  $basins[] = basinSize($dimensions[0], $dimensions[1], 0);
}

rsort($basins);
echo array_shift($basins) * array_shift($basins) * array_shift($basins);

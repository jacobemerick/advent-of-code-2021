<?php

$heightmap = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $heightmap[] = str_split($line);
}

$risklevel = 0;

foreach ($heightmap as $y => $heightrow) {
  foreach ($heightrow as $x => $height) {
    if (
      (!isset($heightmap[$y - 1][$x]) || $heightmap[$y - 1][$x] > $height) &&
      (!isset($heightmap[$y][$x + 1]) || $heightmap[$y][$x + 1] > $height) &&
      (!isset($heightmap[$y + 1][$x]) || $heightmap[$y + 1][$x] > $height) &&
      (!isset($heightmap[$y][$x - 1]) || $heightmap[$y][$x - 1] > $height)
    ) {
      $risklevel += $height + 1;
    }
  }
}

echo $risklevel;

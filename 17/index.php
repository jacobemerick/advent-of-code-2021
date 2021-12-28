<?php

$input = 'target area: x=20..30, y=-10..-5';

/**
$handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $input = trim($line);
}
 */

preg_match('/^target area: x=(-?\d+)\.\.(-?\d+), y=(-?\d+)\.\.(-?\d+)$/', $input, $matches);

$xMin = (int) $matches[1];
$xMax = (int) $matches[2];
$yMin = (int) $matches[3];
$yMax = (int) $matches[4];

$successfulVelocities = [];

for ($x = 0; $x <= $xMax; $x++) {
  for ($y = $yMin; $y < abs($yMin); $y++) {
    $velocity = [$x, $y];

    $maxY = 0;
    $position = [0, 0];

    while (true) {
      $position[0] += $velocity[0];
      $position[1] += $velocity[1];

      $maxY = max($maxY, $position[1]);

      $velocity[0] = max(0, $velocity[0] - 1); // drag
      $velocity[1]--; // gravity

      if (
        $position[0] >= $xMin &&
        $position[0] <= $xMax &&
        $position[1] >= $yMin &&
        $position[1] <= $yMax
      ) {
        $successfulVelocities[] = [$x, $y, $maxY];
        break;
      }

      if ($position[0] > $xMax) break;
      if ($position[1] < $yMin && $velocity[1] < 0) break;
    }
  }
}

echo array_reduce($successfulVelocities, fn ($highpoint, $velocity) => max($highpoint, $velocity[2]), 0);
// echo count($successfulVelocities);

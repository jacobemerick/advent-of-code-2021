<?php

$dim = 1000;

$diagram = array_fill(0, $dim * $dim, 0);

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  preg_match('/(\d+),(\d+) \-> (\d+),(\d+)/', $line, $matches);

  if ($matches[1] === $matches[3]) {
    $start = min($matches[2], $matches[4]);
    $end = max($matches[2], $matches[4]);

    for ($i = $start; $i <= $end; $i++) {
      $diagram[$matches[1] + $i * $dim]++;
    }

    continue;
  }

  if ($matches[2] === $matches[4]) {
    $start = min($matches[1], $matches[3]);
    $end = max($matches[1], $matches[3]);

    for ($i = $start; $i <= $end; $i++) {
      $diagram[$i + $matches[2] * $dim]++;
    }

    continue;
  }

  $startX = min($matches[1], $matches[3]);
  $startY = min($matches[2], $matches[4]);

  $endX = max($matches[1], $matches[3]);
  $endY = max($matches[2], $matches[4]);

  for ($i = 0; $i <= abs($matches[1] - $matches[3]); $i++) {
    if ($matches[1] < $matches[3]) {
      if ($matches[2] < $matches[4]) {
        $diagram[$matches[1] + $i + ($matches[2] + $i) * $dim]++;
      } else {
        $diagram[$matches[1] + $i + ($matches[2] - $i) * $dim]++;
      }
    } else {
      if ($matches[2] < $matches[4]) {
        $diagram[$matches[1] - $i + ($matches[2] + $i) * $dim]++;
      } else {
        $diagram[$matches[1] - $i + ($matches[2] - $i) * $dim]++;
      }
    }
  }
}

echo count(array_filter($diagram, fn($val) => $val > 1));

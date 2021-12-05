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
  }

  if ($matches[2] === $matches[4]) {
    $start = min($matches[1], $matches[3]);
    $end = max($matches[1], $matches[3]);

    for ($i = $start; $i <= $end; $i++) {
      $diagram[$i + $matches[2] * $dim]++;
    }
  }
}

echo count(array_filter($diagram, fn($val) => $val > 1));

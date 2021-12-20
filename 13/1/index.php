<?php

$coordinates = [];
$directions = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);

  if (empty($line)) continue;

  if (strstr($line, 'fold along')) {
    $directions[] = explode('=', substr($line, 11));
  } else {
    $coordinates[] = explode(',', $line);
  }
}

$maxX = max(array_column($coordinates, 0));
$maxY = max(array_column($coordinates, 1));

$paper = array_fill(
  0,
  $maxY + 1,
  array_fill(
    0,
    $maxX + 1,
    '0',
  ),
);

foreach ($coordinates as $coordinate) {
  $paper[$coordinate[1]][$coordinate[0]] = '1';
}

foreach ($directions as $direction) {
  if ($direction[0] === 'y') {
    for ($i = 1; $i <= $direction[1]; $i++) {
      $rowLength = count($paper[0]);
      for ($x = 0; $x < $rowLength; $x++) {
        if ($paper[$direction[1] + $i][$x] === '1') {
          $paper[$direction[1] - $i][$x] = '1';
        }
      }
    }

    $paper = array_slice($paper, 0, $direction[1]);
  } else {
    for ($i = 1; $i <= $direction[1]; $i++) {
      $colLength = count($paper);
      for ($y = 0; $y < $colLength; $y++) {
        if ($paper[$y][$direction[1] + $i] === '1') {
          $paper[$y][$direction[1] - $i] = '1';
        }
      }
    }

    $paper = array_map(
      fn($row) => array_slice($row, 0, $direction[1]),
      $paper,
    );
  }

  break; // we only do one direction for now
}

echo array_sum(array_map('array_sum', $paper));

<?php

$aim = 0;
$horizontal = 0;
$depth = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($command = fgets($handle))) {
  [$direction, $units] = explode(' ', $command);
  switch ($direction) {
    case 'forward':
      $horizontal+= $units;
      $depth += $aim * $units;
      break;
    case 'up':
      $aim -= $units;
      break;
    case 'down':
      $aim += $units;
      break;
  }
}

echo $horizontal * $depth;

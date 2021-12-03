<?php

$horizontal = 0;
$depth = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($command = fgets($handle))) {
  [$direction, $units] = explode(' ', $command);
  switch ($direction) {
    case 'forward':
      $horizontal+= $units;
      break;
    case 'up':
      $depth -= $units;
      break;
    case 'down':
      $depth += $units;
      break;
  }
}

echo $horizontal * $depth;

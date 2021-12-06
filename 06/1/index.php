<?php

$lanternfish = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $lanternfish = explode(',', $line);
}

for ($day = 0; $day < 80; $day++) {
  $currentLanterns = count($lanternfish);
  for ($i = 0; $i < $currentLanterns; $i++) {
    $newLantern = $lanternfish[$i] - 1;
    if ($newLantern < 0) {
      $newLantern = 6;
      $lanternfish[] = 8;
    }
    $lanternfish[$i] = $newLantern;
  }
}

echo count($lanternfish);

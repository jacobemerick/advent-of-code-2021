<?php

$days = array_fill(0, 9, 0);

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $lanternfish = explode(',', $line);
}

foreach ($lanternfish as $fish) {
  $days[$fish]++;
}

for ($day = 0; $day < 256; $day++) {
  $hatched = array_shift($days);
  $days[] = $hatched;
  $days[6] += $hatched;
}

echo array_sum($days);

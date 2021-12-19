<?php

$connections = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $connections[] = explode('-', $line);
}

// start things off
$tempPaths = [];
foreach ($connections as [$one, $two]) {
  if ($one === 'start') {
    $tempPaths[] = [$one, $two];
  }
  if ($two === 'start') {
    $tempPaths[] = [$two, $one];
  }
}

$finalPaths = [];
while (true) {
  $newPaths = [];
  foreach ($connections as [$one, $two]) {
    foreach ($tempPaths as $path) {
      if (
        end($path) === $one &&
        (strtoupper($two) === $two || !in_array($two, $path))
      ) {
        $newPaths[] = array_merge($path, [$two]);
      }

      if (
        end($path) === $two &&
        (strtoupper($one) === $one || !in_array($one, $path))
      ) {
        $newPaths[] = array_merge($path, [$one]);
      }
    }
  }

  $finalPaths = array_merge($finalPaths, array_filter($newPaths, fn($path) => end($path) === 'end'));
  $tempPaths = array_filter($newPaths, fn($path) => end($path) !== 'end');

  if (empty($tempPaths)) {
    break;
  }
}

echo count($finalPaths);

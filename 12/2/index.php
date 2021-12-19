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

function canVisitCave($path, $cave) {
  if ($cave === 'start') {
    return false;
  }

  if (strtoupper($cave) === $cave) {
    return true;
  }

  $visits = array_count_values($path);

  $hasASmallCaveBeenVisitedTwice = false;
  foreach ($visits as $visitCave => $visitCount) {
    if (
      strtolower($visitCave) === $visitCave &&
      $visitCount === 2
    ) {
      $hasASmallCaveBeenVisitedTwice = true;
    }
  }

  if (
    !in_array($cave, $path) ||
    !$hasASmallCaveBeenVisitedTwice
  ) {
    return true;
  }

  return false;
}

$finalPaths = [];
while (true) {
  $newPaths = [];
  foreach ($connections as [$one, $two]) {
    foreach ($tempPaths as $path) {
      if (
        end($path) === $one &&
        canVisitCave($path, $two)
      ) {
        $newPaths[] = array_merge($path, [$two]);
      }

      if (
        end($path) === $two &&
        canVisitCave($path, $one)
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

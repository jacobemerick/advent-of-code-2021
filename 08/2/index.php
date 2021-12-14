<?php

$totalSignal = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $signals = str_replace(' | ', ' ', $line);
  $signals = explode(' ', $signals);
  $signals = array_map('str_split', $signals);

  $decodedSignals = array_fill(0, count($signals), ' ');

  // first pass
  foreach ($signals as $key => $signal) {
    if (count($signal) === 2) {
      $decodedSignals[$key] = 1;
    }
    if (count($signal) === 4) {
      $decodedSignals[$key] = 4;
    }
    if (count($signal) === 3) {
      $decodedSignals[$key] = 7;
    }
    if (count($signal) === 7) {
      $decodedSignals[$key] = 8;
    }
  }

  // now for the 6-digit signals
  foreach ($signals as $key => $signal) {
    if (count($signal) !== 6) {
      continue;
    }

    $four = array_search(4, $decodedSignals);
    if ($four === false) {
      continue;
    }

    if (empty(array_diff($signals[$four], $signal))) {
      $decodedSignals[$key] = 9;
      continue;
    }

    $one = array_search(1, $decodedSignals);
    if ($one === false) {
      continue;
    }

    if (empty(array_diff($signals[$one], $signal))) {
      $decodedSignals[$key] = 0;
      continue;
    }

    $decodedSignals[$key] = 6;
  }

  // now for the 5-digit signals
  foreach ($signals as $key => $signal) {
    if (count($signal) !== 5) {
      continue;
    }

    $one = array_search(1, $decodedSignals);
    if ($one === false) {
      continue;
    }

    if (empty(array_diff($signals[$one], $signal))) {
      $decodedSignals[$key] = 3;
      continue;
    }

    $six = array_search(6, $decodedSignals);
    if ($six === false) {
      continue;
    }

    if (count(array_diff($signals[$six], $signal)) === 1) {
      $decodedSignals[$key] = 5;
      continue;
    }

    $decodedSignals[$key] = 2;
  }

  $totalSignal += (int) join(array_slice($decodedSignals, 10));
}

echo $totalSignal;

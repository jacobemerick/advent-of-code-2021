<?php

$numbers = [];

$numberedBoards = [];
$markedBoards = [];

$boardCounter = -1;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);

  if (empty($numbers)) {
    $numbers = explode(',', $line);
    continue;
  }

  if (empty($line)) {
    $boardCounter++;
    $numberedBoards[$boardCounter] = [];
    $markedBoards[$boardCounter] = array_fill(0, 25, false);
    continue;
  }

  $numberedBoards[$boardCounter] = array_merge($numberedBoards[$boardCounter], preg_split("/\s+/", $line));
}

function hasBingo($board) {
  for ($i = 0; $i < 5; $i++) {
    // horizontal line
    if (
      $board[$i * 5 + 0] === true &&
      $board[$i * 5 + 1] === true &&
      $board[$i * 5 + 2] === true &&
      $board[$i * 5 + 3] === true &&
      $board[$i * 5 + 4] === true
    ) {
      return true;
    }

    // vertical line
    if (
      $board[$i + 5 * 0] === true &&
      $board[$i + 5 * 1] === true &&
      $board[$i + 5 * 2] === true &&
      $board[$i + 5 * 3] === true &&
      $board[$i + 5 * 4] === true
    ) {
      return true;
    }
  }
  return false;
}

foreach ($numbers as $number) {
  foreach ($numberedBoards as $boardIndex => $board) {
    $foundNumber = array_search($number, $board);
    if ($foundNumber !== false) {
      $markedBoards[$boardIndex][$foundNumber] = true;
    }

    if (!hasBingo($markedBoards[$boardIndex])) {
      continue;
    }

    $unmarkedSum = 0;
    foreach ($markedBoards[$boardIndex] as $markedIndex => $marked) {
      if (!$marked) {
        $unmarkedSum += (int) $numberedBoards[$boardIndex][$markedIndex];
      }
    }

    echo $unmarkedSum * $number;
    break 2;
  }
}

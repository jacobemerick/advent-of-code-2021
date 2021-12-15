<?php

$octopi = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $line = str_split($line);
  $line = array_map(fn ($val) => (int) $val, $line);
  $octopi[] = $line;
}

function step($y, $x) {
  global $octopi, $totalFlashes;

  if (
    !isset($octopi[$y][$x]) ||
    $octopi[$y][$x] === 10
  ) {
    return;
  }

  $octopi[$y][$x]++;

  if ($octopi[$y][$x] === 10) {
    $totalFlashes++;

    step($y - 1, $x - 1);
    step($y - 1, $x);
    step($y - 1, $x + 1);
    step($y, $x - 1);
    step($y, $x + 1);
    step($y + 1, $x - 1);
    step($y + 1, $x);
    step($y + 1, $x + 1);
  }
}

$step = 0;
while (true) {
  $step++;

  foreach ($octopi as $y => $row) {
    foreach ($row as $x => $val) {
      step($y, $x);
    }
  }

  $stepFlashes = 0;
  foreach ($octopi as $y => $row) {
    foreach ($row as $x => $val) {
      if ($octopi[$y][$x] === 10) {
        $stepFlashes++;
        $octopi[$y][$x] = 0;
      }
    }
  }

  if ($stepFlashes === 100) {
    break;
  }
}

echo $step;

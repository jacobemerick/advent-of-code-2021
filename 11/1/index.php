<?php

$octopi = [];
$totalFlashes = 0;

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

for ($i = 0; $i < 100; $i++) {
  foreach ($octopi as $y => $row) {
    foreach ($row as $x => $val) {
      step($y, $x);
    }
  }

  foreach ($octopi as $y => $row) {
    foreach ($row as $x => $val) {
      if ($octopi[$y][$x] === 10) {
        $octopi[$y][$x] = 0;
      }
    }
  }
}

/*
foreach ($octopi as $y => $row) {
  foreach ($row as $x => $val) {
    echo $val;
  }
  echo PHP_EOL;
}

echo PHP_EOL;
 */

echo $totalFlashes;

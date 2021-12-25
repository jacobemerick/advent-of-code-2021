<?php

$caveTile = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $caveTile[] = array_map(fn($val) => (int) $val, str_split(trim($line)));
}

$caveMap = [];
for ($y = 0; $y < 5; $y++) {
  for ($x = 0; $x < 5; $x++) {
    for ($tileY = 0; $tileY < count($caveTile); $tileY++) {
      for ($tileX = 0; $tileX < count($caveTile[0]); $tileX++) {
        $newValue = ($caveTile[$tileY][$tileX] + $y + $x) % 9;
        if ($newValue === 0) $newValue = 9;
        $caveMap[$tileY + count($caveTile) * $y][$tileX + count($caveTile[0]) * $x] = $newValue;
      }
    }
  }
}

$riskMap = [];
for ($y = 0; $y < count($caveMap); $y++) {
  $riskMap[] = array_fill(0, count($caveMap[0]), PHP_INT_MAX);
}

$riskMap[0][0] = 0;
$queue = [[0,0]];

while (sizeof($queue)) {
	[$y, $x] = array_shift($queue);

  if (
    isset($caveMap[$y - 1][$x]) &&
    $riskMap[$y - 1][$x] > ($riskMap[$y][$x] + $caveMap[$y - 1][$x])
  ) {
		$queue[] = [$y - 1, $x];
		$riskMap[$y - 1][$x] = $riskMap[$y][$x] + $caveMap[$y - 1][$x];
	}

  if (
    isset($caveMap[$y + 1][$x]) &&
    $riskMap[$y + 1][$x] > ($riskMap[$y][$x] + $caveMap[$y + 1][$x])
  ) {
		$queue[] = [$y + 1, $x];
		$riskMap[$y + 1][$x] = $riskMap[$y][$x] + $caveMap[$y + 1][$x];
	}

  if (
    isset($caveMap[$y][$x - 1]) &&
    $riskMap[$y][$x - 1] > ($riskMap[$y][$x] + $caveMap[$y][$x - 1])
  ) {
		$queue[] = [$y, $x - 1];
		$riskMap[$y][$x - 1] = $riskMap[$y][$x] + $caveMap[$y][$x - 1];
  }

  if (
    isset($caveMap[$y][$x + 1]) &&
    $riskMap[$y][$x + 1] > ($riskMap[$y][$x] + $caveMap[$y][$x + 1])
  ) {
		$queue[] = [$y, $x + 1];
		$riskMap[$y][$x + 1] = $riskMap[$y][$x] + $caveMap[$y][$x + 1];
	}
}

echo $riskMap[count($riskMap) - 1][count($riskMap[0]) - 1];

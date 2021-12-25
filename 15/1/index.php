<?php

$caveMap = [];
$riskMap = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);

  $caveMap[] = array_map(fn($val) => (int) $val, str_split($line));
  $riskMap[] = array_fill(0, strlen($line), PHP_INT_MAX);
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

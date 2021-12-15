<?php

$scores = [
  ')' => 3,
  ']' => 57,
  '}' => 1197,
  '>' => 25137,
];

$legalChunkBrackets = [
  '(' => ')',
  '[' => ']',
  '{' => '}',
  '<' => '>',
];

$totalScore = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);
  $line = str_split($line);

  $chunk = [];
  foreach ($line as $character) {
    if (in_array($character, ['(', '[', '{', '<'])) {
      $chunk[] = $character;
      continue;
    }

    $expectedClose = $legalChunkBrackets[array_pop($chunk)];
    if ($character !== $expectedClose) {
      $totalScore += $scores[$character];
      break;
    }
  }
}

echo $totalScore;

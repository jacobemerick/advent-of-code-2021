<?php

$scores = [
  ')' => 1,
  ']' => 2,
  '}' => 3,
  '>' => 4,
];

$legalChunkBrackets = [
  '(' => ')',
  '[' => ']',
  '{' => '}',
  '<' => '>',
];

$autocompleteScores = [];

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
      continue 2;
    }
  }

  $lineScore = 0;
  foreach ($chunk as $character) {
    $lineScore *= 5;
    $lineScore += $scores[$legalChunkBrackets[array_pop($chunk)]];
  }
  $autocompleteScores[] = $lineScore;
}

sort($autocompleteScores);
echo $autocompleteScores[floor(count($autocompleteScores) / 2)];

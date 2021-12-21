<?php

$polymer = '';
$rules = [];

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $line = trim($line);

  if (empty($polymer)) {
    $polymer = $line;
    continue;
  }

  if (empty($line)) continue;

  [$key, $value] = explode(' -> ', $line);
  $rules[$key] = $value;
}

$polymer_pairs = [];
for ($i = 0; $i < strlen($polymer); $i++) {
  if ($i < strlen($polymer) - 1) {
    if (isset($polymer_pairs[substr($polymer, $i, 2)])) {
      $polymer_pairs[substr($polymer, $i, 2)]++;
    } else {
      $polymer_pairs[substr($polymer, $i, 2)] = 1;
    }
  }
}

// 10 for part 1, 40 for part 2
$steps = 10;
for ($i = 0; $i < $steps; $i++) {
  $new_polymer_pairs = [];
  foreach ($rules as $rule => $insert) {
    if (array_key_exists($rule, $polymer_pairs)) {
      @$new_polymer_pairs["{$rule[0]}{$insert}"] += $polymer_pairs[$rule];
      @$new_polymer_pairs["{$insert}{$rule[1]}"] += $polymer_pairs[$rule];
    }
  }

  $polymer_pairs = $new_polymer_pairs;
}

$element_count = [];
foreach ($polymer_pairs as $pair => $count) {
  [$a, $b] = str_split($pair);

  @$element_count[$a] += $count;
  @$element_count[$b] += $count;
}
foreach ($element_count as $element => $count) {
  $element_count[$element] = ($count % 2) ? ($count + 1) / 2 : $count / 2;
}

asort($element_count);
echo end($element_count) - reset($element_count);

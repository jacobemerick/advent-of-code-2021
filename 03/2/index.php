<?php

$generatorRating = [];
$scrubberRating = [];

$bitCount = 0;

$handle = fopen('test.txt', 'r');
// $handle = fopen('input.txt', 'r');
while (($number = fgets($handle))) {
  $bits = array_filter(str_split($number), fn($bit) => $bit === '1' || $bit === '0');
  if ($bitCount === 0) {
    $bitCount = count($bits);
  }

  $generatorRating[] = $bits;
  $scrubberRating[] = $bits;
}

function mostCommonBit($array, $pos) {
  $zeros = 0;
  $ones = 0;

  foreach ($array as $number) {
    if ($number[$pos] === '0') {
      $zeros++;
    } else {
      $ones++;
    }
  }

  if ($zeros > $ones) {
    return '0';
  } else if ($ones > $zeros) {
    return '1';
  } else {
    return null;
  }
}

for ($i = 0; $i < $bitCount; $i++) {
  $generatorRating = array_filter($generatorRating, function($number) {
    global $generatorRating, $i;
    if (count($generatorRating) === 1) return true;
    $commonBit = mostCommonBit($generatorRating, $i);
    return ($commonBit === null) ? ($number[$i] === '1') : ($commonBit === $number[$i]);
  });

  $scrubberRating = array_filter($scrubberRating, function($number) {
    global $scrubberRating, $i;
    if (count($scrubberRating) === 1) return true;
    $commonBit = mostCommonBit($scrubberRating, $i);
    return ($commonBit === null) ? ($number[$i] === '0') : ($commonBit !== $number[$i]);
  });
}

echo bindec(implode('', current($generatorRating))) * bindec(implode('', current($scrubberRating)));

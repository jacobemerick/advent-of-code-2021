<?php

$transmission = '9C0141080250320F1802104A08';

/**
$handle = fopen('input.txt', 'r');
while (($line = fgets($handle))) {
  $transmission = trim($line);
}
 */

// PHP trips over big numbers w/ base_convert, need to be careful
$binary = '';
for ($i = 0; $i < strlen($transmission); $i++) {
  $binary .= str_pad(base_convert($transmission[$i], 16, 2), 4, '0', STR_PAD_LEFT);
}

function packetParser($string) {
  $version = bindec(substr($string, 0, 3));
  $type = bindec(substr($string, 3, 3));

  if ($type === 4) {
    $value = '';
    $leftover = '';
    $groups = str_split(substr($string, 6), 5);

    foreach ($groups as $key => $group) {
      $value .= substr($group, 1);
      if ($group[0] === '0') {
        $leftover = implode('', array_slice($groups, $key + 1));
        break;
      }
    }

    return [
      'type' => $type,
      'version' => $version,
      'value' => bindec($value),
      'leftover' => $leftover,
    ];
  }

  $subpackets = [];
  $subpacketString = '';

  if (substr($string, 6, 1) === '0') {
    $subpacketLength = bindec(substr($string, 7, 15));
    $subpacketString = substr($string, 22, $subpacketLength);

    while (preg_match('/[^0]/', $subpacketString)) {
      $subpackets[] = packetParser($subpacketString);
      $subpacketString = end($subpackets)['leftover'];
    }

    $subpacketString = substr($string, 22 + $subpacketLength);
  } else {
    $subpacketCount = bindec(substr($string, 7, 11));
    $subpacketString = substr($string, 18);

    while ($subpacketCount > count($subpackets)) {
      $subpackets[] = packetParser($subpacketString);
      $subpacketString = @end($subpackets)['leftover'];
    }
  }

  return [
    'type' => $type,
    'version' => $version,
    'contains' => $subpackets,
    'leftover' => $subpacketString,
  ];
}

$parsedPacket = [packetParser($binary)];

function walkParsedPacket($value, $packet) {
  switch ($packet['type']) {
    case 0:
      return array_sum(array_map(fn ($p) => walkParsedPacket(0, $p), $packet['contains']));
    case 1:
      return array_product(array_map(fn ($p) => walkParsedPacket(1, $p), $packet['contains']));
    case 2:
      return array_reduce($packet['contains'], fn ($v, $p) => min($v, walkParsedPacket($v, $p)), PHP_INT_MAX);
    case 3:
      return array_reduce($packet['contains'], fn ($v, $p) => max($v, walkParsedPacket($v, $p)), 0);
    case 4:
      return $packet['value'];
    case 5:
      return walkParsedPacket($value, $packet['contains'][0]) > walkParsedPacket($value, $packet['contains'][1]) ? 1 : 0;
    case 6:
      return walkParsedPacket($value, $packet['contains'][0]) < walkParsedPacket($value, $packet['contains'][1]) ? 1 : 0;
    case 7:
      return walkParsedPacket($value, $packet['contains'][0]) === walkParsedPacket($value, $packet['contains'][1]) ? 1 : 0;
    default:
      throw new Exception('oh no');
  }
}

echo array_reduce($parsedPacket, 'walkParsedPacket', 0);

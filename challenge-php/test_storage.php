<?php

require_once __DIR__ . '/vendor/autoload.php';

use PokerHand\PokerHand;

$testHands = [
    'Royal Flush' => 'As Ks Qs Js 10s',
    'One Pair' => 'Ah As 10c 7d 6s',
    'Two Pair' => 'Kh Kc 3s 3h 2d',
    'Flush' => 'Kh Qh 6h 2h 9h',
];

foreach ($testHands as $name => $handString) {
    $hand = new PokerHand($handString);
    $cards = $hand->getCards();
    echo "$name: ";
    print_r($cards);
}


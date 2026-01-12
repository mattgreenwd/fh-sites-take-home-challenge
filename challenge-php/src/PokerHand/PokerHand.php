<?php

namespace PokerHand;

class PokerHand
{
    //Let's store the cards in an array so we can easily access them later
    private $cards = [];

    public function __construct($hand)
    {
        //split the string by spaces to get individual cards
        $this->cards = explode(' ', $hand);
    }

    private function getRankFromCard($card)
    {
        if (strlen($card) == 3) {
            return '10';
        }
        return substr($card, 0, 1);
    }

    private function getSuitFromCard($card)
    {
        return substr($card, -1);
    }

    private function getRankCounts()
    //This function will return an array of the counts of each rank in the hand
    {
        $ranks = [];
        foreach ($this->cards as $card) {
            $ranks[] = $this->getRankFromCard($card);
        }
        return array_count_values($ranks);
    }

    private function getRankValue($rank)
    {
        $rankMap = [
            'A' => 14,
            'K' => 13,
            'Q' => 12,
            'J' => 11,
            '10' => 10,
            '9' => 9,
            '8' => 8,
            '7' => 7,
            '6' => 6,
            '5' => 5,
            '4' => 4,
            '3' => 3,
            '2' => 2,
        ];
        return $rankMap[$rank] ?? 0;
    }

    private function isFlush()
    {
        $suits = [];
        foreach ($this->cards as $card) {
            $suits[] = $this->getSuitFromCard($card);
        }
        return count(array_unique($suits)) === 1;
    }

    private function isStraight()
    {
        $ranks = [];
        foreach ($this->cards as $card) {
            $ranks[] = $this->getRankFromCard($card);
        }
        
        $values = array_map([$this, 'getRankValue'], $ranks);
        sort($values);
        
        // Check for normal straight
        $isNormalStraight = true;
        for ($i = 1; $i < count($values); $i++) {
            if ($values[$i] !== $values[$i - 1] + 1) {
                $isNormalStraight = false;
                break;
            }
        }
        
        // Check for A-2-3-4-5 straight (wheel)
        $wheel = [2, 3, 4, 5, 14];
        sort($wheel);
        $isWheel = $values === $wheel;
        
        return $isNormalStraight || $isWheel;
    }

    private function isRoyalFlush()
    {
        $ranks = [];
        $suits = [];
        
        foreach ($this->cards as $card) {
            $ranks[] = $this->getRankFromCard($card);
            $suits[] = $this->getSuitFromCard($card);
        }
        
        $allSameSuit = count(array_unique($suits)) === 1;
        $royalRanks = ['10', 'A', 'J', 'K', 'Q'];
        sort($ranks);
        sort($royalRanks);
        $hasRoyalRanks = $ranks === $royalRanks;
        
        return $allSameSuit && $hasRoyalRanks;
    }

    private function isStraightFlush()
    {
        return $this->isFlush() && $this->isStraight();
    }

    private function isFourOfAKind()
    {
        $rankCounts = $this->getRankCounts();
        return in_array(4, $rankCounts);
    }

    private function isFullHouse()
    {
        $rankCounts = $this->getRankCounts();
        return in_array(3, $rankCounts) && in_array(2, $rankCounts);
    }

    private function isOnePair()
    //This function will return true if the hand is a one pair
    {
        $rankCounts = $this->getRankCounts();
        $pairCount = 0;
        
        foreach ($rankCounts as $count) {
            if ($count === 2) {
                $pairCount++;
            }
        }
        
        return $pairCount === 1;
    }

    public function getRank()
    {
        if ($this->isRoyalFlush()) {
            return 'Royal Flush';
        }
        
        if ($this->isStraightFlush()) {
            return 'Straight Flush';
        }
        
        if ($this->isFourOfAKind()) {
            return 'Four of a Kind';
        }
        
        if ($this->isFullHouse()) {
            return 'Full House';
        }
        
        if ($this->isOnePair()) {
            return 'One Pair';
        }
        
        return 'High Card';
    }

    // TEMPORARY: Just for testing - remove this later!
    public function getCards()
    {
        return $this->cards;
    }
}
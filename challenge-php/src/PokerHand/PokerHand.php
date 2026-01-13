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
        // 10 is the only rank that uses 2 characters, making the card string 3 chars total
        // All other ranks are single characters (A, K, Q, J, 9, 8, etc.)
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
        
        // Convert ranks to numeric values so we can check if they're consecutive
        $values = array_map([$this, 'getRankValue'], $ranks);
        sort($values);
        
        // Check if values are consecutive (each one is exactly 1 more than the previous)
        $isNormalStraight = true;
        for ($i = 1; $i < count($values); $i++) {
            if ($values[$i] !== $values[$i - 1] + 1) {
                $isNormalStraight = false;
                break;
            }
        }
        
        // Special case: A-2-3-4-5 is a valid straight (wheel)
        // Ace counts as low here, so it's 2-3-4-5-14 after conversion
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

    private function isThreeOfAKind()
    {
        // Three of a kind means one rank appears 3 times
        // But we need to exclude Full House, which also has three of a kind plus a pair
        $rankCounts = $this->getRankCounts();
        return in_array(3, $rankCounts) && !in_array(2, $rankCounts);
    }

    private function isTwoPair()
    {
        // Count how many ranks appear exactly twice
        // Two pair means exactly two different ranks each appear twice
        $rankCounts = $this->getRankCounts();
        $pairCount = 0;
        
        foreach ($rankCounts as $count) {
            if ($count === 2) {
                $pairCount++;
            }
        }
        
        return $pairCount === 2;
    }

    private function isOnePair()
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
        // Check highest to lowest - order matters because some hands match multiple patterns
        // Royal Flush is also a Straight Flush, but we want to return the higher rank
        
        if ($this->isRoyalFlush()) {
            return 'Royal Flush';
        }
        
        // Must check Straight Flush before Flush and Straight separately
        // A straight flush matches both patterns but ranks higher
        if ($this->isStraightFlush()) {
            return 'Straight Flush';
        }
        
        if ($this->isFourOfAKind()) {
            return 'Four of a Kind';
        }
        
        // Full House has both three of a kind and a pair, but ranks higher than either alone
        if ($this->isFullHouse()) {
            return 'Full House';
        }
        
        // Flush: all same suit but not a straight
        // We already checked for straight flush above, so this is just a flush
        if ($this->isFlush()) {
            return 'Flush';
        }
        
        // Straight: consecutive ranks but not all same suit
        // We already checked for straight flush above, so this is just a straight
        if ($this->isStraight()) {
            return 'Straight';
        }
        
        // Three of a kind: one rank appears 3 times, others are different
        // Must check after Full House since Full House also has three of a kind
        if ($this->isThreeOfAKind()) {
            return 'Three of a Kind';
        }
        
        // Two pair: two different ranks each appear twice
        // Must check before one pair since two pair ranks higher
        if ($this->isTwoPair()) {
            return 'Two Pair';
        }
        
        // One pair: exactly one rank appears twice
        if ($this->isOnePair()) {
            return 'One Pair';
        }
        
        // If none of the above match, it's just the highest card
        return 'High Card';
    }

}
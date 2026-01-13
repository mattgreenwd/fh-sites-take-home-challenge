<?php
namespace PokerHand;

use PHPUnit\Framework\TestCase;

class PokerHandTest extends TestCase
{
    /**
     * @test
     */
    public function itCanRankARoyalFlush()
    {
        $hand = new PokerHand('As Ks Qs Js 10s');
        $this->assertEquals('Royal Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraightFlush()
    {
        $hand = new PokerHand('9s 8s 7s 6s 5s');
        $this->assertEquals('Straight Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankFourOfAKind()
    {
        $hand = new PokerHand('Ah As Ac Ad 10h');
        $this->assertEquals('Four of a Kind', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAFullHouse()
    {
        $hand = new PokerHand('Ah As Ac Kh Kc');
        $this->assertEquals('Full House', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAFlush()
    {
        $hand = new PokerHand('Kh Qh 6h 2h 9h');
        $this->assertEquals('Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraight()
    {
        $hand = new PokerHand('5h 4c 3s 2d Ah');
        $this->assertEquals('Straight', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankThreeOfAKind()
    {
        $hand = new PokerHand('Ah As Ac 10h 7d');
        $this->assertEquals('Three of a Kind', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankTwoPair()
    {
        $hand = new PokerHand('Kh Kc 3s 3h 2d');
        $this->assertEquals('Two Pair', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankOnePair()
    {
        $hand = new PokerHand('Ah As 10c 7d 6s');
        $this->assertEquals('One Pair', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankHighCard()
    {
        $hand = new PokerHand('Ah 10c 7d 6s 2h');
        $this->assertEquals('High Card', $hand->getRank());
    }
}
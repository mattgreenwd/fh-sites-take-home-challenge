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
    }

    /**
     * @test
     */
    public function itCanRankAStraight()
    {
    }

    /**
     * @test
     */
    public function itCanRankThreeOfAKind()
    {
    }

    /**
     * @test
     */
    public function itCanRankTwoPair()
    {
    }

    /**
     * @test
     */
    public function itCanRankOnePair()
    {
    }

    /**
     * @test
     */
    public function itCanRankHighCard()
    {
    }
}
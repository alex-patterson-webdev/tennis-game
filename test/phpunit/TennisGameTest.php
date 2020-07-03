<?php

declare(strict_types=1);

namespace ArpTest\TennisGame;

use Arp\TennisGame\Constant\TennisPoint;
use Arp\TennisGame\TennisGame;
use PHPUnit\Framework\TestCase;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\TennisGame
 */
final class TennisGameTest extends TestCase
{
    /**
     * Assert that the starting score for both players is Love.
     *
     * @covers \Arp\TennisGame\TennisGame::renderScore
     */
    public function testStartingScoreIsLoveForBothPlayers(): void
    {
        $game = new TennisGame();

        $expectedScore = TennisPoint::LOVE . '-' . TennisPoint::LOVE;

        $this->assertSame($expectedScore, $game->renderScore());
    }

    /**
     * Assert that when player one scores the first point the score is correct.
     *
     * @covers \Arp\TennisGame\TennisGame::renderScore
     */
    public function testPlayerOneScores(): void
    {
        $game = new TennisGame();

        $game->playerOneWinsShot();

        $expectedScore = TennisPoint::FIFTEEN . '-' . TennisPoint::LOVE;

        $this->assertSame($expectedScore, $game->renderScore());
    }

    /**
     * Assert that when player two scores the first point the score is correct.
     *
     * @covers \Arp\TennisGame\TennisGame::renderScore
     */
    public function testPlayerTwoScores(): void
    {
        $game = new TennisGame();

        $game->playerTwoWinsShot();

        $expectedScore = TennisPoint::LOVE . '-' . TennisPoint::FIFTEEN;

        $this->assertSame($expectedScore, $game->renderScore());
    }

    /**
     * Assert that when player two scores the first point the score is correct.
     *
     * @covers \Arp\TennisGame\TennisGame::renderScore
     */
    public function testBothPlayersScore(): void
    {
        $game = new TennisGame();

        $game->playerOneWinsShot();
        $game->playerTwoWinsShot();

        $expectedScore = TennisPoint::FIFTEEN . '-' . TennisPoint::FIFTEEN;

        $this->assertSame($expectedScore, $game->renderScore());
    }
}

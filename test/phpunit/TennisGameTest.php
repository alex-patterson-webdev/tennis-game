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
     * @covers \Arp\TennisGame\TennisGame::playerOneWinsShot
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
     * @covers \Arp\TennisGame\TennisGame::playerTwoWinsShot
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
     * Assert that when both players score the score is correct.
     *
     * @covers \Arp\TennisGame\TennisGame::playerOneWinsShot
     * @covers \Arp\TennisGame\TennisGame::playerTwoWinsShot
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

    /**
     * Assert all combinations of all possible scores are correct.
     *
     * @param string $expectedScore   The expected score output
     * @param int    $playerOnePoints The points of player one
     * @param int    $playerTwoPoints The points of player two
     *
     * @covers \Arp\TennisGame\TennisGame::playerOneWinsShot
     * @covers \Arp\TennisGame\TennisGame::playerTwoWinsShot
     * @covers \Arp\TennisGame\TennisGame::renderScore
     *
     * @dataProvider getAllScoreCombinationsData
     */
    public function testAllScoreCombinations($expectedScore, int $playerOnePoints = 0, int $playerTwoPoints = 0): void
    {
        $game = new TennisGame();

        for ($x = 0; $x < $playerOnePoints; $x++) {
            $game->playerOneWinsShot();
        }

        for ($y = 0; $y < $playerTwoPoints; $y++) {
            $game->playerTwoWinsShot();
        }

        $this->assertSame($expectedScore, $game->renderScore());
    }

    /**
     * @return array
     */
    public function getAllScoreCombinationsData(): array
    {
        return [
            [
                TennisPoint::LOVE . '-' . TennisPoint::LOVE,
                0,
                0
            ],
            [
                TennisPoint::FIFTEEN . '-' . TennisPoint::LOVE,
                1,
                0
            ],
            [
                TennisPoint::THIRTY. '-' . TennisPoint::LOVE,
                2,
                0
            ],
            [
                TennisPoint::FORTY . '-' . TennisPoint::LOVE,
                3,
                0
            ],
            [
                TennisPoint::WIN . '-' . TennisPoint::LOVE,
                4,
                0
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace ArpTest\TennisGame;

use Arp\TennisGame\Constant\PlayerName;
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
     * Assert that calls to resetScore() will result in both players score being reset to love-love
     *
     * @covers \Arp\TennisGame\TennisGame::resetScore
     */
    public function testResetScoreWillSetScoreToLoveLove(): void
    {
        $game = new TennisGame();

        $game->playerOneWinsShot();
        $game->playerTwoWinsShot();
        $game->playerTwoWinsShot();
        $game->playerTwoWinsShot();

        $this->assertNotSame(TennisPoint::LOVE . '-' . TennisPoint::LOVE, $game->renderScore());

        $game->resetScore();

        $this->assertSame(TennisPoint::LOVE . '-' . TennisPoint::LOVE, $game->renderScore());
    }

    /**
     * Assert all combinations of all possible scores are correct.
     *
     * @param string $expectedScore   The expected score output
     * @param int    $playerOnePoints The points of player one
     * @param int    $playerTwoPoints The points of player two
     *
     * @covers       \Arp\TennisGame\TennisGame::isDeuce
     * @covers       \Arp\TennisGame\TennisGame::isAdvantageScore
     * @covers       \Arp\TennisGame\TennisGame::isWinningScore
     * @covers       \Arp\TennisGame\TennisGame::renderScore
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
     * Assertion data for combinations of tennis scores possible.
     *
     * @return array
     */
    public function getAllScoreCombinationsData(): array
    {
        return [
            // Love
            [TennisPoint::LOVE . '-' . TennisPoint::LOVE, 0, 0],
            [TennisPoint::LOVE . '-' . TennisPoint::FIFTEEN, 0, 1],
            [TennisPoint::LOVE . '-' . TennisPoint::THIRTY, 0, 2],
            [TennisPoint::LOVE . '-' . TennisPoint::FORTY, 0, 3],

            // Fifteen
            [TennisPoint::FIFTEEN . '-' . TennisPoint::LOVE, 1, 0],
            [TennisPoint::FIFTEEN . '-' . TennisPoint::FIFTEEN, 1, 1],
            [TennisPoint::FIFTEEN . '-' . TennisPoint::THIRTY, 1, 2],
            [TennisPoint::FIFTEEN . '-' . TennisPoint::FORTY, 1, 3],

            // Thirty
            [TennisPoint::THIRTY . '-' . TennisPoint::LOVE, 2, 0],
            [TennisPoint::THIRTY . '-' . TennisPoint::FIFTEEN, 2, 1],
            [TennisPoint::THIRTY . '-' . TennisPoint::THIRTY, 2, 2],
            [TennisPoint::THIRTY . '-' . TennisPoint::FORTY, 2, 3],

            // Forty
            [TennisPoint::FORTY . '-' . TennisPoint::LOVE, 3, 0],
            [TennisPoint::FORTY . '-' . TennisPoint::FIFTEEN, 3, 1],
            [TennisPoint::FORTY . '-' . TennisPoint::THIRTY, 3, 2],

            // Deuce
            [TennisPoint::DEUCE, 3, 3],

            // Advantages
            [TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_ONE, 4, 3],
            [TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_TWO, 3, 4],

            // Wins
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_ONE, 4, 0],
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_ONE, 4, 1],
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_ONE, 4, 2],
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_TWO, 0, 4],
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_TWO, 1, 4],
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_TWO, 2, 4],

            // Play continues if advantages are diff of 1 at any score
            [TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_ONE, 8, 7],
            [TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_TWO, 7, 8],
            [TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_ONE, 101, 100],
            [TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_TWO, 99, 100],

            // Deuce would include any draw score forty
            [TennisPoint::DEUCE, 8, 8],
            [TennisPoint::DEUCE, 35, 35],
            [TennisPoint::DEUCE, 75, 75],

            // If we continue to have >2 winning shots we should still respect the winner
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_ONE, 110, 100],
            [TennisPoint::WIN . ' ' . PlayerName::PLAYER_TWO, 90, 170],
        ];
    }
}

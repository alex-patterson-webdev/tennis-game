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
     * @covers \Arp\TennisGame\TennisGame
     */
    public function testStartingScoreIsLoveForBothPlayers(): void
    {
        $game = new TennisGame();

        $this->assertSame(
            TennisPoint::LOVE . '-' . TennisPoint::LOVE,
            $game->renderScore()
        );
    }
}

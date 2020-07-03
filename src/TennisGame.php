<?php

declare(strict_types=1);

namespace Arp\TennisGame;

use Arp\TennisGame\Constant\TennisPoint;
use Arp\TennisGame\Exception\TennisGameException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\TennisGame
 */
class TennisGame
{
    /**
     * @var int
     */
    private int $playerOnePoints = 0;

    /**
     * @var int
     */
    private int $playerTwoPoints = 0;

    /**
     * A static map of tennis points to their corresponding string values.
     *
     * @var string[]
     */
    private static array $pointValueMap = [
        0 => TennisPoint::LOVE,
        1 => TennisPoint::FIFTEEN,
        2 => TennisPoint::THIRTY,
        3 => TennisPoint::FORTY,
        6 => TennisPoint::WIN,
    ];

    /**
     * @return string
     */
    public function renderScore(): string
    {
        return $this->getPlayerScore($this->playerOnePoints) . '-' . $this->getPlayerScore($this->playerTwoPoints);
    }

    /**
     * Return a string representation for the provided $points.
     *
     * @param int $points
     *
     * @return string
     *
     * @throws TennisGameException  If the provided players points are invalid
     */
    private function getPlayerScore(int $points): string
    {
        if (!isset(static::$pointValueMap[$points])) {
            throw new TennisGameException(
                sprintf('Invalid tennis points value \'%d\'', $points)
            );
        }

        return static::$pointValueMap[$points];
    }
}

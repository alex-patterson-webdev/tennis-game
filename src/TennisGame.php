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
     * A static map of tennis points to their corresponding string names.
     *
     * @var string[]
     */
    private static array $pointNames = [
        0 => TennisPoint::LOVE,
        1 => TennisPoint::FIFTEEN,
        2 => TennisPoint::THIRTY,
        3 => TennisPoint::FORTY,
        6 => TennisPoint::WIN,
    ];

    /**
     * Add points to player one.
     */
    public function playerOneWinsShot(): void
    {
        $this->playerOnePoints++;
    }

    /**
     * Add points to player one.
     */
    public function playerTwoWinsShot(): void
    {
        $this->playerTwoPoints++;
    }

    /**
     * @return string
     */
    public function renderScore(): string
    {
        return $this->getPointsName($this->playerOnePoints) . '-' . $this->getPointsName($this->playerTwoPoints);
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
    private function getPointsName(int $points): string
    {
        if (!isset(static::$pointNames[$points])) {
            throw new TennisGameException(
                sprintf('Invalid tennis points value \'%d\'', $points)
            );
        }

        return static::$pointNames[$points];
    }
}

<?php

declare(strict_types=1);

namespace Arp\TennisGame;

use Arp\TennisGame\Constant\TennisPoint;
use Arp\TennisGame\Exception\TennisGameException;

/**
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package Arp\TennisGame
 */
final class TennisGame
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
        3 => TennisPoint::FORTY
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
        if ($this->playerOnePoints >= 3 && 0 === $this->compareScores()) {
            return TennisPoint::DEUCE;
        }

        if ($this->playerOnePoints >= 4 && $this->playerOnePoints >= ($this->playerTwoPoints + 2)) {
            return TennisPoint::WIN . '-' . $this->getPointsName($this->playerTwoPoints);
        }

        if ($this->playerTwoPoints >= 4 && $this->playerTwoPoints >= ($this->playerOnePoints + 2)) {
            return $this->getPointsName($this->playerTwoPoints) . '-' . TennisPoint::WIN;
        }

        return $this->getPointsName($this->playerOnePoints) . '-' . $this->getPointsName($this->playerTwoPoints);
    }

    /**
     * Compare the players scores
     *
     * @return int
     */
    private function compareScores(): int
    {
        return $this->playerOnePoints <=> $this->playerTwoPoints;
    }

    /**
     * Return a string representation for the provided $pointsValue.
     *
     * @param int $pointsValue
     *
     * @return string
     *
     * @throws TennisGameException  If the provided players points are invalid
     */
    private function getPointsName(int $pointsValue): string
    {
        if (!isset(static::$pointNames[$pointsValue])) {
            throw new TennisGameException(
                sprintf('Unable to find name for points value \'%d\'', $pointsValue)
            );
        }

        return static::$pointNames[$pointsValue];
    }
}

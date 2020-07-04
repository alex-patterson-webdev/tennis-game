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
        3 => TennisPoint::FORTY,
        4 => TennisPoint::WIN
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
        if ($this->isDeuce()) {
            return TennisPoint::DEUCE;
        }

        if ($this->isWinningScore($this->playerOnePoints, $this->playerTwoPoints)) {
            return TennisPoint::WIN . '-' . $this->getPointsName($this->playerTwoPoints);
        }

        if ($this->isWinningScore($this->playerTwoPoints, $this->playerOnePoints)) {
            return $this->getPointsName($this->playerOnePoints) . '-' . TennisPoint::WIN;
        }

        if ($this->isAdvantageScore($this->playerOnePoints, $this->playerTwoPoints)) {
            return TennisPoint::ADVANTAGE . ' Player One';
        }

        if ($this->isAdvantageScore($this->playerTwoPoints, $this->playerOnePoints)) {
            return TennisPoint::ADVANTAGE . ' Player Two';
        }

        return $this->getPointsName($this->playerOnePoints) . '-' . $this->getPointsName($this->playerTwoPoints);
    }

    /**
     * Check if the score is deuce.
     *
     * @return bool
     */
    private function isDeuce(): bool
    {
        return $this->playerOnePoints >= 3 && 0 === $this->compareScores();
    }

    /**
     * Check if the provided $checkScore is an advantage point compared with $compareScore.
     *
     * @param int $checkScore   The score that should be checked for an advantage point status.
     * @param int $compareScore The players score that should be compared with the $checkScore.
     *
     * @return bool
     */
    private function isAdvantageScore(int $checkScore, int $compareScore): bool
    {
        return ($checkScore >= 4 && $checkScore >= ($compareScore + 1));
    }

    /**
     * Check if the provided $checkScore is a winning score when compared tgo $compareScore.
     *
     * @param int $checkScore   The score that should be checked for winning status.
     * @param int $compareScore The score that should be compared.
     *
     * @return bool
     */
    private function isWinningScore(int $checkScore, int $compareScore): bool
    {
        return ($checkScore >= 4 && $checkScore >= ($compareScore + 2));
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

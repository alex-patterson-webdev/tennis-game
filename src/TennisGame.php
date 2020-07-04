<?php

declare(strict_types=1);

namespace Arp\TennisGame;

use Arp\TennisGame\Constant\PlayerName;
use Arp\TennisGame\Constant\TennisPoint;

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
        4 => TennisPoint::WIN,
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
            return TennisPoint::WIN . ' ' . PlayerName::PLAYER_ONE;
        }

        if ($this->isWinningScore($this->playerTwoPoints, $this->playerOnePoints)) {
            return TennisPoint::WIN . ' ' . PlayerName::PLAYER_TWO;
        }

        if ($this->isAdvantageScore($this->playerOnePoints, $this->playerTwoPoints)) {
            return TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_ONE;
        }

        if ($this->isAdvantageScore($this->playerTwoPoints, $this->playerOnePoints)) {
            return TennisPoint::ADVANTAGE . ' ' . PlayerName::PLAYER_TWO;
        }

        return static::$pointNames[$this->playerOnePoints] . '-' . static::$pointNames[$this->playerTwoPoints];
    }

    /**
     * Reset the players score back to zero.
     */
    public function resetScore(): void
    {
        $this->playerOnePoints = 0;
        $this->playerTwoPoints = 0;
    }

    /**
     * Check if the score is deuce.
     *
     * @return bool
     */
    private function isDeuce(): bool
    {
        return ($this->playerOnePoints >= 3) && 0 === ($this->playerOnePoints <=> $this->playerTwoPoints);
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
}

<?php

declare(strict_types=1);

namespace Jonkul\Dice;

/* use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
}; */


/**
 * Class Dice.
 */
class Dice
{
    private int $sides;
    private int $lastRoll;

    public function __construct($n = 6)
    {
        $this->setSides($n);
    }

    public function roll(): int
    {
        $roll = rand(1, $this->sides);
        $this->setLastRoll($roll);
        return $roll;
    }

    public function getLastRoll(): int
    {
        return $this->lastRoll;
    }

    public function setSides($n): void
    {
        $this->sides = $n;
    }

    public function setLastRoll($n): void
    {
        $this->lastRoll = $n;
    }
}

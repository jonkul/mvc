<?php

declare(strict_types=1);

namespace Jonkul\Dice;



/**
 * Class Dice.
 */
class Dice
{
    private int $sides;
    private bool $saved;
    private int $lastRoll;

    public function __construct($n = 6, $s = false, $l = 0)
    {
        $this->setSides($n);
        $this->setSaved($s);
        $this->setLastRoll($l);
    }

    public function roll(): void
    {
        if ($this->saved === false) {
            $roll = rand(1, $this->sides);
            $this->setLastRoll($roll);
        }
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

    public function getSaved(): bool
    {
        return $this->saved;
    }

    public function setSaved($s): void
    {
        $this->saved = $s;
    }
}

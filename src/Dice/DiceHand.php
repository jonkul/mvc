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
 * Class DiceHand.
 */
class DiceHand
{
    private array $dices;
    private int $sum;
    private int $numberD;

    public function __construct($numberD = 0)
    {
        for ($i = 0; $i < $numberD; $i++) {
            $this->dices[$i] = new Dice();
            $this->setNumberD($numberD);
        }
    }

    public function roll(): void
    {
        $len = count($this->dices);

        $this->sum = 0;
        for ($i = 0; $i < $this->numberD; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
    }

    public function getLastRoll(): string
    {
        $res = "";
        for ($i = 0; $i < $this->numberD; $i++) {
            $res .= $this->dices[$i]->getLastRoll() . ", ";
        }
        $res = rtrim($res, ", ");

        return $res;
    }

    public function getLastSum(): int
    {
        return $this->sum;
    }

    public function setSides($n): void
    {
        $len = count($this->dices);

        for ($i = 0; $i < $this->numberD; $i++) {
            $this->dices[$i]->setSides($n);
        }
    }

    public function setNumberD($m): void
    {
        $this->numberD = $m;
    }
}

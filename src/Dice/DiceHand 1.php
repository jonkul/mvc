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
    private array $saved;
    private array $final;
    private int $sum;
    private int $numberD;
    private int $score;
    private int $bonus;

    public function __construct($numberD = 0)
    {
        for ($i = 0; $i < $numberD; $i++) {
            $this->dices[$i] = new Dice();
            $this->setNumberD($numberD);
            $this->saved = [null, null, null, null, null];
            $this->final = [null, null, null, null, null];
            $this->score = 0;
            $this->bonus = 0;
        }
    }

    public function roll(): void
    {
        $this->sum = 0;
        for ($i = 0; $i < $this->numberD; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
    }

    public function getLastRollStr(): string
    {
        $res = "";
        for ($i = 0; $i < $this->numberD; $i++) {
            $res .= $this->dices[$i]->getLastRoll() . ", ";
        }
        $res = rtrim($res, ", ");

        return $res;
    }

    public function getLastRollArr(): array
    {
        $res = [];
        for ($i = 0; $i < $this->numberD; $i++) {
            $res[] = $this->dices[$i]->getLastRoll();
        }
        return $res;
    }

    public function getLastSum(): int
    {
        return $this->sum;
    }

    public function setSides($n): void
    {
        for ($i = 0; $i < $this->numberD; $i++) {
            $this->dices[$i]->setSides($n);
        }
    }

    public function setNumberD($m): void
    {
        $this->numberD = $m;
    }

    public function graphicHand()
    {
        $res = "<p class='dice-utf8'>";
            for ($i = 0; $i < $this->numberD; $i++) {
                $res .= '<i class="dice-' . $this->dices[$i]->getLastRoll() . '"></i> ';
            }
        $res = rtrim($res, " ");
        $res .= "</p>";

        return $res;
    }

    public function setSaved($d)
    {
        $this->saved[$d] = $this->dices[$d]->getLastRoll();
        $this->dices[$d]->setLastRoll(0);
    }

    public function getSavedArr(): array
    {
        $resS = [];
        for ($i = 0; $i < count($this->saved); $i++) {
            $resS[$i] = $this->saved[$i];
        }
        return $resS;
    }

    public function setFinal()
    {
        $resF = [];

        for ($i = 0; $i < count($this->dices); $i++) {
            if ($this->dices[$i] !== 0) {
                $resF[$i] = $this->dices[$i]->getLastRoll();
            }
        }

        for ($i = 0; $i < count($this->saved); $i++) {
            if ($this->saved[$i] !== null) {
                $resF[$i] = $this->saved[$i];
            }
        }

        $this->final = $resF;
    }

    public function getFinalArr(): array
    {
        return $this->final;
    }

    public function genScore(): void
    {
        $this->score = array_sum($this->final);

        if ($this->score >= 63) {
            $this->bonus = 50;
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getBonus(): int
    {
        return $this->bonus;
    }
}

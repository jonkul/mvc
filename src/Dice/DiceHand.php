<?php

declare(strict_types=1);

namespace Jonkul\Dice;



/**
 * Class DiceHand.
 */
class DiceHand
{
    private array $dices;
    private array $sumArr;
    private array $countArr;
    private int $sum;
    private int $numberD;
    private int $round;
    private int $score;
    private int $count;
    private int $rolls;

    public function __construct($numberD = 5, $round = 1)
    {
        for ($i = 0; $i < $numberD; $i++) {
            $this->dices[$i] = new Dice();
            $this->setNumberD($numberD);
        }
        $this->sum = 0;
        $this->round = $round;
        $this->score = 0;
        $this->count = 0;
        $this->rolls = 0;

    }

    public function roll(): void
    {
        $this->sum = 0;
        for ($i = 0; $i < count($this->dices); $i++) {
            $this->dices[$i]->roll();
            $this->sum += $this->dices[$i]->getLastRoll();
        }
        $this->rolls += 1;
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

    public function getLastRollArrS(): array
    {
        $res = [];
        for ($i = 0; $i < $this->numberD; $i++) {
            if ($this->dices[$i]->getSaved() === true) {
                $res[] = $this->dices[$i]->getLastRoll() . "s";
            } elseif ($this->dices[$i]->getSaved() === false) {
                $res[] = $this->dices[$i]->getLastRoll();
            }
        }
        return $res;
    }

    public function getLastSum(): int
    {
        return $this->sum;
    }

    public function getRolls(): int
    {
        return $this->rolls;
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

    public function graphicHandStr(): string
    {
        $res = "<p class='dice-utf8'>";
            for ($i = 0; $i < $this->numberD; $i++) {
                $res .= '<i class="dice-' . $this->dices[$i]->getLastRoll() . '"></i> ';
            }
        $res = rtrim($res, " ");
        $res .= "</p>";

        return $res;
    }

    public function graphicHandArr(): array
    {
        $resS = [];
        for ($i = 0; $i < count($this->dices); $i++) {
            $resS[$i] = $this->dices[$i];
        }
        return $resS;
    }

    public function setSaved($d): void
    {
        $this->dices[$d]->setSaved(true);
    }

    public function getAllSaved(): bool
    {
        $as = true;
        for ($i = 0; $i < count($this->dices); $i++) {
            if ($this->dices[$i]->getSaved() === false) {
                $as = false;
            }
        }
        return $as;
    }


    public function setScore(): void
    {
        $this->score = 0;
        for ($i = 0; $i < count($this->dices); $i++) {
            if ($this->dices[$i]->getLastRoll() === $this->round) {
                $this->score += $this->dices[$i]->getLastRoll();
            }
        }
    }

    public function getCount(): int
    {
        return $this->count;
    }


    public function setCount(): void
    {
        $this->count = 0;
        for ($i = 0; $i < count($this->dices); $i++) {
            if ($this->dices[$i]->getLastRoll() === $this->round) {
                $this->count += 1;
            }
        }
    }

    public function getScore(): int
    {
        return $this->score;
    }


    public function setCountArr(): void
    {
        $tempA = $this->getLastRollArr();
        $this->countArr = array_count_values($tempA);
    }


    public function getCountArr(): array
    {
        return $this->countArr;
    }


    public function setSumArr($n): void
    {
        $tempA = $this->getLastRollArr();
        $this->sumArr[$n] = array_sum($tempA);
    }


    public function getSumArr(): array
    {
        return $this->sumArr;
    }


}

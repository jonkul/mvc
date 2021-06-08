<?php

declare(strict_types=1);

namespace Jonkul\Dice;

use function Mos\Functions\{
    redirectTo,
    renderView,
    sendResponse,
    url
};

use Jonkul\Dice\Dice;
use Jonkul\Dice\GraphicalDice;
use Jonkul\Dice\DiceHand;

/**
 * Class Game.
 */
class Game
{
    public function playGame()
    {
        $data = [
            "header" => "A showcase of some Dice functions",
            "message" => "",
        ];

        $die = new Dice();
        $die->roll();

        $gDie = new GraphicalDice();
        $gDie->roll();

        $diceHand = new DiceHand(2);
        $diceHand->roll();

        $data["dieLastRoll"] = $die->getLastRoll();
        $data["gDieLastRoll"] = $gDie->getLastRoll();
        $data["gDieLastRollG"] = $gDie->graphic();
        $data["diceHandRoll"] = $diceHand->getLastRollStr();

        $diceHand->roll();
        $data["diceHandRoll1"] = $diceHand->getLastRollStr();

        return $data;

        /* $body = renderView("layout/dice.php", $data);
        sendResponse($body); */
    }
}

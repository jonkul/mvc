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
    public function playGame(): void
    {
        $data = [
            "header" => "A showcase of some Dice functions",
            "message" => "",
        ];

        $die = new Dice();
        //$die->setSides(60);
        $die->roll();

        $gDie = new GraphicalDice();
        //$die->setSides(60);
        $gDie->roll();

        $diceHand = new DiceHand(2);
        //$diceHand->setSides(60);
        //$diceHand->setNumberD(6);
        $diceHand->roll();

        $data["dieLastRoll"] = $die->getLastRoll();
        $data["gDieLastRoll"] = $gDie->getLastRoll();
        $data["gDieLastRollG"] = $gDie->graphic();
        $data["diceHandRoll"] = $diceHand->getLastRoll();

        $diceHand->roll();
        $data["diceHandRoll1"] = $diceHand->getLastRoll();

        $body = renderView("layout/dice.php", $data);
        sendResponse($body);
    }
}

<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

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
 * Controller for a sample route an controller class.
 */
class Game
{
    public function playGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

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

        $body = renderView("layout/dice.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}

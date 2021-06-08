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
class Yatzy
{
    public function playGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        //set 5 dice as default number
        if (!isset($_SESSION["dieNum"])) {
            $_SESSION["dieNum"] = 5;
        }

        $data = [
            "header" => "Some functions for the Yatzy game",
            "message" => "",
        ];

        //create new dicehand unless already done
        if (!isset($_SESSION["DiceHand"])) {
            $_SESSION["DiceHand"] = new DiceHand(intval($_SESSION["dieNum"]));
            $_SESSION["DiceHand"]->roll();
        }

        $_SESSION["DiceHandRoll"] = $_SESSION["DiceHand"]->getLastRollStr();

        $_SESSION["DiceHand"]->roll();
        $_SESSION["DiceHandRoll2g"] = $_SESSION["DiceHand"]->graphicHand();
        $_SESSION["DiceHandRoll2"] = $_SESSION["DiceHand"]->getLastRollStr();
        $_SESSION["DiceHandRoll3"] = $_SESSION["DiceHand"]->getLastRollArr();

        $_SESSION["DiceHand"]->setSaved(1);
        $_SESSION["DiceHand"]->setSaved(2);
        $_SESSION["DiceHandSaved"] = $_SESSION["DiceHand"]->getSavedArr();

        $_SESSION["DiceHandRoll4"] = $_SESSION["DiceHand"]->getLastRollArr();

        $_SESSION["DiceHand"]->setFinal();
        $_SESSION["DiceHandRoll5"] = $_SESSION["DiceHand"]->getFinalArr();

        $_SESSION["DiceHand"]->genScore();
        $_SESSION["DiceHandScore"] = $_SESSION["DiceHand"]->getScore();
        $_SESSION["DiceHandBonus"] = $_SESSION["DiceHand"]->getBonus();

        $body = renderView("layout/yatzy.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}

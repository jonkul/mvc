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
class YatzyF
{
    public function playGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $tally = [];
        $round = 0;

        //set 5 dice as default number
        if (!isset($_SESSION["numberD"])) {
            $_SESSION["numberD"] = 5;
        }

        //set 1 default round
        if (!isset($_SESSION["round"])) {
            $_SESSION["round"] = 1;
            $round = $_SESSION["round"];
        }

        $data = [
            "header" => "Some functions for the Yatzy game",
            "message" => "",
        ];

        //create new dicehand unless already done
        /* if (!isset($_SESSION["DiceHand" . $round])) { */
            $_SESSION["DiceHand" . $round] = new DiceHand($_SESSION["numberD"], $_SESSION["round"]);
            $_SESSION["DiceHand" . $round]->roll();
        /* } */

        $_SESSION["DiceHandRollS"] = $_SESSION["DiceHand" . $round]->getLastRollStr();
        $_SESSION["DiceHandRollAS"] = $_SESSION["DiceHand" . $round]->getLastRollArrS();

        $_SESSION["DiceHand" . $round]->setSaved(4);

        $_SESSION["DiceHand" . $round]->roll();

        $_SESSION["DiceHandRollS2"] = $_SESSION["DiceHand" . $round]->getLastRollStr();
        $_SESSION["DiceHandRollAS2"] = $_SESSION["DiceHand" . $round]->getLastRollArrS();

        $_SESSION["DiceHand" . $round]->setSaved(1);
        $_SESSION["DiceHand" . $round]->setSaved(2);

        $_SESSION["DiceHand" . $round]->roll();

        $_SESSION["DiceHandRollS3"] = $_SESSION["DiceHand" . $round]->getLastRollStr();
        $_SESSION["DiceHandRollAS3"] = $_SESSION["DiceHand" . $round]->getLastRollArrS();

        $_SESSION["DiceHand" . $round]->setCount();
        $_SESSION["DiceHandCount"] = $_SESSION["DiceHand" . $round]->getCount();
        $_SESSION["DiceHand" . $round]->setScore();
        $_SESSION["DiceHandScore"] = $_SESSION["DiceHand" . $round]->getScore();

        $tally[$_SESSION["round"]] = $_SESSION["DiceHandCount"];
        $_SESSION["DiceHandCountArr"] = $tally;

        $body = renderView("layout/yatzyF.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}

<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    redirectTo,
    renderView,
    sendResponse,
    url,
    destroySession
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

        if (!isset($_SESSION["tally"])) {
            $_SESSION["tally"] = [];
        }        
        
        //set 5 dice as default amount
        if (!isset($_SESSION["numberD"])) {
            $_SESSION["numberD"] = 5;
        }

        //set 1 default round if not already set
        if (!isset($_SESSION["round"])) {
            $_SESSION["round"] = 1;
        }

        //if set, get DiceHand $rolls + getLastRoll + getAllSaved
        if (isset($_SESSION["DiceHand" . $_SESSION["round"]])) {
            $_SESSION["rolls"] = $_SESSION["DiceHand" . $_SESSION["round"]]->getRolls();
            $_SESSION["DiceHandRollAS"] = $_SESSION["DiceHand" . $_SESSION["round"]]->getLastRollArrS();
            $_SESSION["allSaved"] = $_SESSION["DiceHand" . $_SESSION["round"]]->getAllSaved();
            $rolls = $_SESSION["rolls"];
        }
        
        //set initial status message
        if (!isset($_SESSION["status"])) {
            $_SESSION["status"] = "This is a simple Yatzy game. You will play six rounds, each with three rolls. For the first round, try to get as many ones as possible, for the second as many twos as possible, and so on. Roll to begin!";
        }

        // generate summay of round if it's done
        if (isset($_SESSION["DiceHand" . $_SESSION["round"]])) {
            if ($_SESSION["rolls"] > 2 || $_SESSION["allSaved"] === true) {
                $_SESSION["DiceHand" . $_SESSION["round"]]->setCount();
                $_SESSION["DiceHandCount"] = $_SESSION["DiceHand" . $_SESSION["round"]]->getCount();
                $_SESSION["DiceHand" . $_SESSION["round"]]->setScore();
                $_SESSION["DiceHandScore"] = $_SESSION["DiceHand" . $_SESSION["round"]]->getScore();
                $_SESSION["DiceHand" . $_SESSION["round"]]->setSumArr($_SESSION["round"]);
                $_SESSION["DiceHandSum"] = $_SESSION["DiceHand" . $_SESSION["round"]]->getSumArr();

                $_SESSION["tally"][$_SESSION["round"]] = $_SESSION["DiceHandCount"];
                $_SESSION["DiceHandCountArr"] = $_SESSION["tally"];
                
                $_SESSION["DiceHandTotal"] = 0;
                foreach ($_SESSION["DiceHandCountArr"] as $key=>$value) {
                    $_SESSION["DiceHandTotal"] += $key * $value;
                }

                $_SESSION["DiceHandBonus"] = null;
                if ($_SESSION["DiceHandTotal"] >= 63) {
                    $_SESSION["DiceHandBonus"] = 50;
                    $_SESSION["DiceHandFinal"] = $_SESSION["DiceHandBonus"] + $_SESSION["DiceHandTotal"];
                }

                // update status message depending on progress
                if (($_SESSION["rolls"] > 2 || $_SESSION["allSaved"] === true) && $_SESSION["round"] > 5) {
                    $_SESSION["status"] = "This game is over! Press reset to start a new one.";
                }
                elseif (($_SESSION["rolls"] > 2 || $_SESSION["allSaved"] === true) && $_SESSION["round"] < 6) { 
                    $_SESSION["status"] = "This round is over, press the link to start the next one!";
                }
            }
        }

        

        $data = [
            "header" => "A Yatzy Game",
            "message" => "",
        ];

        

        $body = renderView("layout/yatzy.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }





    
    public function roll(): ResponseInterface
    {
        if (!isset($_SESSION["DiceHand" . $_SESSION["round"]])) {
            $_SESSION["DiceHand" . $_SESSION["round"]] = new DiceHand($_SESSION["numberD"], $_SESSION["round"]);
        }
        $_SESSION["DiceHand" . $_SESSION["round"]]->roll();

        $_SESSION["status"] = "Nice roll! Click a die to save it from rerolling on your next roll. If you save all dice or roll three times, the game will progress.";

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function round(): ResponseInterface
    {
        $_SESSION["round"]++;
        $_SESSION["rolls"] = 0;
        $_SESSION["DiceHandRollAS"] = null;
        $_SESSION["DiceHandCountArr"] = null;
        $_SESSION["DiceHandScore"] = null;
        $_SESSION["DiceHandCount"] = null;
        $_SESSION["allSaved"] = null;

        $_SESSION["status"] = "Great, time for a new round! Click to begin rolling again.";

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function reset(): ResponseInterface
    {
        destroySession();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function save0(): ResponseInterface
    {
        $_SESSION["DiceHand" . $_SESSION["round"]]->setSaved(0);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function save1(): ResponseInterface
    {
        $_SESSION["DiceHand" . $_SESSION["round"]]->setSaved(1);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function save2(): ResponseInterface
    {
        $_SESSION["DiceHand" . $_SESSION["round"]]->setSaved(2);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function save3(): ResponseInterface
    {
        $_SESSION["DiceHand" . $_SESSION["round"]]->setSaved(3);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function save4(): ResponseInterface
    {
        $_SESSION["DiceHand" . $_SESSION["round"]]->setSaved(4);

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }
}

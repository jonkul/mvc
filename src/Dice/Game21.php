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
class Game21
{
    public function playGame21(): void
    {
        //set 1 die as default number
        if (!isset($_SESSION["numberD"])) {
            $_SESSION["numberD"] = "1";
        }

        if (!isset($_SESSION["hold"])) {
            $_SESSION["hold"] = 0;
        }

        if (!isset($_SESSION["pwin"])) {
            $_SESSION["pwin"] = 0;
        }

        if (!isset($_SESSION["cpuwin"])) {
            $_SESSION["cpuwin"] = 0;
        }
        
        $data = [
            "header" => "Game 21",
            "message" => "A little PHP Black Jack game",
            "action" => url("/dice21/process"),
            "numberD" => $_SESSION["numberD"] ?? null,
            "hold" => $_SESSION["hold"] ?? null
        ];

        //create new dicehand unless already done
        if (!isset($_SESSION["playerDH"])) {
            $_SESSION["playerDH"] = new DiceHand(intval($_SESSION["numberD"]));
            $_SESSION["playerDH"]->roll();
            $_SESSION["playerDHLastSumTot"] = 0;

            $data["playerDH"] = $_SESSION["playerDH"];
            $data["playerDHLastRoll"] = $_SESSION["playerDH"]->getLastRoll();
        }

        //if throw has been clicked and progress < 21, roll
        if ($_SESSION["throw"] === 1) {
            
            //roll if hold not pressed
            if ($_SESSION["hold"] === 0 && $_SESSION["playerDHLastSumTot"] < 21) {
                $_SESSION["playerDH"]->roll();
                $_SESSION["playerDHLastSumTot"] += $_SESSION["playerDH"]->getLastSum();
            }
            $data["throw"] = 1;   
        }

        //if progress >= 21 or hold
        if ($_SESSION["hold"] === 1 || $_SESSION["playerDHLastSumTot"] >= 21) {
            $_SESSION["prolled"] = 1;
            if ($_SESSION["playerDHLastSumTot"] === 21) {
                $_SESSION["status"] = "<h1>Congratulations, 21!</h1>" . " You did well, now let's see what the cpu throws!";
                $_SESSION["playerDHFinalSumTot"] = $_SESSION["playerDHLastSumTot"];
                $_SESSION["playerClose"] = 21 - $_SESSION["playerDHFinalSumTot"];
                $data["playerDHFinalSumTot"] = $_SESSION["playerDHFinalSumTot"];
                $data["playerClose"] = $_SESSION["playerClose"];
                $data["status"] = $_SESSION["status"];
            } elseif ($_SESSION["playerDHLastSumTot"] > 21) {
                $_SESSION["status"] = "You exceeded 21 and lost the round. =(";
                $_SESSION["playerDHFinalSumTot"] = $_SESSION["playerDHLastSumTot"];
                
                if (!isset($_SESSION["cpuwon"])) {
                    $_SESSION["cpuwin"] += 1;
                    $_SESSION["cpuwon"] = 1;
                }

                $data["playerDHFinalSumTot"] = $_SESSION["playerDHFinalSumTot"];
                $data["status"] = $_SESSION["status"];
                $data["cpuwin"] = $_SESSION["cpuwin"];
                $data["cpuwon"] = $_SESSION["cpuwon"];

            } elseif ($_SESSION["playerDHLastSumTot"] < 21) {
                $_SESSION["playerDHFinalSumTot"] = $_SESSION["playerDHLastSumTot"];
                $_SESSION["playerClose"] = 21 - $_SESSION["playerDHFinalSumTot"];
                $_SESSION["status"] = "You held at " . $_SESSION["playerDHFinalSumTot"] .
                    ", which is " . $_SESSION["playerClose"] . " from 21";
                $data["playerDHFinalSumTot"] = $_SESSION["playerDHFinalSumTot"];
                $data["status"] = $_SESSION["status"];
                $data["playerClose"] = $_SESSION["playerClose"];
            }
        }




        //computer roll if player done
        if (isset($_SESSION["playerClose"]) && isset($_SESSION["cthrow"])) {
            //create new cpudicehand unless already done
            if (!isset($_SESSION["cpuDH"])) {
                $_SESSION["cpuDH"] = new DiceHand(intval($_SESSION["numberD"]));
                $_SESSION["cpuDH"]->roll();
                $_SESSION["cpuDHLastSumTot"] = 0;
                $_SESSION["cpuDHFinalSumTot"] = $_SESSION["cpuDHLastSumTot"];
                $_SESSION["cpuClose"] = 21 - $_SESSION["cpuDHFinalSumTot"];

                $data["cpuDH"] = $_SESSION["cpuDH"];
                $data["cpuDHLastRoll"] = $_SESSION["cpuDH"]->getLastRoll();
                $data["cpuDHLastSumTot"] = $_SESSION["cpuDHLastSumTot"];
                $data["cpuDHFinalSumTot"] = $_SESSION["cpuDHLastSumTot"];
                $data["cthrow"] = $_SESSION["cthrow"];
            }

            //cpu roll until win or lose
            while ($_SESSION["cpuClose"] > $_SESSION["playerClose"] && $_SESSION["cpuDHLastSumTot"] < 21) {
                $_SESSION["cpuDH"]->roll();
                $_SESSION["cpuDHLastSumTot"] += $_SESSION["cpuDH"]->getLastSum();
                $_SESSION["cpuDHFinalSumTot"] = $_SESSION["cpuDHLastSumTot"];
                $_SESSION["cpuClose"] = 21 - $_SESSION["cpuDHFinalSumTot"];
                $_SESSION["crolled"] = 1;

                $data["cpuDH"] = $_SESSION["cpuDH"];
                $data["cpuDHLastRoll"] = $_SESSION["cpuDH"]->getLastRoll();
                $data["cpuDHLastSumTot"] = $_SESSION["cpuDHLastSumTot"];
                $data["cpuDHFinalSumTot"] = $_SESSION["cpuDHLastSumTot"];
            }

                

            //check who won
            if (isset($_SESSION["crolled"]) && $_SESSION["prolled"] === 1) {
                if ($_SESSION["cpuClose"] === $_SESSION["playerClose"]) {
                    $_SESSION["status"] = "You threw the same as the CPU and lost the round. =(";
                    
                    if (!isset($_SESSION["cpuwon"])) {
                        $_SESSION["cpuwin"] += 1;
                        $_SESSION["cpuwon"] = 1;
                    }

                    $data["status"] = $_SESSION["status"];
                    $data["cpuwin"] = $_SESSION["cpuwin"];
                    $data["cpuwon"] = $_SESSION["cpuwon"];

                } elseif ($_SESSION["cpuDHFinalSumTot"] > 21) {
                    $_SESSION["status"] = "Computer thew " . $_SESSION["cpuDHFinalSumTot"] .
                        ", which is more than 21. You won!";
                    
                    if (!isset($_SESSION["pwon"])) {
                        $_SESSION["pwin"] += 1;
                        $_SESSION["pwon"] = 1;
                    }

                    $data["status"] = $_SESSION["status"];
                    $data["pwin"] = $_SESSION["pwin"];
                    $data["pwon"] = $_SESSION["pwon"];

                } elseif ($_SESSION["cpuClose"] < $_SESSION["playerClose"]) {
                    $_SESSION["status"] = "The computer thew closer to 21, you lost the round. =(";
                    
                    if (!isset($_SESSION["cpuwon"])) {
                        $_SESSION["cpuwin"] += 1;
                        $_SESSION["cpuwon"] = 1;
                    }

                    $data["status"] = $_SESSION["status"];
                    $data["cpuwin"] = $_SESSION["cpuwin"];
                    $data["cpuwon"] = $_SESSION["cpuwon"];
                }
                $_SESSION["rounddone"] = 1;
                $data["rounddone"] = $_SESSION["rounddone"];

                $_SESSION["cpuDHLastRoll"] = $_SESSION["cpuDH"]->getLastRoll();
                $_SESSION["cpuDHLastSum"] = $_SESSION["cpuDH"]->getLastSum();

                $data["cpuDHLastRoll"] = $_SESSION["cpuDHLastRoll"];
                $data["cpuDHLastSum"] = $_SESSION["cpuDHLastSum"];
                $data["cpuDHLastSumTot"] = $_SESSION["cpuDHLastSumTot"];
            }
            
        }

        $_SESSION["playerDHLastRoll"] = $_SESSION["playerDH"]->getLastRoll();
        $_SESSION["playerDHLastSum"] = $_SESSION["playerDH"]->getLastSum();

        $data["playerDHLastRoll"] = $_SESSION["playerDHLastRoll"];
        $data["playerDHLastSum"] = $_SESSION["playerDHLastSum"];
        $data["playerDHLastSumTot"] = $_SESSION["playerDHLastSumTot"];

        $data["pwin"] = $_SESSION["pwin"];
        $data["cpuwin"] = $_SESSION["cpuwin"];

        $body = renderView("layout/dice21.php", $data);
        sendResponse($body);
        $_SESSION["throw"] = 0;
        /* redirectTo(url("/dice21")); */
    }
}

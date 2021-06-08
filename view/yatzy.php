<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;


$header = $header ?? null;
$message = $message ?? null;

$urlR = url("/yatzy/roll");
$urlS = url("/yatzy/save");
$urlRU = url("/yatzy/round");
$urlRE = url("/yatzy/reset");

$status = $_SESSION["status"] ?? null;
$round = $_SESSION["round"] ?? null;
$rolls = $_SESSION["rolls"] ?? null;
$diceHandRollAS = $_SESSION["DiceHandRollAS"] ?? null;
$allSaved = $_SESSION["allSaved"] ?? null;

$diceHandCountArr = $_SESSION["DiceHandCountArr"] ?? null;
$diceHandSum = $_SESSION["DiceHandSum"] ?? null;
$diceHandScore = $_SESSION["DiceHandScore"] ?? null;
$diceHandCount = $_SESSION["DiceHandCount"] ?? null;
$diceHandTotal = $_SESSION["DiceHandTotal"] ?? null;
$diceHandBonus = $_SESSION["DiceHandBonus"] ?? null;
$diceHandFinal = $_SESSION["DiceHandFinal"] ?? null;


?><h1><?= $header ?></h1>

<!-- Render what the current round is, and rolls if > 0 -->
<?php if ($rolls === 0 || $rolls === null) : ?>
    <h3>Round <?= $round ?> </h3>
<?php elseif ($rolls > 0) : ?>
    <h3>Round <?= $round ?>, roll <?= $rolls ?></h3>
<?php endif; ?>

<!-- <p><?= $message ?></p> -->

<!-- Status message -->
<p><?= $status ?></p>
<br>

<!-- Render roll link if $rolls < 3 AND allSaved = false, otherwise next round link, or reset game link if done -->
<?php if ($rolls < 3 && $allSaved !== true) : ?>
    <h3><a href="<?= $urlR ?>">Roll!</a></h3>
<?php elseif (($rolls > 2 || $allSaved === true) && $round < 6) : ?>
    <h3><a href="<?= $urlRU ?>">Next round</a></h3>
<?php elseif (($rolls > 2 || $allSaved === true) && $round > 5) : ?>
    <h3><a href="<?= $urlRE ?>">Start over</a></h3>
<?php endif; ?>



<!-- Render last hand throw if it exists yet -->
<?php if ($diceHandRollAS !== null) : ?>
        <p>You roll:</p>
        <p class='dice-utf8'>
            <?php for ($i = 0; $i < count($diceHandRollAS); $i++) : ?>
                <a href="<?= $urlS . $i ?>"><i class="dice-<?= $diceHandRollAS[$i] ?> "></i></a>
            <?php endfor; ?>
        </p>
<?php endif; ?>


<!-- Render summary of round if $rolls > 2 OR allSaved = true, as well as a total tally of all rounds -->
<?php if ($rolls > 2 || $allSaved === true) : ?>
    <h3>Summary</h3>
    <p>Count for this round (number of <?= $round ?>s rolled): <?= $diceHandCount ?> </p>
    <p>Total sum for this round (sum of all <?= $round ?>s rolled): <?= $diceHandScore ?> </p>


    <h3>Tally</h3>
    <?php
    foreach($diceHandCountArr as $key=>$value)
        {
            $sum = $key * $value;
            echo " " . $key . ": " . $value . " &rarr; " . $sum. '<br>';
        }
    echo "<br>" . "Total: " . $diceHandTotal;
    ?>

    <!-- Render bonus if any -->
    <?php if ($diceHandBonus !== null) : ?>
        <h3>Bonus</h3>
            <p>Your total was higher than 63, you get 50 bonus points!</p>
            <p>
                Your new total is <?= $diceHandFinal ?>.
            </p>
    <?php endif; ?>

<br>

<?php endif; ?>

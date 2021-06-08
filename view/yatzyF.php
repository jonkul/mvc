<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

$round = $_SESSION["round"] ?? null;
$diceHandRollS = $_SESSION["DiceHandRollS"] ?? null;
$diceHandRollAS = $_SESSION["DiceHandRollAS"] ?? null;
$diceHandRollS2 = $_SESSION["DiceHandRollS2"] ?? null;
$diceHandRollAS2 = $_SESSION["DiceHandRollAS2"] ?? null;
$diceHandRollS3 = $_SESSION["DiceHandRollS3"] ?? null;
$diceHandRollAS3 = $_SESSION["DiceHandRollAS3"] ?? null;
$diceHandCountArr = $_SESSION["DiceHandCountArr"] ?? null;
$diceHandSum = $_SESSION["DiceHandSum"] ?? null;
$diceHandScore = $_SESSION["DiceHandScore"] ?? null;
$diceHandCount = $_SESSION["DiceHandCount"] ?? null;
/* $diceHandRolls = $_SESSION["DiceHand1"]->getRolls() ?? null; */


?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<h3>Round <?= $round ?></h3>
<p>Roll as many <?= $round ?>s as you can!</p>

<br>

<!-- <h4>Roll <?= $diceHandRolls ?></h4> -->
    <h4>Roll 1</h4>
    <p>Function generates and returns string</p>
    <p><?= $diceHandRollS ?></p>

    <p>Function generates and returns array, converted to utf8 by view</p>
    <p class='dice-utf8'>
    <?php for ($i = 0; $i < count($diceHandRollAS); $i++) : ?>
        <i class="dice-<?= $diceHandRollAS[$i] ?> "></i>
    <?php endfor; ?>

<br><br>

<h4>Roll 2</h4>
    <p>Die [4] saved from last roll.</p>
    <p>Function generates and returns string</p>
    <p><?= $diceHandRollS2 ?></p>

    <p>Function generates and returns array, converted to utf8 by view</p>
    <p class='dice-utf8'>
    <?php for ($i = 0; $i < count($diceHandRollAS2); $i++) : ?>
        <i class="dice-<?= $diceHandRollAS2[$i] ?> "></i>
    <?php endfor; ?>

<br><br>

<h4>Roll 3</h4>
    <p>Dice [1] and [2] saved from last roll.</p>
    <p>Function generates and returns string</p>
    <p><?= $diceHandRollS3 ?></p>

    <!-- <p>Function generates and returns array, converted to utf8 by view</p>
    <p class='dice-utf8'>
    <?php for ($i = 0; $i < count($diceHandRollA3); $i++) : ?>
        <i class="dice-<?= $diceHandRollA3[$i] ?>"></i>
    <?php endfor; ?> -->

    <p>Function generates and returns array, converted to utf8 by view, saved dice green</p>
    <p class='dice-utf8'>
    <?php for ($i = 0; $i < count($diceHandRollAS3); $i++) : ?>
        <i class="dice-<?= $diceHandRollAS3[$i] ?>"></i>
    <?php endfor; ?>


<br><br>

<h4>Summary</h4>
    <p>Final hand:</p>
    <p class='dice-utf8'>
    <?php for ($i = 0; $i < count($diceHandRollAS3); $i++) : ?>
        <i class="dice-<?= $diceHandRollAS3[$i] ?> "></i>
    <?php endfor; ?>

    <p>Count for this round (number of <?= $round ?> rolled): </p>
    <p><?= $diceHandCount ?></p>

    <p>Total sum for this round (sum of all <?= $round ?>s rolled): </p>
    <p><?= $diceHandScore ?></p>

<br>

<h4>Tally</h4>
    <!-- <p>Number and sum of each value:</p>
    <p>1: <?= $diceHandCountArr[1] ?? 0 ?> &rarr; <?= ($diceHandCountArr[1] ?? 0) * 1 ?></p>
    <p>2: <?= $diceHandCountArr[2] ?? 0 ?> &rarr; <?= ($diceHandCountArr[2] ?? 0) * 2 ?></p>
    <p>3: <?= $diceHandCountArr[3] ?? 0 ?> &rarr; <?= ($diceHandCountArr[3] ?? 0) * 3 ?></p>
    <p>4: <?= $diceHandCountArr[4] ?? 0 ?> &rarr; <?= ($diceHandCountArr[4] ?? 0) * 4 ?></p>
    <p>5: <?= $diceHandCountArr[5] ?? 0 ?> &rarr; <?= ($diceHandCountArr[5] ?? 0) * 5 ?></p>
    <p>6: <?= $diceHandCountArr[6] ?? 0 ?> &rarr; <?= ($diceHandCountArr[6] ?? 0) * 6 ?></p>

<br><br> -->

<!-- loop instead -->
<?php
    $total = 0;
    foreach($diceHandCountArr as $key=>$value)
        {
            $sum = $key * $value;
            echo " " . $key . ": " . $value . " &rarr; " . $sum. '<br>';
            $total += $sum;
        }
    echo "<br>" . "Total: " . $total;
?>
<br><br>

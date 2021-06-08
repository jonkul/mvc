<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

$diceHandRoll = $_SESSION["DiceHandRoll"] ?? null;
$diceHandRoll2 = $_SESSION["DiceHandRoll2"] ?? null;
$diceHandRoll2g = $_SESSION["DiceHandRoll2g"] ?? null;
$diceHandRoll3 = $_SESSION["DiceHandRoll3"] ?? null;
$diceHandSaved = $_SESSION["DiceHandSaved"] ?? null;
$diceHandRoll4 = $_SESSION["DiceHandRoll4"] ?? null;
$diceHandRoll5 = $_SESSION["DiceHandRoll5"] ?? null;
$diceHandScore = $_SESSION["DiceHandScore"] ?? null;
$diceHandBonus = $_SESSION["DiceHandBonus"] ?? null;

?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<h2>DiceHand</h2>
<h4>Roll 1</h4>
<p>Function generates and returns string</p>
<p><?= $diceHandRoll ?></p>
<br>
<h4>Roll 2</h4>
<p>Throw #2</p>
<p><?= $diceHandRoll2 ?></p>
<br><br>
<h4>Roll 2 graphicHand</h4>
<p>Function generates and returns HTML</p>
<?= $diceHandRoll2g ?>
<br><br>
<h4>Roll 2 graphicHandArr</h4>
<p>var_dump of the roll returned as array</p>
<pre>
<?=
    var_dump($diceHandRoll3);
?>
</pre>
<br><br><br>
<h4>Roll 2 graphicHandArr[0]</h4>
<p>Specific value from the array</p>
<?=
    $diceHandRoll3[0];
?>
<br><br><br>
<h4>Roll 2 graphicHandArrLooped</h4>
<p>Function generates and returns an array, view loops through it and generates HTML</p>

<p class='dice-utf8'>
<?php for ($i = 0; $i < count($diceHandRoll3); $i++) : ?>
    <i class="dice-<?= $diceHandRoll3[$i] ?> "></i>
<?php endfor; ?>

<br><br><br>
<h4>Session</h4>
<p>var_dump of the session</p>
<!-- <pre>
    <?=
        var_dump(session_name());
        var_dump($_SESSION);
    ?>
</pre> -->

<br><br><br>
<h4>Saved 1, 2</h4>
<p>These two dice were saved:</p>

<pre>
$_SESSION["DiceHand"]->setSaved(1);
$_SESSION["DiceHand"]->setSaved(2);
</pre>

<p class='dice-utf8'>
<?php for ($i = 0; $i < count($diceHandSaved); $i++) : ?>
    <i class="dice-<?= $diceHandSaved[$i] ?> "></i>
<?php endfor; ?>

<br><br><br>
<h4>Roll 2 graphicHandArrLooped - after saved</h4>
<p>Function generates and returns an array, view loops through it and generates HTML</p>

<p class='dice-utf8'>
<?php for ($i = 0; $i < count($diceHandRoll4); $i++) : ?>
    <i class="dice-<?= $diceHandRoll4[$i] ?> "></i>
<?php endfor; ?>

<br><br><br>
<h4>Roll 2 graphicHandArrLooped - after final array generated</h4>
<p>Function generates and returns an array, view loops through it and generates HTML</p>

<p class='dice-utf8'>
<?php for ($i = 0; $i < count($diceHandRoll5); $i++) : ?>
    <i class="dice-<?= $diceHandRoll5[$i] ?> "></i>
<?php endfor; ?>

<br><br><br>
<h4>Roll 2 - final score and bonus</h4>
<p>Gets score and bonus from instance</p>

<p>Final score: <?= $diceHandScore; ?></p>
<p>Final bonus: <?= $diceHandBonus; ?></p>

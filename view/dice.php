<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

?><h1><?= $header ?></h1>

<p><?= $message ?></p>

<h2>Dice</h2>

<p><?= $dieLastRoll ?></p>

<h2>GraphicalDice</h2>

<p><?= $gDieLastRoll ?></p>

<p class="dice-utf8">
    <i class="<?= $gDieLastRollG ?>"></i>
</p>

<h2>DiceHand</h2>

<p><?= $diceHandRoll ?></p>
<p><?= $diceHandRoll1 ?></p>

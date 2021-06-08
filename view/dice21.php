<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

$header = $header ?? null;
$message = $message ?? null;
$action = $action ?? null;
$output = $output ?? null;
$dieNum = $dieNum ?? null;
$url = url("/session/destroy21");
$urlC = url("/dice21/clear");
$urlLC = url("/dice21/clearL");
$urlT = url("/dice21/throw");
$urlH = url("/dice21/hold");
$urlTC = url("/dice21/cthrow");
$playerDHLastRoll = $playerDHLastRoll ?? null;
$playerDHLastSum = $playerDHLastSum ?? null;
$playerDHLastSumTot = $playerDHLastSumTot ?? null;
$playerDHFinalSumTot = $playerDHFinalSumTot ?? null;
$throw = $_SESSION["throw"] ?? null;
$hold = $_SESSION["hold"] ?? null;
$status = $status ?? null;
$playerClose = $playerClose ?? null;
$cpuwin = $cpuwin ?? null;
$cpuwon = $cpuwon ?? null;
$pwin = $pwin ?? null;
$pwon = $pwon ?? null;
$cthrow = $cthrow ?? null;
$cpuDHLastRoll = $cpuDHLastRoll ?? null;
$cpuDHLastSum = $cpuDHLastSum ?? null;
$cpuDHLastSumTot = $cpuDHLastSumTot ?? null;
$cpuDHFinalSumTot = $cpuDHFinalSumTot ?? null;
$rounddone = $rounddone ?? null;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<?php if ($cpuwin > 0 || $pwin > 0) : ?>
    <p><a href="<?= $urlLC ?>">Reset the standing</a></p>
    <h2>Standing:</h2>
    <p>Rounds played: <?= $pwin + $cpuwin ?></p>
    <p>Player wins: <?= $pwin ?></p>
    <p>CPU wins: <?= $cpuwin ?></p>
    
<?php endif; ?>

<?php if ($dieNum === null) : ?>
    <p>
        <output>
            Select number of dice to throw!<br>Current choice: '<?= htmlentities($dieNum ?? "1") ?>'
        </output>
    </p>

    <form method="post" action="<?= $action ?>">
        <p>
            <input type="number" name="content" placeholder="Choose # of die" min="1" max="2" value="<?= htmlentities($dieNum ?? "1") ?>" onkeydown="return false">
            <input type="submit" value="Press me">
        </p>
    </form>

<?php elseif ($dieNum !== null) : ?>
    <!-- <p>
        <output>Current choice of number of dice to throw: <?= htmlentities($dieNum) ?></output>
    </p> -->

    <?php if ($playerDHLastSumTot < 21 && $hold == 0) : ?>
        <h3><a href="<?= $urlT ?>">Throw <?= htmlentities($dieNum) ?> dice</a></h3>
            <?php if ($playerDHLastSumTot > 0) : ?>
            <h3><a href="<?= $urlH ?>">Hold!</a></h3>
            <?php endif; ?>
    <?php endif; ?>
    
    <?php if ($throw === 1 && $dieNum === "1") : ?>
        <h2>Result:</h2>
        <p>This throw: <?= $playerDHLastRoll ?></p>
        <p>This game so far: <?= $playerDHLastSumTot ?></p>
    <?php elseif ($throw === 1 && $dieNum === "2") : ?>
        <h2>Result:</h2>
        <p>Per die: <?= $playerDHLastRoll ?></p>
        <p>Dice total: <?= $playerDHLastSum ?></p>
        <p>This game so far: <?= $playerDHLastSumTot ?></p>
    <?php endif; ?>

    <?php if ($playerDHFinalSumTot != null || $cpuDHFinalSumTot != null) : ?>
        <h2>Status:</h2>
        <?php if ($cpuDHFinalSumTot != null) : ?>
            <p>Computer threw: <?= $cpuDHFinalSumTot ?></p>
            <p>You threw: <?= $playerDHLastSumTot ?></p>
        <?php endif; ?>
        <p><?= $status ?></p>
    <?php endif; ?>

    <?php if ($playerDHFinalSumTot != null && $cpuwon === null && $rounddone === null) : ?>
        <h3><a href="<?= $urlTC ?>">Let the CPU throw the dice</a></h3>
    <?php endif; ?>
<?php endif; ?>

<?php if ($dieNum !== null) : ?>
    <h3><a href="<?= $urlC ?>">Reset the round</a></h3>
<?php endif; ?>

<!-- <h1>Session details</h1>
<p>$_SESSION dump:</p>
<pre>
    <?php
        var_dump(session_name());
        var_dump($_SESSION);
    ?>
</pre>
<p>$data dump:</p>
<pre>
    <?php
        var_dump($data);

        $_SESSION["counter"] = 1 + ($_SESSION["counter"] ?? 0);
        $_SESSION["throw"] = 0;
    ?>
</pre>

<h2><a href="<?= $url ?>">Dump the session</a></h2> -->

<?php
$timeTarget = 0.1;
$cost = 10;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
    $diff = $end-$start;
    echo "Time: " . $diff . "<br>";
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost . "\n"
?>
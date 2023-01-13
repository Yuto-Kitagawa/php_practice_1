<?php

include(__DIR__ . '/../function/function.php');

$from = htmlspecialchars($_POST['from'], ENT_QUOTES, "UTF-8");
$merchandise_id = htmlspecialchars($_POST['merchandiseid'], ENT_QUOTES, "UTF-8");
$number = htmlspecialchars($_POST['number'], ENT_QUOTES, "UTF-8");
$payway = htmlspecialchars($_POST['payway'], ENT_QUOTES, "UTF-8");

$func = new Functions();

if ($payway == "credit") {
    $payway_index = 0;
} else if ($payway == "convenience") {
    $payway_index = 1;
}

if ($from == "item") {
    $res = $func->purchase($merchandise_id, $number, $payway_index);
}

echo (json_encode($res));

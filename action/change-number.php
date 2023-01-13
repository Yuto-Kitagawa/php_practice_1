<?php
session_start();

$merchandise_id = htmlspecialchars($_POST['merchandiseid'], ENT_QUOTES, 'UTF-8');
$direct         = htmlspecialchars($_POST['direct'],        ENT_QUOTES, 'UTF-8');

if (isset($_SESSION['cart'][$merchandise_id])) {
    $number = $_SESSION['cart'][$merchandise_id];
    if ($direct == "minus") {
        $number -= 1;
    } else if ($direct == "plus") {
        $number += 1;
    }

    if ($number < 1) {
        unset($_SESSION['cart'][$merchandise_id]);
        echo (json_encode("delete"));
    } else {
        $_SESSION['cart'][$merchandise_id] = $number;
        echo (json_encode($number));
    }
}

<?php

include(__DIR__ . '/../function/function.php');

session_start();
$cart = $_SESSION['cart'];

$func = new Functions();
$res  = $func->get_cart($cart);

echo (json_encode($res));

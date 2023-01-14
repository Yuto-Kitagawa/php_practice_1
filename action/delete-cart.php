<?php
session_start();

$merchandise_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

unset($_SESSION['cart'][$merchandise_id]);
header('Location: ./../cart.php');
exit();

<?php

include(__DIR__ . "/../function/function.php");

$merchandise_id = htmlspecialchars($_POST['merchandise_id'], ENT_QUOTES, 'UTF-8');
$action = htmlspecialchars($_POST['direct'], ENT_QUOTES, 'UTF-8');

$func = new Functions();

$res = $func->toggle_good($merchandise_id, $action);
echo (json_encode($res));

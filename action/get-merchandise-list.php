<?php
include(__DIR__ . "/../function/function.php");

$func = new Functions();
$res = $func->get_merchandise_list();

echo (json_encode($res));

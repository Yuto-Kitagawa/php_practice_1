<?php
include(__DIR__ . "/../function/function.php");

$merchandise_id = htmlspecialchars($_POST['merchandise_id'], ENT_QUOTES, "UTF-8");

$func = new Functions();
$res = $func->get_merchandise($merchandise_id);

echo (json_encode($res));
exit();

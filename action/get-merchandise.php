<?php
//function.phpをインクルード
include(__DIR__ . "/../function/function.php");

//POST送信されてきたデータを受け取る
//https://www.w3schools.com/php/php_superglobals.asp
$merchandise_id = htmlspecialchars($_POST['merchandise_id'], ENT_QUOTES, "UTF-8");

//インスタンス生成
$func = new Functions();
//引数に商品IDを指定してget_merchandise関数を実行
$res = $func->get_merchandise($merchandise_id);

// json形式で返却
echo (json_encode($res));

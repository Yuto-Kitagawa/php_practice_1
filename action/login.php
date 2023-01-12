<?php
//function.phpをインクルード
include(__DIR__ . "/../function/function.php");

//POST送信されてきたデータを受け取る
$usermail = htmlspecialchars($_POST['mail'], ENT_QUOTES, "UTF-8");
$userpassword = htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8");

//インスタンス生成
$func = new Functions();
//引数にログイン情報を指定してget_merchandise関数を実行
$res = $func->login($usermail, $userpassword);

// json形式で返却
echo (json_encode($res));

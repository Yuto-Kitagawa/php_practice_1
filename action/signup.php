<?php
//function.phpをインクルード
include(__DIR__ . "/../function/function.php");

//POST送信されてきたデータを受け取る
$username   = htmlspecialchars($_POST['username'],   ENT_QUOTES, 'UTF-8');
$number     = htmlspecialchars($_POST['number'],     ENT_QUOTES, 'UTF-8');
$mail       = htmlspecialchars($_POST['mail'],       ENT_QUOTES, 'UTF-8');
$birthday   = htmlspecialchars($_POST['birthday'],   ENT_QUOTES, 'UTF-8');
$age        = htmlspecialchars($_POST['age'],        ENT_QUOTES, 'UTF-8');
$postnumber = htmlspecialchars($_POST['postnumber'], ENT_QUOTES, 'UTF-8');
$address    = htmlspecialchars($_POST['address'],    ENT_QUOTES, 'UTF-8');
$password   = htmlspecialchars($_POST['password'],   ENT_QUOTES, 'UTF-8');

//インスタンス生成
$func = new Functions();

// checkAccount関数を実行後、ユーザー登録
$res = $func->check_account($username, $number, $mail,  $birthday, $age, $postnumber, $address, $password);

//json形式で返却
echo (json_encode($res));
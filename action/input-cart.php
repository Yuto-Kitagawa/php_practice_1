<?php
//セッションでカートを管理するための処理
session_start();

//POST送信されてきたデータを受信
$merchandise_id = htmlspecialchars($_POST['merchandise_id'], ENT_QUOTES, 'UTF-8');
$m_number = htmlspecialchars($_POST['number'], ENT_QUOTES, 'UTF-8');

//カートに商品IDと個数を代入
$_SESSION['cart'][$merchandise_id] = $m_number;

echo (json_encode("ok"));

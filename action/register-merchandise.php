<?php
//function.phpをインクルード
include(__DIR__ . "/../function/function.php");

//POST送信されてきたデータを受け取る
$m_name  = htmlspecialchars($_POST['merchandiseName'], ENT_QUOTES, 'UTF-8');
$m_price = htmlspecialchars($_POST['merchandisePrice'], ENT_QUOTES, 'UTF-8');


//======================================================================
//FILES形式のデータは$_FILESで受け取る。
//['name']には名前が、['tmp_name']には一時ファイル名が格納されています。
//function.phpで二つのデータを使用して、サーバー内のimgフォルダにアップロードしています。
//======================================================================
if (!empty($_FILES['img1']['name'])) {
    $m_img1     = $_FILES['img1']['name'];
    $m_img1_tmp = $_FILES['img1']['tmp_name'];
} else {
    $m_img1     = "";
    $m_img1_tmp = "";
}

if (!empty($_FILES['img2']['name'])) {
    if ($m_img1 == "") {
        $m_img1     = $_FILES['img2']['name'];
        $m_img1_tmp = $_FILES['img2']['tmp_name'];
    } else {
        $m_img2 = $_FILES['img2']['name'];
        $m_img2_tmp = $_FILES['img2']['tmp_name'];
    }
} else {
    $m_img2 = "";
    $m_img2_tmp = "";
}

if (!empty($_FILES['img3']['name'])) {
    if ($m_img1 == "") {
        $m_img1     = $_FILES['img3']['name'];
        $m_img1_tmp = $_FILES['img3']['tmp_name'];
    } else if ($m_img2 == "") {
        $m_img2     = $_FILES['img3']['name'];
        $m_img2_tmp = $_FILES['img3']['tmp_name'];
    } else {
        $m_img3     = $_FILES['img3']['name'];
        $m_img3_tmp = $_FILES['img3']['tmp_name'];
    }
} else {
    $m_img3     = "";
    $m_img3_tmp = "";
}

//1枚目が空ならエラーを返却
if ($m_img1 == "") {
    echo (json_encode('写真を最低1枚は登録してください。'));
    exit();
}

//POST送信されてきたデータを受け取る
$m_d_date = htmlspecialchars($_POST['merchandiseDeadlineDate'], ENT_QUOTES, 'UTF-8');
$m_d_time = htmlspecialchars($_POST['merchandiseDeadlineTime'], ENT_QUOTES, 'UTF-8');

//インスタンス生成
$func = new Functions();
// 引数に商品を登録するためのデータを指定してregister_merchandise関数を実行。
$res = $func->register_merchandise($m_name, $m_price, $m_img1, $m_img1_tmp, $m_img2, $m_img2_tmp, $m_img3, $m_img3_tmp, $m_d_date, $m_d_time);

//json形式で返却
echo (json_encode($res));

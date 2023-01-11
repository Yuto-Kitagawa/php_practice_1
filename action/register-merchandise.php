<?php
include(__DIR__ . "/../function/function.php");

$m_name = htmlspecialchars($_POST['merchandiseName'], ENT_QUOTES, 'UTF-8');
$m_price = htmlspecialchars($_POST['merchandisePrice'], ENT_QUOTES, 'UTF-8');

//最低1枚必須
if (empty($_FILES['img1']['name'])) {
    echo (json_encode('imgerr'));
    exit();
} else {
    $m_img1 = $_FILES['img1']['name'];
    $m_img1_tmp = $_FILES['img1']['tmp_name'];
}

if (!empty($_FILES['img2']['name'])) {
    $m_img2 = $_FILES['img2']['name'];
    $m_img2_tmp = $_FILES['img2']['tmp_name'];
} else {
    $m_img2 = "";
    $m_img2_tmp = "";
}

if (!empty($_FILES['img3']['name'])) {
    if ($m_img2 == "") {
        $m_img2 = $_FILES['img3']['name'];
        $m_img2_tmp = $_FILES['img3']['tmp_name'];
    } else {
        $m_img3 = $_FILES['img3']['name'];
        $m_img3_tmp = $_FILES['img3']['tmp_name'];
    }
} else {
    $m_img3 = "";
    $m_img3_tmp = "";
}

$m_d_date = htmlspecialchars($_POST['merchandiseDeadlineDate'], ENT_QUOTES, 'UTF-8');
$m_d_time = htmlspecialchars($_POST['merchandiseDeadlineTime'], ENT_QUOTES, 'UTF-8');

$func = new Functions();
$res = $func->register_merchandise($m_name, $m_price, $m_img1, $m_img1_tmp, $m_img2, $m_img2_tmp, $m_img3, $m_img3_tmp, $m_d_date, $m_d_time);

echo (json_encode($res));
exit();

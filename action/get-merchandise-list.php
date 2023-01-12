<?php
//function.phpをインクルード
include(__DIR__ . "/../function/function.php");

//インスタンス生成
$func = new Functions();
//引数なしでget_merchandise_list関数を実行
$res = $func->get_merchandise_list();

// json形式で返却
echo (json_encode($res));

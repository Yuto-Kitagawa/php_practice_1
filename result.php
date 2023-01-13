<?php
session_start();
$img_index = rand(1, 3);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>HOME</title>
</head>

<body>

    <?php
    include('./nav.php');
    ?>

    <section class="">
        <div class="d-flex flex-column-reverse flex-sm-column-reverse flex-md-row flex-lg-row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-none d-sm-none d-md-block d-lg-block">
                <img src="./img/login<?= $img_index ?>.jpg" class="login-img" width="100%" alt="">
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center justify-content-center flex-column pt-5">
                <div class="pt-5 display-6 text-center">
                    お買い上げ誠にありがとうございます。
                </div>
                <div class="lead text-center pt-5">
                    <p>
                        ご注文いただいた商品は○○運送で配達いたします。<br>
                        メールの方に注文完了のメールをお送りいたしましたのでご確認ください。<br>
                        またのご利用お待ちしております。<br>
                    </p>
                    <a href="./index.php">ホームに戻る</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-dark">
        <div class="lead text-center text-white">©all rights reserved</div>
    </footer>



    <script>
        const hidden = document.getElementById('hiddenNav');
        const toggler = document.getElementById('openSidebarMenu');
        hidden.addEventListener('click', () => {
            if (toggler.checked) {
                toggler.checked = false;
            }
        });
    </script>

</body>

</html>
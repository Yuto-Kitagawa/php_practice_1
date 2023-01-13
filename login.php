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
                <div class="">
                    <div class="lead text-center fw-bold">ログイン</div>
                    <div class="lead text-center text-danger d-none" id="err">メールアドレスかパスワードが違います。</div>
                </div>
                <div class="col-8 mx-auto mt-5 ">
                    <label for="userid">メールアドレス</label>
                    <input type="text" class="form-control" id="userid">
                </div>

                <div class="col-8 mx-auto mt-5 ">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password">
                </div>

                <div class="col-8 mx-auto mt-5  text-center">
                    <button class="btn btn-outline-dark col-12" id="submit">ログイン</button>
                </div>

                <hr class="col-8 mx-auto">
                <div class="">
                    アカウント作成の方は<a href="./signup.php">こちら</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        const hidden = document.getElementById('hiddenNav');
        const toggler = document.getElementById('openSidebarMenu');
        hidden.addEventListener('click', () => {
            if (toggler.checked) {
                toggler.checked = false;
            }
        });
    </script>

    <script>
        document.getElementById('submit').addEventListener('click', () => {
            // ログイン情報取得
            let mail = document.getElementById('userid').value;
            let password = document.getElementById('password').value;

            //XHRを使用して通信
            const login_xhr = new XMLHttpRequest();
            //送信するためのデータを格納するformdataを定義
            let fd = new FormData();
            //formdataにデータを格納
            fd.append("mail", mail);
            fd.append("password", password);

            //通信方法、通信先を定義
            login_xhr.open('post', "./action/login.php");
            // 指定したURLに通信
            login_xhr.send(fd);

            // 通信後の処理
            login_xhr.onload = (e) => {
                let json = e.target.response;
                console.log(json);
                let res = JSON.parse(json);
                if (res == "logged") {
                    location.href = "./index.php";
                } else {
                    document.getElementById('err').classList.remove('d-none');
                }
            }
        })
    </script>
</body>

</html>
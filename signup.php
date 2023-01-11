<?php
session_start();
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

    <nav>
        <div class="header w-100"></div>
        <div class="container-fluid">
            <input type="checkbox" class="openSidebarMenu navbar-brand" id="openSidebarMenu">

            <label for="openSidebarMenu" class="sidebarIconToggle">
                <div class="spinner diagonal part-1"></div>
                <div class="spinner horizontal"></div>
                <div class="spinner diagonal part-2"></div>
            </label>

            <div class="w-100 text-center">
                <a class="top text-nowrap" href="#">LOGO</a>
            </div>

            <div id="sidebarMenu">
                <ul class="sidebarMenuInner text-black fw-bold">
                    <div class="z-99">
                        <li class="logo">
                            <a href="#" class="text-white">LOGO</a>
                        </li>
                    </div>
                    <div class="z-99  d-flex justify-content-around col-12 col-sm-12 col-md-5 col-lg-5 flex-direction-menu">
                        <?php
                        if (isset($_SESSION['username'])) {
                        ?>
                            <li class="bg-black"><a href="./setting.php" class="text-white"><?= $_SESSION['username'] ?></a></li>
                            <li class="bg-black"><a href="./register-merchandise.php" class="text-white">商品登録</a></li>
                        <?php
                        } else {
                        ?>
                            <li class="bg-black"><a href="./signup.php" class="text-white">アカウント作成</a></li>
                        <?php
                        }
                        ?>
                        <li class="bg-black"><a href="#" class="text-white">Sample</a></li>
                        <li class="bg-black"><a href="#" class="text-white">Sample</a></li>
                    </div>
                </ul>
                <div class="hidden-nav-menu" id="hiddenNav"></div>
            </div>
        </div>
    </nav>

    <section class="col-10 m-auto mt-5">
        <div class="pt-5">
            <div class="lead text-center fw-bold">アカウント新規作成</div>
            <div class="lead text-center text-danger d-none" id="err">アカウント新規作成</div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 m-auto">
                <div class="mt-4">
                    <label for="username">氏名</label>
                    <input type="text" class="form-control" id="username">
                </div>

                <div class="mt-4">
                    <label for="number">電話番号</label>
                    <input type="text" class="form-control" id="number">
                </div>

                <div class="mt-4">
                    <label for="mailaddress">メールアドレス</label>
                    <input type="text" class="form-control" id="mailaddress">
                </div>

                <div class="mt-4">
                    <label for="birthday">誕生日</label>
                    <input type="date" class="form-control" id="birthday">
                </div>

                <div class="mt-4">
                    <label for="postnumber">郵便番号</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" id="postnumber">
                        <button type="button" class="btn btn-outline-dark mx-2 text-nowrap" id="searchAddress">住所検索</button>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="address">住所</label>
                    <input type="text" class="form-control" id="address">
                </div>

                <div class="mt-4">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password">
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-outline-dark col-12" id="submit">登録</button>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-dark mt-5">
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

    <script>
        let post_number = document.getElementById('postnumber').value;
        document.getElementById('searchAddress').addEventListener('click', () => {
            if (post_number != "") {
                const api_url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" + post_number;
                const get_postnumber_xhr = new XMLHttpRequest();

                get_postnumber_xhr.open('get', api_url);
                get_postnumber_xhr.send()
                get_postnumber_xhr.onload = (e) => {
                    let json = e.target.response;
                    let res = JSON.parse(json)
                    let address = res.results[0].address1 + res.results[0].address2 + res.results[0].address3;
                    document.getElementById('address').value = address;
                }
            }
        })
    </script>

    <script>
        //誕生日から年齢を計算する関数
        function calcAge(e) {
            let birthday_val = e;
            let birthday_year = parseInt(birthday_val.split('-')[0]);
            let birthday_month = parseInt(birthday_val.split('-')[1]);
            let birthday_date = parseInt(birthday_val.split('-')[2]);

            let d = new Date();
            let birthday = new Date(d.getFullYear(), birthday_month - 1, birthday_date);

            let age = d.getFullYear() - birthday_year;

            if (d < birthday) {
                age--;
            }
            return age;
        }

        document.getElementById('submit').addEventListener('click', () => {
            //==================================================
            //       　　　　　エラー処理省略
            //入力値が空ならエラーを入力を求めるようにしてください。
            //==================================================

            let username = document.getElementById('username').value;
            let number = document.getElementById('number').value;
            let mail = document.getElementById('mailaddress').value;
            let birthday = document.getElementById('birthday').value;
            let age = calcAge(birthday);
            let postnumber = document.getElementById('postnumber').value;
            let address = document.getElementById('address').value;
            let password = document.getElementById('password').value;


            const signup_xhr = new XMLHttpRequest();
            let fd = new FormData();
            fd.append('username', username);
            fd.append('number', number);
            fd.append('mail', mail);
            fd.append('birthday', birthday);
            fd.append('age', age);
            fd.append('postnumber', postnumber);
            fd.append('address', address);
            fd.append('password', password);

            signup_xhr.open('post', "./action/signup.php");
            signup_xhr.send(fd);
            signup_xhr.onload = (e) => {
                let json = e.target.response;
                let res = JSON.parse(json);
                if (res == "ok") {
                    location.href = "./index.php";
                } else {
                    document.getElementById('err').classList.remove('d-none');
                }
            };
        })
    </script>
</body>

</html>
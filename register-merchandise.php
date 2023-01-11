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
            <div class="lead fw-bold text-center">
                商品登録
            </div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 m-auto">
                <div class="mt-4">
                    <label for="merchandiseName">商品名</label>
                    <input type="text" id="merchandiseName" class="form-control">
                </div>

                <div class="mt-4">
                    <label for="merchandisePrice">値段</label>
                    <input type="number" id="merchandisePrice" class="form-control">
                </div>

                <div class="mt-4">
                    <label for="merchandiseImg1">写真1</label>
                    <input type="file" id="merchandiseImg1" class="form-control">
                </div>

                <div class="mt-4">
                    <label for="merchandiseImg2">写真2</label>
                    <input type="file" id="merchandiseImg2" class="form-control">
                </div>

                <div class="mt-4">
                    <label for="merchandiseImg3">写真3</label>
                    <input type="file" id="merchandiseImg3" class="form-control">
                </div>

                <div class="mt-4">
                    <label for="merchandiseDeadlineDate">期限(期間限定の場合のみ)</label>
                    <div class="d-flex">
                        <input type="date" id="merchandiseDeadlineDate" class="form-control mx-1">
                        <input type="time" id="merchandiseDeadlineTime" class="form-control mx-1">
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <button id="submit" class="btn btn-outline-dark col-12">登録</button>
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
        const register_merchandise_xhr = new XMLHttpRequest();
        let fd = new FormData();

        document.getElementById('merchandiseImg1').addEventListener('change', (e) => {
            fd.append("img1", e.target.files[0]);
        });

        document.getElementById('merchandiseImg2').addEventListener('change', (e) => {
            fd.append("img2", e.target.files[0]);

        });

        document.getElementById('merchandiseImg3').addEventListener('change', (e) => {
            fd.append("img3", e.target.files[0]);

        });

        document.getElementById('submit').addEventListener('click', () => {
            let m_name = document.getElementById('merchandiseName').value;
            let m_price = document.getElementById('merchandisePrice').value;
            let m_d_date = document.getElementById('merchandiseDeadlineDate').value;
            let m_d_time = document.getElementById('merchandiseDeadlineTime').value;

            if (m_d_date != "") {
                if (m_d_date == "") {
                    m_d_date = "23:59:59"
                }
            }

            fd.append('merchandiseName', m_name);
            fd.append('merchandisePrice', m_price);
            fd.append('merchandiseDeadlineDate', m_d_date);
            fd.append('merchandiseDeadlineTime', m_d_time);

            register_merchandise_xhr.open('post', './action/register-merchandise.php')
            register_merchandise_xhr.send(fd);
            register_merchandise_xhr.onload = (e) => {
                let json = e.target.response;
                let res = JSON.parse(json);
                // location.href = "./merchandise.php?id=" + res;
                console.log(res);
            }
        });
    </script>

</body>

</html>
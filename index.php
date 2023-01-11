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
                        <li class="bg-black"><a href="#" class="text-white">Sample</a></li>
                    </div>
                </ul>
                <div class="hidden-nav-menu" id="hiddenNav"></div>
            </div>
        </div>
    </nav>

    <header>
        <div class="">
            <img src="./img/index-top.jpg" width="100%" alt="">
        </div>
    </header>

    <section class="col-10 m-auto mt-5">
        <div class="lead">商品一覧</div>
        <div class="d-flex flex-wrap" id="merchandiseListWrapper">

        </div>
    </section>

    <div class="" style="height:200vh;"></div>

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
        const get_merchandise_xhr = new XMLHttpRequest();
        get_merchandise_xhr.open('get', './action/get-merchandise-list.php');
        get_merchandise_xhr.send();
        get_merchandise_xhr.onload = (e) => {
            let json = e.target.response;
            let res = JSON.parse(json);
            console.log(res);

            //商品の数を代入
            let list_length = res.length;

            let m_list_wrapper = document.getElementById('merchandiseListWrapper');

            for (i = 0; i < list_length; i++) {
                let merchandise_wrapper = document.createElement('div');
                merchandise_wrapper.setAttribute('class', 'col-6 col-sm-6 col-md-4 col-lg-3 mt-4')

                let for_padding = document.createElement('div');
                for_padding.setAttribute('class', 'p-2');

                let merchandise_link = document.createElement('a');
                merchandise_link.setAttribute('href', "./item.php?id=" + res[i].merchandise_id);
                merchandise_link.setAttribute('class', 'text-decoration-none')

                let merchandise_img_wrapper = document.createElement('div');
                let merchandise_img = document.createElement('img');
                merchandise_img.setAttribute('src', "./img/" + res[i].img1);
                merchandise_img.setAttribute('class', "merchandise-img");
                merchandise_img.setAttribute('width', '100%');
                merchandise_img.setAttribute('alt', '商品' + i + "の写真");

                merchandise_img_wrapper.appendChild(merchandise_img);

                let merchandise_title = document.createElement('div');
                merchandise_title.textContent = res[i].merchandise_name;
                merchandise_title.setAttribute('class', 'text-dark lead text-break');

                let merchandise_price = document.createElement('div');
                merchandise_price.setAttribute('class',"text-dark lead")
                merchandise_price.textContent = res[i].merchandise_price + "円";

                merchandise_link.appendChild(merchandise_img_wrapper);
                merchandise_link.appendChild(merchandise_title);
                merchandise_link.appendChild(merchandise_price);
                for_padding.appendChild(merchandise_link);
                merchandise_wrapper.appendChild(for_padding);
                m_list_wrapper.appendChild(merchandise_wrapper);

            }
        }
    </script>
</body>

</html>
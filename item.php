<?php
session_start();
$merchandise_id = $_GET['id'];
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

    <section class="col-10 m-auto mt-5">
        <div class="d-flex pt-5">
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 m-auto">
                <img src="" id="merchandiseImg1" width="100%" alt="">
            </div>
            <div class="px-3">
                <div id="name" class="lead display-6 my-5"></div>
                <div class="fs-6 lead">Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain </div>
                <div id="price" class="lead display-6 mt-5"></div>
            </div>
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
        let merchandise_id = "<?php echo $merchandise_id ?>";
        console.log(merchandise_id);

        const get_merchandise_xhr = new XMLHttpRequest();
        let fd = new FormData();
        fd.append("merchandise_id", merchandise_id);

        get_merchandise_xhr.open('post', "./action/get-merchandise.php");
        get_merchandise_xhr.send(fd);
        get_merchandise_xhr.onload = (e) => {
            let json = e.target.response;
            let res = JSON.parse(json);
            console.log(res);
            document.getElementById('price').textContent = res.merchandise_price + "円";
            document.getElementById('merchandiseImg1').setAttribute('src', "./img/" + res.img1)
            document.getElementById('name').textContent = res.merchandise_name;
        }
    </script>
</body>

</html>
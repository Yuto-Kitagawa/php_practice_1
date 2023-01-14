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
            <a class="top text-nowrap" href="./index.php">LOGO</a>
        </div>

        <div id="sidebarMenu">
            <ul class="sidebarMenuInner text-black fw-bold">
                <div class="z-99">
                    <li class="logo">
                        <a href="./index.php" class="text-white">LOGO</a>
                    </li>
                </div>
                <div class="z-99  d-flex justify-content-around col-12 col-sm-12 col-md-5 col-lg-5 flex-direction-menu">
                    <?php
                    if (isset($_SESSION['username'])) {
                    ?>
                        <li class="bg-black"><a href="./profile.php" class="text-white"><?= $_SESSION['username'] ?></a></li>
                        <li class="bg-black"><a href="./register-merchandise.php" class="text-white">商品登録</a></li>
                        <li class="bg-black"><a href="./menu.php" class="text-white">メニュー</a></li>
                        <li class="bg-black"><a href="./action/signout.php" class="text-white">ログアウト</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="bg-black"><a href="./signup.php" class="text-white">アカウント作成</a></li>
                        <li class="bg-black"><a href="./login.php" class="text-white">ログイン</a></li>
                    <?php
                    }
                    ?>
                    <li class="bg-black"><a href="./cart.php" class="text-white">カート</a></li>
                </div>
            </ul>
            <div class="hidden-nav-menu" id="hiddenNav"></div>
        </div>
    </div>
</nav>
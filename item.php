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
    <script>
        let number = 0;
        const merchandise_id = "<?= $merchandise_id ?>";
    </script>
</head>


<body>
    <div class="count-load position-fixed top-0 start-0 vh-100 vw-100 d-flex align-items-center justify-content-center d-none" id="load">

        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    <?php
    if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {
    ?>
        <div id="purchaseScr" class="purchase-screen-wrapper position-fixed top-0 start-0 align-items-center justify-content-center d-none">
            <div class="position-relative w-100 h-100">

                <div class="w-100 h-100" id="backPurchaseScr"></div>

                <div class="col-10 col-sm-10 col-md-8 col-lg-6 m-auto bg-white p-5 position-absolute purchase-screen">
                    <div class="lead fs-4 text-center">購入手続き</div>
                    <div class="" id="firstPurchaseScr">

                        <div class="lead text-center mt-4">支払い方法</div>
                        <div class="d-flex justify-content-center align-items-center mt-2">
                            <div class="p-2 px-3 mx-2 pay-way checked" id="credit">クレジット</div>
                            <div class="p-2 px-3 mx-2 pay-way" id="convenience">コンビニ払い</div>
                        </div>
                        <div class="mt-3 text-center" id="creditScr">
                            <div class="d-flex flex-column flex-sm-column flex-md-column flex-lg-row align-self-center justify-content-center">
                                <div class="lead col-4">クレジットカード番号:</div>
                                <div class="ps-3 col-8 m-auto">
                                    <input type="text" name="" class="form-control" id="creNumber">
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-column flex-md-column flex-lg-row align-self-center justify-content-center mt-3">
                                <div class="lead col-4">暗証番号:</div>
                                <div class="ps-3 col-8 m-auto">
                                    <input type="password" name="" class="form-control" id="crePassword">
                                </div>
                            </div>
                        </div>
                        <div class="lead text-center text-danger d-none" id="creditErr">値を入力してください</div>

                        <div class="mt-3 text-center d-none" id="convenienceScr">
                            <div class="lead text-center">申込番号</div>
                            <div class="ps-3 lead fw-bold text-center" id="conviniNumber">
                                00000000000000000
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <button class="btn btn-outline-secondary mx-2 px-5" id="backPurchaseScr2">戻る</button>
                            <button class="btn btn-outline-success mx-2 px-5" id="payScr">次へ</button>
                        </div>
                    </div>

                    <div class="d-none text-center" id="secondPurchaseScr">
                        <div class="lead my-1 fs-5" id="purchaseScrmerchandiseName"></div>
                        <div class="d-flex my-2">
                            <div class="lead pe-3">単価: </div>
                            <div class="lead" id="purchaseScrmerchandisePrice"></div>
                        </div>
                        <div class="d-flex my-2">
                            <div class="lead pe-3">個数: </div>
                            <div class="lead " id="purchaseScrmerchandiseNumber"></div>
                        </div>
                        <div class="d-flex my-2">
                            <div class="lead pe-3">小計: </div>
                            <div class="lead fw-bold" id="purchaseScrmerchandiseTotal"></div>
                        </div>

                        <hr class="col-10 m-auto">

                        <div class="d-flex align-items-center my-2">
                            <div class="lead pe-3">支払い方法:</div>
                            <div class="lead fw-bold" id="PayWay"></div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mt-3">
                            <button class="btn btn-outline-secondary mx-2 px-5" id="backPurchaseScr3">戻る</button>
                            <button class="btn btn-outline-success mx-2 px-5" id="purchase">購入</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    include('./nav.php');
    ?>

    <section class="col-10 m-auto">
        <div class="d-flex flex-column flex-sm-column flex-md-column flex-lg-row py-4 navmargin">
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 position-relative merchandise-detail-img-wrapper" id="imgWrapper">
                <div class="position-absolute" id="backMerchandiseImg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                </div>

                <div class="position-absolute" id="nextMerchandiseImg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                    </svg>
                </div>

                <img src="" id="merchandiseImg1" class="merchandise-img position-absolute show" width="100%" alt="">
            </div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 m-auto">
                <div class="ps-0 ps-sm-0 ps-md-0 ps-lg-5">
                    <div id="name" class="lead display-6 text-break"></div>
                    <div class="d-flex align-items-baseline mt-3">
                        <div id="priceLabel" class="lead display-6"></div>
                        <input type="number" id="price" hidden>
                        <small>(税込み)</small>
                    </div>
                    <div class="fs-6 lead my-3">
                        Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain
                    </div>
                </div>
                <div class="my-3">
                    <div class="px-5">
                        <?php
                        if (!isset($_SESSION['userid']) || $_SESSION['userid'] == "") {
                        ?>
                            <a href="./login.php">
                                <svg xmlns="http://www.w3.org/2000/svg" id="good" width="32" height="32" fill="<?= $good_color ?>" class="bi bi-heart" viewBox="0 0 16 16">
                                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                </svg>
                            </a>
                        <?php
                        } else {
                        ?>
                            <svg xmlns="http://www.w3.org/2000/svg" id="none" width="32" height="32" fill="currentColor" class="good-icon d-none opacity-0 bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" id="good" width="32" height="32" fill="red" class="good-icon d-none opacity-0 bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>
                        <?php
                        };
                        ?>
                    </div>
                    <div class="px-5 mt-2">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="ps-0 ps-sm-0 ps-md-0 ps-lg-5 pt-4 text-center">
                        <div class="lead text-danger text-center d-none" id="numerr">数値を入力してください</div>
                        <div class="d-flex flex-column flex-sm-column flex-md-column flex-lg-row justify-content-center align-items-center mt-3">
                            <div class="lead">個数: </div>
                            <div class="ps-3">
                                <input type="number" name="" class="form-control" id="number">
                            </div>
                        </div>
                    </div>

                    <div class="ps-0 ps-sm-0 ps-md-0 ps-lg-5 pt-4 text-center">
                        <div class="d-flex align-items-center justify-content-around">
                            <?php
                            if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {
                            ?>
                                <button class="btn btn-outline-warning col-5 m-auto" id="purchaseBtn">購入</button>
                            <?php
                            }
                            ?>
                            <button class="btn btn-outline-success col-5 m-auto" id="cartBtn">カートに入れる</button>
                        </div>
                    </div>
                    <div class="lead d-none" id="cartLabel">カートに追加しました。</div>
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
        //写真の大きさを調整するための関数
        function ajustImg() {
            let img = document.getElementsByClassName('merchandise-img')[0];
            let imgWrapper = document.getElementById('imgWrapper');
            let width = img.clientWidth;
            imgWrapper.style.height = width + "px";
        }

        //今表示されている写真を指定するための変数を定義
        let imgCounter = 0;

        function merchandiseCarousel(e) {
            //写真の枚数を格納
            let imgMaxIndex = document.querySelectorAll('.merchandise-img').length;

            //写真の枚数だけ繰り返し
            document.getElementsByClassName('merchandise-img')[imgCounter].classList.remove('show');

            //戻るボタンが押されたときの処理
            if (e == "back") {
                // 一枚前の写真を表示させるために1引く
                imgCounter--;
                // マイナスになれば一番後ろの写真にする
                if (imgCounter == -1) {
                    imgCounter = imgMaxIndex - 1;
                }
                // 表示させる写真のタグのクラスにshowを追加する
                document.querySelectorAll('.merchandise-img')[imgCounter].classList.add('show');
            }

            //次ボタンが押された時の処理
            if (e == "next") {
                // 一枚あとの写真にするための１追加する
                imgCounter++;
                //もし一番すべての枚数より数が大きくなると、一番最初の写真にもどす
                if (imgCounter >= imgMaxIndex) {
                    imgCounter = 0;
                }
                // 表示させる写真のタグのクラスにshowを追加する
                document.querySelectorAll('.merchandise-img')[imgCounter].classList.add('show');
            }
        }

        // 写真の戻るボタンを押したときにmerchandiseCarousel関数にbackを送る
        document.getElementById('backMerchandiseImg').addEventListener('click', () => {
            merchandiseCarousel('back')
        });

        // 写真の次ボタンを押したときにmerchandiseCarousel関数にnextを送る
        document.getElementById('nextMerchandiseImg').addEventListener('click', () => {
            merchandiseCarousel('next')
        });

        function getMerchandiseInfo() {
            //XHRを使用して通信
            const get_merchandise_xhr = new XMLHttpRequest();
            //送信するためのデータを格納するformdataを定義
            let fd = new FormData();
            //formdataにデータを格納
            fd.append("merchandise_id", merchandise_id);

            //通信方法、通信先を定義
            get_merchandise_xhr.open('post', "./action/get-merchandise.php");
            // 指定したURLに通信
            get_merchandise_xhr.send(fd);

            // 通信後の処理
            get_merchandise_xhr.onload = (e) => {
                let json = e.target.response;
                let res = JSON.parse(json);
                if (res.length == 2) {
                    let good_status = res[1];
                    if (good_status == "good") {
                        document.getElementById('good').classList.remove('d-none');
                        document.getElementById('good').classList.remove('opacity-0');
                    } else {
                        document.getElementById('none').classList.remove('opacity-0');
                        document.getElementById('none').classList.remove('d-none');
                    }
                    res = res[0]
                } else {
                    res = res[0];
                }
                //送られてきたデータを表示
                document.getElementById('price').value = parseInt(res.merchandise_price);
                document.getElementById('priceLabel').textContent = parseInt(res.merchandise_price).toLocaleString() + "円";
                document.getElementById('merchandiseImg1').setAttribute('src', "./img/" + res.img1);
                document.getElementById('name').textContent = res.merchandise_name;

                //写真を生成する場所を指定
                let imgParent = document.getElementById('imgWrapper');

                //写真があれば生成して表示
                if (res.img2) {
                    let img2 = document.createElement('img');
                    img2.setAttribute('src', "./img/" + res.img2);
                    img2.setAttribute('class', "merchandise-img position-absolute");
                    img2.setAttribute('width', "100%");
                    img2.setAttribute('load', "lazy");
                    imgParent.appendChild(img2);
                }

                //写真があれば生成して表示
                if (res.img3) {
                    let img3 = document.createElement('img');
                    img3.setAttribute('src', "./img/" + res.img3);
                    img3.setAttribute('class', "merchandise-img position-absolute");
                    img3.setAttribute('width', "100%");
                    img3.setAttribute('load', "lazy");
                    imgParent.appendChild(img3);
                }
                // 写真を生成した後にすべての写真のサイズを調整
                ajustImg();
            }
        }

        getMerchandiseInfo();

        window.addEventListener('resize', () => {
            getMerchandiseInfo();
            ajustImg();
        })
    </script>

    <script>
        //カートに入れる時の処理
        document.getElementById('cartBtn').addEventListener('click', () => {
            //個数を取得
            // 個数が1以上の時に処理
            if (document.getElementById('number').value == '' || document.getElementById('number').value <= 0) {
                document.getElementById('numerr').classList.remove('d-none');
            } else {
                //商品IDを取得
                number = document.getElementById('number').value;
                const cart_xhr = new XMLHttpRequest();
                let fd = new FormData();
                //商品IDと個数を送信するためにFormDataに格納
                fd.append('merchandise_id', merchandise_id);
                fd.append('number', number);
                cart_xhr.open('post', "./action/input-cart.php");
                cart_xhr.send(fd);
                cart_xhr.onload = (e) => {
                    let json = e.target.response;
                    let res = JSON.parse(json);
                    location.href = "./cart.php";
                }
            }
        });
    </script>

    <?php
    //ログインしているときは購入の処理ができるようにする
    if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {
    ?>
        <script>
            //モーダルや購入手続きの画面の切り替え
            document.getElementById('purchaseBtn').addEventListener('click', () => {
                // 個数が1以上の時に処理
                if (document.getElementById('number').value == '' || document.getElementById('number').value <= 0) {
                    document.getElementById('numerr').classList.remove('d-none');
                } else {
                    let m_name = document.getElementById('name').textContent
                    let price = document.getElementById('price').value;
                    number = document.getElementById('number').value;
                    document.getElementById('purchaseScrmerchandisePrice').textContent = price + "円";
                    document.getElementById('purchaseScrmerchandiseName').textContent = m_name;
                    document.getElementById('purchaseScrmerchandiseNumber').textContent = number + "個";
                    document.getElementById('purchaseScrmerchandiseTotal').textContent = price + "円 × " + number + "個 = " + (price * number) + "円";
                    document.getElementById('purchaseScr').classList.remove('d-none');
                }
            });


            //購入確定ボタンを押したときの処理
            document.getElementById('purchase').addEventListener('click', () => {
                const purchase_xhr = new XMLHttpRequest();
                let fd = new FormData();

                let payway = document.getElementsByClassName('checked')[0].id;

                fd.append('merchandiseid', merchandise_id);
                fd.append('number', number);
                fd.append('payway', payway);
                fd.append('from', "item");

                purchase_xhr.open('post', './action/purchase.php');
                purchase_xhr.send(fd);
                purchase_xhr.onload = (e) => {
                    let json = e.target.response;
                    let res = JSON.parse(json);
                    if (res == "success") {
                        location.href = "./result.php?t=p&&r=s";
                    };
                };
            });

            document.getElementById('backPurchaseScr').addEventListener('click', () => {
                document.getElementById('purchaseScr').classList.add('d-none');
                document.getElementById('purchaseScr').classList.remove('d-flex');
            })

            document.getElementById('backPurchaseScr2').addEventListener('click', () => {
                document.getElementById('purchaseScr').classList.add('d-none');
                document.getElementById('purchaseScr').classList.remove('d-flex');
            });

            document.getElementById('backPurchaseScr3').addEventListener('click', () => {
                document.getElementById('secondPurchaseScr').classList.add('d-none');
                document.getElementById('firstPurchaseScr').classList.remove('d-none');
            })

            //個数入力の画面の処理
            document.getElementById('payScr').addEventListener('click', () => {
                let pay = document.getElementsByClassName('checked')[0];
                if (pay.id == "credit") {
                    if (document.getElementById('creNumber').value != "" && document.getElementById('crePassword').value != "") {
                        document.getElementById('PayWay').textContent = "クレジット";
                    } else {
                        document.getElementById('creditErr').classList.remove('d-none');
                        return;
                    }
                } else if (pay.id == "convenience") {
                    document.getElementById('PayWay').textContent = "コンビニ払い";
                }
                document.getElementById('secondPurchaseScr').classList.remove('d-none');
                document.getElementById('firstPurchaseScr').classList.add('d-none');
            });

            //支払い選択の処理
            document.querySelectorAll('.pay-way').forEach((el, index) => {
                el.addEventListener('click', () => {
                    el.classList.add('checked');
                    if (index == 0) {
                        document.querySelectorAll('.pay-way')[1].classList.remove('checked');
                        document.getElementById('convenienceScr').classList.add('d-none');
                        document.getElementById('creditScr').classList.remove('d-none');
                    } else {
                        document.getElementById('convenienceScr').classList.remove('d-none');
                        document.querySelectorAll('.pay-way')[0].classList.remove('checked');
                        document.getElementById('creditScr').classList.add('d-none');
                    }
                });
            });

            document.querySelectorAll('.good-icon').forEach(el => {
                el.addEventListener('click', () => {
                    document.getElementById('load').classList.remove('d-none');
                    setTimeout(() => {


                        let direct = "";

                        // イイネをまだけていないアイコンを押したらイイネする
                        // イイネが付いているアイコンを押したらイイネ解除
                        if (el.id == "none") {
                            direct = "good";
                        } else {
                            direct = "none";
                        }
                        const toggle_good_xhr = new XMLHttpRequest();
                        let fd = new FormData();
                        fd.append("merchandise_id", merchandise_id);
                        fd.append("direct", direct);

                        toggle_good_xhr.open('post', "./action/toggle-good.php");
                        toggle_good_xhr.send(fd);
                        toggle_good_xhr.onload = (e) => {
                            let json = e.target.response;
                            console.log(json);
                            let res = JSON.parse(json);
                            if (res == "good") {
                                document.getElementById('good').classList.remove('d-none');
                                document.getElementById('good').classList.remove('opacity-0');
                                document.getElementById('none').classList.add('d-none');
                                document.getElementById('none').classList.add('opacity-0');
                            } else {
                                document.getElementById('good').classList.add('d-none');
                                document.getElementById('good').classList.add('opacity-0');
                                document.getElementById('none').classList.remove('d-none');
                                document.getElementById('none').classList.remove('opacity-0');
                            }
                        }
                        document.getElementById('load').classList.add('d-none');
                    }, 300);
                })
            })
        </script>
    <?php
    }
    ?>
</body>

</html>
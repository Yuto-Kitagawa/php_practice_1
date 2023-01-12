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

    <div id="purchaseSrc" class="purchase-screen position-fixed top-0 start-0 d-none align-items-center justify-content-center">
        <div class="col-10 m-auto bg-white p-5">
            <div class="lead fs-4 text-center">購入手続き</div>

        </div>
    </div>

    <?php
    include('./nav.php');
    ?>

    <section class="col-10 m-auto">
        <div class="d-flex flex-column flex-sm-column flex-md-column flex-lg-row pt-4 navmargin">
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 position-relative" id="imgWrapper">
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
                <div class="ps-5">
                    <div id="name" class="lead display-6 text-break"></div>
                    <div class="d-flex align-items-baseline mt-3">
                        <div id="price" class="lead display-6"></div>
                        <small>(税込み)</small>
                    </div>
                    <div class="fs-6 lead my-3">Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain Sample Explain </div>
                </div>
                <div class="my-3">
                    <div class="px-5">
                        <div class="" id="ngood">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                            </svg>
                        </div>
                        <div class="d-none" id="good">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>
                        </div>
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
                    <div class="ps-5 pt-4 text-center">
                        <button class="btn btn-outline-warning col-8 m-auto" id="purchaseBtn">購入</button>
                    </div>
                </div>
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
        document.getElementById('purchaseBtn').addEventListener('click', () => {
            document.getElementById('purchaseSrc').classList.remove('d-none');
            document.getElementById('purchaseSrc').classList.add('d-flex');
        });

        document.getElementById('purchaseSrc').addEventListener('click', () => {
            document.getElementById('purchaseSrc').classList.add('d-none');
            document.getElementById('purchaseSrc').classList.remove('d-flex');
        })


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
            let imgMaxIndex = document.querySelectorAll('.merchandise-img').length;

            document.querySelectorAll('.merchandise-img').forEach((el, index) => {
                if (index == imgCounter) {
                    el.classList.remove('show');
                }
            });
            if (e == "back") {
                imgCounter--;
                if (imgCounter == -1) {
                    let length = imgMaxIndex
                    imgCounter = length - 1;
                }
                document.querySelectorAll('.merchandise-img')[imgCounter].classList.add('show');
            }

            if (e == "next") {
                imgCounter++;
                if (imgCounter >= imgMaxIndex) {
                    imgCounter = 0;
                }
                document.querySelectorAll('.merchandise-img')[imgCounter].classList.add('show');
            }
        }

        document.getElementById('backMerchandiseImg').addEventListener('click', () => {
            merchandiseCarousel('back')
        });

        document.getElementById('nextMerchandiseImg').addEventListener('click', () => {
            merchandiseCarousel('next')
        });

        //一番上で取得した商品IDをJavaScriptの変数に代入
        let merchandise_id = "<?php echo $merchandise_id ?>";

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
            document.getElementById('price').textContent = parseInt(res.merchandise_price).toLocaleString() + "円";
            document.getElementById('merchandiseImg1').setAttribute('src', "./img/" + res.img1);
            document.getElementById('name').textContent = res.merchandise_name;

            let imgParent = document.getElementById('imgWrapper');
            if (res.img2) {
                let img2 = document.createElement('img');
                img2.setAttribute('src', "./img/" + res.img2);
                img2.setAttribute('class', "merchandise-img position-absolute");
                img2.setAttribute('width', "100%");
                img2.setAttribute('load', "lazy");
                imgParent.appendChild(img2);
            }

            if (res.img2) {
                let img3 = document.createElement('img');
                img3.setAttribute('src', "./img/" + res.img3);
                img3.setAttribute('class', "merchandise-img position-absolute");
                img3.setAttribute('width', "100%");
                img3.setAttribute('load', "lazy");
                imgParent.appendChild(img3);
            }
            ajustImg();
        }

        window.addEventListener('resize', () => {
            ajustImg();
        })
    </script>
</body>

</html>
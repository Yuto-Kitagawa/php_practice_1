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
    <div class="count-load position-fixed top-0 start-0 vh-100 vw-100 d-flex align-items-center justify-content-center d-none" id="load">
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <?php
    include('./nav.php');
    ?>

    <section class=" col-10 m-auto mt-5 main-section">
        <div class="pt-5">
            <div class="lead text-center display-6">買い物かご</div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 m-auto" id="cartListWrapper"></div>
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
        function changeNumber() {
            document.querySelectorAll('.change-number').forEach(el => {
                el.addEventListener('click', () => {
                    document.getElementById('load').classList.remove('d-none');
                    setTimeout(() => {
                        let m_id = el.getAttribute('for');
                        let direct = el.getAttribute('data-direct');

                        const change_number_xhr = new XMLHttpRequest();
                        let fd = new FormData();

                        fd.append("merchandiseid", m_id);
                        fd.append("direct", direct);

                        change_number_xhr.open('post', './action/change-number.php');
                        change_number_xhr.send(fd);
                        change_number_xhr.onload = (e) => {
                            let json = e.target.response;
                            let res = JSON.parse(json);
                            if (res == "delete") {
                                location.reload();
                            } else {
                                document.getElementById(m_id).textContent = res + "個";
                            }
                        }
                        document.getElementById('load').classList.add('d-none');
                    }, 500);
                });
            });
        }
    </script>

    <script>
        //カート読み込み
        const cart_load_xhr = new XMLHttpRequest();
        cart_load_xhr.open('get', "./action/get-cart.php");
        cart_load_xhr.send();
        cart_load_xhr.onload = (e) => {
            let json = e.target.response;
            let res = JSON.parse(json); //!返却されてくる値が複雑なので注意!
            // console.log(res);
            const cart_list_wrapper = document.getElementById('cartListWrapper');
            cart_length = res[0].length;
            //!二次元配列になるので注意!
            for (i = 0; i < cart_length; i++) {
                let cart_wrapper = document.createElement('div');
                cart_wrapper.setAttribute('class', 'cart-list d-flex mt-2')

                //写真にリンクを設定
                let img_wrapper = document.createElement('a');
                img_wrapper.setAttribute('href', './item.php?id=' + res[0][i].merchandise_id)
                img_wrapper.setAttribute('class', 'col-4')

                //写真
                let m_img = document.createElement('img');
                m_img.setAttribute('src', './img/' + res[0][i].img1);
                m_img.setAttribute('class', 'merchandise-img opacity-100');
                m_img.setAttribute('width', '100%');
                m_img.setAttribute('alt', res[0][i].merchandise_name + 'の写真');

                img_wrapper.appendChild(m_img);
                cart_wrapper.appendChild(img_wrapper);
                cart_list_wrapper.appendChild(cart_wrapper);

                let m_info_wrapper = document.createElement('div');
                m_info_wrapper.setAttribute('class', "p-3 col-8 lead d-flex flex-column align-items-between justify-content-center");

                //商品名
                let m_name = document.createElement('a');
                m_name.setAttribute('class', 'text-decoration-none text-black')
                m_name.setAttribute('href', './item.php?id=' + res[0][i].merchandise_id);
                m_name.textContent = res[0][i].merchandise_name;
                m_info_wrapper.appendChild(m_name);

                //金額
                let m_price = document.createElement('div');
                m_price.setAttribute('class', 'fs-1 mt-2');
                m_price.textContent = "¥" + parseInt(res[0][i].merchandise_price).toLocaleString();
                m_info_wrapper.appendChild(m_price);

                let m_number_wrapper = document.createElement('div');
                m_number_wrapper.setAttribute('class', 'd-flex align-items-center mt-2');

                let m_number_label = document.createElement('div');
                m_number_label.textContent = "個数:"
                m_number_label.setAttribute('class', 'pe-3');
                m_number_wrapper.appendChild(m_number_label);

                let m_number_minus_btn = document.createElement('label');
                m_number_minus_btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="dodgerblue" class="bi bi-dash-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" /><path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" /></svg>';
                m_number_minus_btn.setAttribute('class', 'mx-2 change-number');
                m_number_minus_btn.setAttribute('data-direct', "minus");
                m_number_minus_btn.setAttribute('for', res[0][i].merchandise_id);
                m_number_wrapper.appendChild(m_number_minus_btn);

                //個数
                let number = document.createElement('div');
                number.textContent = res[1][i] + "個";
                number.setAttribute('class', 'fs-3');
                number.setAttribute('id', res[0][i].merchandise_id);
                m_number_wrapper.appendChild(number);

                let m_number_plus_btn = document.createElement('label');
                m_number_plus_btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="dodgerblue" class="bi bi-plus-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" /><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" /></svg>';
                m_number_plus_btn.setAttribute('class', 'mx-2 change-number');
                m_number_plus_btn.setAttribute('data-direct', "plus");
                m_number_plus_btn.setAttribute('for', res[0][i].merchandise_id);
                m_number_wrapper.appendChild(m_number_plus_btn);

                m_info_wrapper.appendChild(m_number_wrapper);

                let delete_btn = document.createElement('a');
                delete_btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v1H6v-1Zm5 0v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5ZM4.5 5.029a.5.5 0 1 1 .998-.06l.5 8.5a.5.5 0 0 1-.998.06l-.5-8.5Zm6.53-.528a.5.5 0 0 1 .47.528l-.5 8.5a.5.5 0 1 1-.998-.058l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg>';
                delete_btn.setAttribute('class', 'btn btn-outline-danger col-12 mt-3');
                delete_btn.setAttribute('href', "./action/delete-cart.php?id=" + res[0][i].merchandise_id);
                m_info_wrapper.appendChild(delete_btn);
                
                cart_wrapper.appendChild(m_info_wrapper);
                cart_list_wrapper.appendChild(cart_wrapper);

            }
            changeNumber();
        }
    </script>

</body>

</html>
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
    <?php
    include('./nav.php');
    ?>

    <section class="col-10 m-auto mt-5">
        <div class="lead pt-5">商品一覧</div>
        <div class="d-flex flex-wrap" id="merchandiseListWrapper"></div>
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

    <script>
        //JavaScriptで通信するためのメソッド
        const get_merchandise_xhr = new XMLHttpRequest();
        // XHRを使用してgetメソッドの通信を行う
        get_merchandise_xhr.open('get', './action/get-merchandise-list.php');
        //get通信のため送るデータはなし。
        get_merchandise_xhr.send();

        // 送信した後のロードの処理
        get_merchandise_xhr.onload = (e) => {
            //json形式で返却される
            let json = e.target.response;
            //json形式では扱えないので配列に変換するための処理
            let res = JSON.parse(json);

            //resの長さが商品の数なので、商品の数を代入
            let list_length = res.length;

            //商品のリストを生成する場所を指定。
            let m_list_wrapper = document.getElementById('merchandiseListWrapper');

            //商品の数だけ商品の要素を生成
            //今回は何個商品があるかわからない・複数個商品があるので要素を生成しています。
            for (i = 0; i < list_length; i++) {
                //======================================================================
                //setAttributeはそのタグに属性を付けることが出来るメソッド ↔ getAttribute
                //https://www.javadrive.jp/javascript/dom/index16.html
                //======================================================================

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
                merchandise_img.setAttribute('class', "merchandise-list-img");
                merchandise_img.setAttribute('width', '100%');
                merchandise_img.setAttribute('alt', '商品' + i + "の写真");

                merchandise_img_wrapper.appendChild(merchandise_img);

                let merchandise_title = document.createElement('div');
                merchandise_title.textContent = res[i].merchandise_name;
                merchandise_title.setAttribute('class', 'text-dark lead text-break');

                let merchandise_price = document.createElement('div');
                merchandise_price.setAttribute('class', "text-dark lead")
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
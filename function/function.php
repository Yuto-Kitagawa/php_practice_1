<?php
// データベースファイルを読み込み
require_once(__DIR__ . "/database.php");

//データベースクラスを継承
class Functions extends Database
{

    //ログイン処理
    public function login($usermail, $userpassowrd)
    {
        //メールアドレスが同じ行を選択
        $login_sql = "SELECT * FROM user WHERE user_mail = :mail;";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($login_sql);

        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':mail', $usermail, PDO::PARAM_STR);
        //SQL文を実行
        $sth->execute();

        //1行だけ取得できた時(送られてきたメールアドレスが1件だけ登録されている場合)
        if ($sth->rowCount() == 1) {
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            //保存されているパスワードと送られてきたパスワードを検証し、一致した場合
            if (password_verify($userpassowrd, $res['password'])) {
                session_start();
                // セッションに必要なデータを格納する
                $_SESSION['userid']   = $res['user_id'];
                $_SESSION['username'] = $res['user_name'];
                $_SESSION['usermail'] = $res['user_mail'];
                return "logged";
            } else {
                return "err";
            }
        } else {
            return "err";
        }
    }


    //いいねを登録・解除する関数
    public function toggle_good($merchandise_id, $action)
    {
        session_start();
        $userid = $_SESSION['userid'];

        //送られてきたアクション(指示)でSQLを分ける
        if ($action == "none") { //イイネをはずす処理
            $toggle_good_sql = "DELETE FROM good WHERE user_id = :userid AND merchandise_id = :merchandiseid;";
            // 解除したレスポンスを設定
            $res = "removed";
        } else { //イイネを登録する処理
            //もし登録されていたらもう一行登録しないように、チェックして格納する。
            $toggle_good_sql = "INSERT INTO good (merchandise_id,user_id) SELECT :merchandiseid, :userid FROM dual WHERE NOT EXISTS ( SELECT * FROM good WHERE merchandise_id = :merchandiseid AND user_id = :userid) LIMIT 1;";
            //登録したレスポンスを設定
            $res = "good";
        }

        //SQL文を実行する準備
        $sth = $this->conn->prepare($toggle_good_sql);

        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':merchandiseid', $merchandise_id, PDO::PARAM_STR);
        $sth->bindValue(':userid', $userid, PDO::PARAM_STR);

        //SQL文を実行
        $sth->execute();
        return $res;
    }

    //イイネがついているかをチェックする関数
    //この関数は商品詳細情報を取得するときに実行される関数です。280行目あたりで実行しています。
    public function get_good_status($merchandise_id, $user_id)
    {
        //merchandise_idに一致した情報を取得
        $get_good_status_sql = "SELECT * FROM good WHERE merchandise_id = :merchandiseid AND user_id = :userid;";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($get_good_status_sql);

        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':merchandiseid', $merchandise_id, PDO::PARAM_STR);
        $sth->bindValue(':userid', $user_id, PDO::PARAM_STR);

        //SQL文を実行
        $sth->execute();

        //検索結果があるとイイネが付いているのでそのステータスを返却
        if ($sth->rowCount() == 1) {
            $status = "good";
        } else {
            $status = "none";
        }

        return $status;
    }

    //ユーザー登録する関数
    public function register_user($userid, $username, $usernumber, $usermail, $userage, $userbirthday, $useraddress, $userpostnumber, $password)
    {
        //データベースにユーザー情報を格納するSQL文
        $register_user_sql = "INSERT INTO user (user_id,user_name,user_number,user_mail,user_age,user_birthday,user_address,user_post_number,password ) VALUES (:userid,:username,:usernumber,:usermail,:userage,:userbirthday,:useraddress,:userpostnumber,:password);";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($register_user_sql);
        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':userid',         $userid,         PDO::PARAM_STR);
        $sth->bindValue(':username',       $username,       PDO::PARAM_STR);
        $sth->bindValue(':usernumber',     $usernumber,     PDO::PARAM_STR);
        $sth->bindValue(':usermail',       $usermail,       PDO::PARAM_STR);
        $sth->bindValue(':userage',        $userage,        PDO::PARAM_INT);
        $sth->bindValue(':userbirthday',   $userbirthday,   PDO::PARAM_STR);
        $sth->bindValue(':useraddress',    $useraddress,    PDO::PARAM_STR);
        $sth->bindValue(':userpostnumber', $userpostnumber, PDO::PARAM_STR);
        $sth->bindValue(':password',       $password,       PDO::PARAM_STR);
        // SQL文を実行
        $sth->execute();

        //セッションに情報を登録
        session_start();
        session_regenerate_id();
        $_SESSION['userid']   = $userid;
        $_SESSION['username'] = $username;
        $_SESSION['usermail'] = $usermail;
        // このreturnは下のcheck_account関数を呼び出した場所に返却される
        return "ok";
    }

    //ユーザーが既に登録されていないかを検証する関数
    public function check_account($username, $usernumber, $usermail,  $userbirthday, $userage, $userpostnumber, $useraddress, $userpassword)
    {
        //メールアドレスが同じ行を選択
        $check_account_sql = "SELECT user_mail FROM user WHERE user_mail LIKE :mail;";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($check_account_sql);

        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':mail', "%$usermail%", PDO::PARAM_STR);
        //SQL文を実行
        $sth->execute();

        //SQL文で取得した行が0行の場合(入力されたメールアドレスが登録されていない場合)
        if ($sth->rowCount() == 0) {
            // 頭文字にu_を付けたランダムな文字を生成
            $userid = uniqid("u_");

            // パスワードをハッシュ化(暗号化)
            $password = password_hash($userpassword, PASSWORD_DEFAULT);
            //登録するデータを引数にregister_user関数を実行
            $msg = $this->register_user($userid, $username, $usernumber, $usermail, $userage, $userbirthday, $useraddress, $userpostnumber, $password);
        } else {
            $msg = "registerderr";
        }

        return $msg;
    }

    //商品を登録するための関数
    public function register_merchandise($m_name, $m_price, $m_img1, $m_img1_tmp, $m_img2, $m_img2_tmp, $m_img3, $m_img3_tmp, $m_d_date, $m_d_time)
    {
        // 頭文字にm_を付けたランダムな文字を生成
        $m_id = uniqid("m_");

        if ($m_d_date != "") {
            $deadline = $m_d_date + " " + $m_d_time;

            if ($m_img2 == "") {
                $register_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :deadline)";
                $sth = $this->conn->prepare($register_merchandise_sql);
                $sth->bindValue(':mid',      $m_id,     PDO::PARAM_STR);
                $sth->bindValue(':mname',    $m_name,   PDO::PARAM_STR);
                $sth->bindValue(':mprice',   $m_price,  PDO::PARAM_STR);
                $sth->bindValue(':mimg1',    $m_img1,   PDO::PARAM_STR);
                $sth->bindValue(':deadline', $deadline, PDO::PARAM_STR);
            } else if ($m_img3 == "") {
                $register_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2, :deadline)";
                $sth = $this->conn->prepare($register_merchandise_sql);
                $sth->bindValue(':mid',      $m_id,     PDO::PARAM_STR);
                $sth->bindValue(':mname',    $m_name,   PDO::PARAM_STR);
                $sth->bindValue(':mprice',   $m_price,  PDO::PARAM_STR);
                $sth->bindValue(':mimg1',    $m_img1,   PDO::PARAM_STR);
                $sth->bindValue(':mimg2',    $m_img2,   PDO::PARAM_STR);
                $sth->bindValue(':deadline', $deadline, PDO::PARAM_STR);
            } else {
                $register_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,img3,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2, :mimg3, :deadline)";
                $sth = $this->conn->prepare($register_merchandise_sql);
                $sth->bindValue(':mid',      $m_id,     PDO::PARAM_STR);
                $sth->bindValue(':mname',    $m_name,   PDO::PARAM_STR);
                $sth->bindValue(':mprice',   $m_price,  PDO::PARAM_STR);
                $sth->bindValue(':mimg1',    $m_img1,   PDO::PARAM_STR);
                $sth->bindValue(':mimg2',    $m_img2,   PDO::PARAM_STR);
                $sth->bindValue(':mimg3',    $m_img3,   PDO::PARAM_STR);
                $sth->bindValue(':deadline', $deadline, PDO::PARAM_STR);
            }
        } else {
            if ($m_img2 == "") {
                $register_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1) VALUES (:mid,:mname, :mprice, :mimg1)";
                $sth = $this->conn->prepare($register_merchandise_sql);
                $sth->bindValue(':mid',    $m_id,    PDO::PARAM_STR);
                $sth->bindValue(':mname',  $m_name,  PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1',  $m_img1,  PDO::PARAM_STR);
            } else if ($m_img3 == "") {
                $register_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2)";
                $sth = $this->conn->prepare($register_merchandise_sql);
                $sth->bindValue(':mid',    $m_id,    PDO::PARAM_STR);
                $sth->bindValue(':mname',  $m_name,  PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1',  $m_img1,  PDO::PARAM_STR);
                $sth->bindValue(':mimg2',  $m_img2,  PDO::PARAM_STR);
            } else {
                $register_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,img3) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2, :mimg3)";
                $sth = $this->conn->prepare($register_merchandise_sql);
                $sth->bindValue(':mid',    $m_id,    PDO::PARAM_STR);
                $sth->bindValue(':mname',  $m_name,  PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1',  $m_img1,  PDO::PARAM_STR);
                $sth->bindValue(':mimg2',  $m_img2,  PDO::PARAM_STR);
                $sth->bindValue(':mimg3',  $m_img3,  PDO::PARAM_STR);
            }
        }
        //SQL文を実行
        $sth->execute();

        //写真をimgフォルダに移動
        $destination = __DIR__ . "/../img/" . basename($m_img1);
        move_uploaded_file($m_img1_tmp, $destination);
        $destination = __DIR__ . "/../img/" . basename($m_img2);
        move_uploaded_file($m_img2_tmp, $destination);
        $destination = __DIR__ . "/../img/" . basename($m_img3);
        move_uploaded_file($m_img3_tmp, $destination);

        // actionに返却
        return $m_id;
    }

    //商品一覧(ホーム・index.php用)を取得する関数
    public function get_merchandise_list()
    {
        //商品テーブルから全てを取得
        $get_merchandise_list_sql = "SELECT * FROM merchandise ORDER BY registered_time;";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($get_merchandise_list_sql);
        //SQL文を実行
        $sth->execute();

        //返却用の配列を定義
        $return_list = [];

        //SQLで取得したデータを1行ずつ分解して配列に格納する
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($return_list, $row);
        };

        //結果を格納した配列を返却
        return $return_list;
    }

    //商品詳細情報(1商品のデータ)を返却
    public function get_merchandise($merchandise_id)
    {
        //merchandise_idに一致した情報を取得
        $get_merchandise_sql = "SELECT * FROM merchandise WHERE merchandise_id = :merchandiseid ORDER BY registered_time;";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($get_merchandise_sql);

        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':merchandiseid', $merchandise_id, PDO::PARAM_STR);

        //SQL文を実行
        $sth->execute();

        //SQLで取得したデータを1行ずつ分解して配列に格納する(1行でもOK)
        $res = $sth->fetch(PDO::FETCH_ASSOC);

        session_start();

        //商品にいいねを付けているかを取得
        if (isset($_SESSION['userid']) && $_SESSION['userid'] != "") {
            $user_id = $_SESSION['userid'];
            $good_status = $this->get_good_status($merchandise_id, $user_id);

            //ログインしているかしていないかの判定を配列の長さで判定しているので、返却の際はどちらとも配列化([]をつける)しています。
            //actionに返却
            return [$res, $good_status];
        } else {
            //actionに返却
            return [$res];
        }
    }

    //$_SESSION['cart']に入っているidの詳細データを返却する処理
    public function get_cart($cart_array)
    {
        //カートの中の商品の数を取得
        $cart_length = count($cart_array);
        //カートの中の商品IDを取得
        $key_array = array_keys($cart_array);

        //商品ごとの数を格納
        $num_array = [];
        for ($i = 0; $i < $cart_length; $i++) {
            array_push($num_array, $cart_array[$key_array[$i]]);
        }

        /**
         * いつもはバインドで :idや:nameでバインドしていたが、今回は配列でしたいので、疑問符で指定します。
         * 配列をIN句で使用する(https://chaika.hatenablog.com/entry/2016/06/22/092149 引用)
         */
        $bindParams = substr(str_repeat(',?', count($key_array)), 1); //(?,?,?・・) → バインドパラメータを作成

        // FIELD句は指定した順番で結果を返すようにするための関数です。
        //指定する理由は、商品の個数の配列通りの順番に商品の情報を入れたいため。
        $get_cart_sql = "SELECT * FROM merchandise WHERE merchandise_id IN ({$bindParams}) ORDER BY FIELD( merchandise_id, {$bindParams});";


        //SQL文を実行する準備
        $sth = $this->conn->prepare($get_cart_sql);

        //バインドを2回しているため疑問符が倍の量になる。(SELECT * FROM merchandise WHERE merchandise_id IN (?,?,?[配列1つ目]) ORDER BY FIELD( merchandise_id, ?,?,?[配列2つ目]);
        //今回は配列をバインドするため、配列の最後にもう一度配列をつなげる(execute関数は1つの配列しか指定できないため(多分))
        /*(例) [0,1,2,3,4]   →  [0,1,2,3,4,0,1,2,3,4] */
        foreach ($key_array as $val) {
            array_push($key_array, $val);
        }

        //SQL文を実行
        //実行されるSQL文の中のバインドパラメータと**同数**の要素からなる、値の配列。すべての値は**PDO::PARAM_STR**として扱われる。
        $sth->execute($key_array);

        $res_array = [];
        //SQLで取得したデータを1行ずつ分解して配列に格納する(1行でもOK *複数行はWHILE文で繰り返さないと最後の行しか返却されない)
        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            array_push($res_array, $row);
        }

        //actionに返却
        //複数の値を返したい場合は、一つの配列にまとめるか、下のように無理やり配列にする方法があります。
        return [$res_array, $num_array];
    }

    public function purchase($merchandise_id, $number, $payway)
    {
        session_start();
        //データベースに格納するためにユーザーIDを格納
        $userid = $_SESSION['userid'];
        $purchase_sql = "INSERT INTO history (merchandise_id,user_id,number,type) VALUES (:merchandiseid,:userid,:number,:type);";

        //SQL文を実行する準備
        $sth = $this->conn->prepare($purchase_sql);

        //バリデート(SQL用の正規表現[* → "*"]など、脆弱性がないように変換)
        $sth->bindValue(':merchandiseid', $merchandise_id, PDO::PARAM_STR);
        $sth->bindValue(':userid', $userid, PDO::PARAM_STR);
        $sth->bindValue(':number', $number, PDO::PARAM_INT);
        $sth->bindValue(':type', $payway, PDO::PARAM_INT);

        //SQL文を実行
        //$resultには、データベースに格納することができればtrue、そうでなければfalseが返却される
        $result = $sth->execute();

        // $resultにはSQL文が成功しているか・失敗しているかのtrue・falseが格納されています。
        //購入の処理なので一応書いているだけです。
        //なにか処理をしたいときはここに書くといいかも？(しらんけど)
        if ($result == true) {
            $res = "success";
        } else {
            $res = "err";
        }

        return $res;
    }
}

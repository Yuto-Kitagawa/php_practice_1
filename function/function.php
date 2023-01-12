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

        //1行だけ取得できた時
        if ($sth->rowCount() == 1) {
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            //保存されているパスワードと送られてきたパスワードを検証
            if (password_verify($userpassowrd, $row['password'])) {
                session_start();
                $_SESSION['userid']   = $row['user_id'];
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['usermail'] = $row['user_mail'];
                return "logged";
            } else {
                return "err";
            }
        } else {
            return "err";
        }
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

        //actionに返却
        return $res;
    }
}

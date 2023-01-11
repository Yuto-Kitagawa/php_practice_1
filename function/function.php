<?php
require_once(__DIR__ . "/database.php");

class Functions extends Database
{

    //user関連
    public function register_user($userid, $username, $usernumber, $usermail, $userage, $userbirthday, $useraddress, $userpostnumber, $password)
    {
        $register_user_sql = "INSERT INTO user (user_id,user_name,user_number,user_mail,user_age,user_birthday,user_address,user_post_number,password )
        VALUES (:userid,:username,:usernumber,:usermail,:userage,:userbirthday,:useraddress,:userpostnumber,:password);";
        $sth = $this->conn->prepare($register_user_sql);
        $sth->bindValue(':userid', $userid, PDO::PARAM_STR);
        $sth->bindValue(':username', $username, PDO::PARAM_STR);
        $sth->bindValue(':usernumber', $usernumber, PDO::PARAM_STR);
        $sth->bindValue(':usermail', $usermail, PDO::PARAM_STR);
        $sth->bindValue(':userage', $userage, PDO::PARAM_INT);
        $sth->bindValue(':userbirthday', $userbirthday, PDO::PARAM_STR);
        $sth->bindValue(':useraddress', $useraddress, PDO::PARAM_STR);
        $sth->bindValue(':userpostnumber', $userpostnumber, PDO::PARAM_STR);
        $sth->bindValue(':password', $password, PDO::PARAM_STR);
        $sth->execute();

        session_start();
        session_regenerate_id();
        $_SESSION['userid'] = $userid;
        $_SESSION['username'] = $username;
        $_SESSION['usermail'] = $usermail;

        return "ok";
    }

    public function checkAccount($username, $usernumber, $usermail,  $userbirthday, $userage, $userpostnumber, $useraddress, $userpassword)
    {
        $check_account_sql = "SELECT user_mail FROM user WHERE user_mail LIKE :mail;";
        $sth = $this->conn->prepare($check_account_sql);
        $sth->bindValue(':mail', "%$usermail%", PDO::PARAM_STR);
        $sth->execute();

        if ($sth->rowCount() == 0) {
            $userid = uniqid("u_");
            $password = hash('sha3-256', $userpassword);
            $msg = $this->register_user($userid, $username, $usernumber, $usermail, $userage, $userbirthday, $useraddress, $userpostnumber, $password);
        } else {
            $msg = "registerderr";
        }

        return $msg;
    }

    public function register_merchandise($m_name, $m_price, $m_img1, $m_img1_tmp, $m_img2, $m_img2_tmp, $m_img3, $m_img3_tmp, $m_d_date, $m_d_time)
    {
        $m_id = uniqid("m_");
        if ($m_d_date != "") {
            $deadline = $m_d_date + " " + $m_d_time;

            if ($m_img2 == "") {
                $regcister_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :deadline)";
                $sth = $this->conn->prepare($regcister_merchandise_sql);
                $sth->bindValue(':mid', $m_id, PDO::PARAM_STR);
                $sth->bindValue(':mname', $m_name, PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1', $m_img1, PDO::PARAM_STR);
                $sth->bindValue(':deadline', $deadline, PDO::PARAM_STR);
            } else if ($m_img3 == "") {
                $regcister_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2, :deadline)";
                $sth = $this->conn->prepare($regcister_merchandise_sql);
                $sth->bindValue(':mid', $m_id, PDO::PARAM_STR);
                $sth->bindValue(':mname', $m_name, PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1', $m_img1, PDO::PARAM_STR);
                $sth->bindValue(':mimg2', $m_img2, PDO::PARAM_STR);
                $sth->bindValue(':deadline', $deadline, PDO::PARAM_STR);
            } else {
                $regcister_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,img3,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2, :mimg3, :deadline)";
                $sth = $this->conn->prepare($regcister_merchandise_sql);
                $sth->bindValue(':mid', $m_id, PDO::PARAM_STR);
                $sth->bindValue(':mname', $m_name, PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1', $m_img1, PDO::PARAM_STR);
                $sth->bindValue(':mimg2', $m_img2, PDO::PARAM_STR);
                $sth->bindValue(':mimg3', $m_img3, PDO::PARAM_STR);
                $sth->bindValue(':deadline', $deadline, PDO::PARAM_STR);
            }
        } else {
            if ($m_img2 == "") {
                $regcister_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :deadline)";
                $sth = $this->conn->prepare($regcister_merchandise_sql);
                $sth->bindValue(':mid', $m_id, PDO::PARAM_STR);
                $sth->bindValue(':mname', $m_name, PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1', $m_img1, PDO::PARAM_STR);
            } else if ($m_img3 == "") {
                $regcister_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2,:deadline)";
                $sth = $this->conn->prepare($regcister_merchandise_sql);
                $sth->bindValue(':mid', $m_id, PDO::PARAM_STR);
                $sth->bindValue(':mname', $m_name, PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1', $m_img1, PDO::PARAM_STR);
                $sth->bindValue(':mimg2', $m_img2, PDO::PARAM_STR);
            } else {
                $regcister_merchandise_sql = "INSERT INTO merchandise (merchandise_id,merchandise_name,merchandise_price,img1,img2,img3,deadline) VALUES (:mid,:mname, :mprice, :mimg1, :mimg2, :mimg3, :deadline)";
                $sth = $this->conn->prepare($regcister_merchandise_sql);
                $sth->bindValue(':mid', $m_id, PDO::PARAM_STR);
                $sth->bindValue(':mname', $m_name, PDO::PARAM_STR);
                $sth->bindValue(':mprice', $m_price, PDO::PARAM_STR);
                $sth->bindValue(':mimg1', $m_img1, PDO::PARAM_STR);
                $sth->bindValue(':mimg2', $m_img2, PDO::PARAM_STR);
                $sth->bindValue(':mimg3', $m_img3, PDO::PARAM_STR);
            }
        }

        $sth->execute();

        //写真を移動
        $destination = __DIR__ . "/../img/" . basename($m_img1);
        move_uploaded_file($m_img1_tmp, $destination);
        $destination = __DIR__ . "/../img/" . basename($m_img2);
        move_uploaded_file($m_img2_tmp, $destination);
        $destination = __DIR__ . "/../img/" . basename($m_img3);
        move_uploaded_file($m_img3_tmp, $destination);

        return $m_id;
    }
}

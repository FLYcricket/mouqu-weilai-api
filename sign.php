<?php
session_start();
//include_once "db.php";
header('Content-Type:text/html;charset=utf-8');

$action = $_POST['action'];
switch ($action) {

    //发送验证码
    case"sendcode";
        $phone = $_POST['phone'];
        $code = rand(1000, 9999);
        $_SESSION['session_code'] = $code;
        $_SESSION['session_phone'] = $phone;
        $arr_code = array('code' => $code, 'phone' => $phone);
        // echo  123;
        echo json_encode($arr_code);
        exit;
        break;


    //注册+登录
    case "login";

        // 查询获取数据 ..
        $codes = $_POST['code'];
        $phone = $_POST['phone'];
        include_once "db.php";

        //查询是否已注册
        $sql_s = "SELECT id FROM `user` WHERE phone={$phone}";
        $result_s = mysqli_query($link, $sql_s);


        // status 1 验证成功，注册登录  0， 验证失败  2 用户已存在,直接登陆  3 登录失败
        if (!$result_s) {
            if ($codes != "" && $codes == $_SESSION['session_code']) {
                $lastlogin = date("Y-m-d H:i:s");
                $sql_u = "UPDATE `app`.`user` SET `lastlogin` = '{$lastlogin}' WHERE `user`.`phone` = {$phone}; ";
                $result = mysqli_query($link, $sql);
                if (!$result) {
                    $arr_code = array('status' => 2, 'phone' => $phone);
                } else {
                    $arr_code = array('status' => 3, 'phone' => $phone);
                }
            }
        } else {
            if ($codes != "" && $codes == $_SESSION['session_code']) {

                //写入数据库
                $created = date("Y-m-d H:i:s");
                $sql = "INSERT INTO `app`.`user` (`phone`,`username`,`created`) VALUES
                        ('{$_POST['phone']}','{$_POST['phone']}',{$crested});";
                $result = mysqli_query($link, $sql);
                if (!$result) {
                    $arr_code = array('status' => 1, 'phone' => $phone);
                }
            } else {
                $arr_code = array('status' => 0, 'phone' => $phone);
            }
        }
        //用户信息存session
        $sql = "SELECT id FROM `user` WHERE phone={$phone}";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_array($result, MYSQL_ASSOC);
        $_SESSION['session_id'] = $arr_code['id'];
        $_SESSION['session_username'] = $arr_code['username'];

        unset($_SESSION['session_code']);
        exit(json_encode($arr_code));
        break;

    //结束
    default:
        exit(json_encode(0));
}
?>


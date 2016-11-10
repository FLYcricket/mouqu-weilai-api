<?php
/**
 * Created by PhpStorm.
 * User: xf231
 * Date: 2016/11/10
 * Time: 10:25
 */
session_start();

header('Content-Type:text/html;charset=utf-8');

$action = $_POST['action'];
switch ($action) {

    //发送验证码
    case"sendcode";
        $phone = $_POST['phone'];
        $code = rand(1000, 9999);
        $_SESSION['session_code'] = $code;
        $arr_code = array('code' => $code, 'phone' => $phone);
        // echo  123;
        echo json_encode($arr_code);
        exit;
        break;


    //检查验证码
    case "checkcode";

        // 查询获取数据 ..
        $codes = $_POST['code'];
        $phone = $_POST['phone'];
        include_once "db.php";

        //查询是否已注册
        $sql_s = "SELECT * FROM `user` WHERE phone={$phone}";
        $result_s = mysqli_query($link, $sql_s);

        // code 1 验证成功， 0， 验证失败  2 用户已存在
        if (!$result_s) {
            $arr_code = array('status' => 2, 'phone' => $phone);
        } else {
            if ($codes != "" && $codes == $_SESSION['session_code']) {

                //写入数据库
                $sql = "INSERT INTO `app`.`user` (`phone`) VALUES ('{$_POST['phone']}');";
                $result = mysqli_query($link, $sql);
                if (!$result) {
                    $arr_code = array('status' => 1, 'phone' => $phone);
                }
            } else {
                $arr_code = array('status' => 0, 'phone' => $phone);
            }
        }
        unset($_SESSION['session_code']);
        exit(json_encode($arr_code));
        break;
    //结束
    default:
        exit(json_encode(0));
}
?>


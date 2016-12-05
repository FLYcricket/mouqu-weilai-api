<?php

session_start();

header('Content-Type:text/html;charset=utf-8');
include_once "db.php";

$action = $_POST['action'];
$id = $_SESSION['session_id'];

switch ($action) {
    //最新消息通知
    case "message";
        $sql = "SELECT  `message` FROM `setting` WHERE 1";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;

    //服务协议
    case "service";
        $sql = "SELECT  `service` FROM `setting` WHERE 1";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;

    //版本号
    case "version";
        $sql = "SELECT  `version` FROM `setting` WHERE 1";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;

    //建议
    case "advice";
        $advice=$_POST['advice'];
        $sql="UPDATE `user` SET `advice`={$advice} WHERE id={$id}";
        $result = mysqli_query($link, $sql);
        //0 更新失败  1 更新成功
        if (!$result) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //投诉
    case "complaint";
        $complaint=$_POST['complaint'];
        $sql="UPDATE `user` SET `complaint`={$complaint} WHERE id={$id}";
        $result = mysqli_query($link, $sql);
        //0 更新失败  1 更新成功
        if (!$result) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //结束
    default:
        exit(json_encode(0));
}
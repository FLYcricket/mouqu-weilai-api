<?php


session_start();

header('Content-Type:text/html;charset=utf-8');
include_once "db.php";

$action = $_POST['action'];
$id = $_SESSION['session_id'];
$name = $_SESSION['session_username'];
switch ($action) {
    //商户接单列表
    case "list";
        //页码和一页显示条数
        $page_size = $_POST['page_size'];
        $page_num = $_POST['page_num'];
        $size = ($page_size - 1) * $page_num;
        $sql = "SELECT a.content,a.orderid,a.num,a.price,a.address,a.create,b.username FROM
 orders a right join user b on a.ad_id=b.id  where servicestatus='0' ORDER BY `create` DESC limit {$size},{$page_num};";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;

    //订单详情
    case "detail";

        $orderid = $_POST['id'];
        $sql = "SELECT * FROM `orders` WHERE id='{$orderid}'";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_array($result, MYSQL_ASSOC);

        exit(json_encode($arr_code));
        break;

    //商户接单
    case "receive";
        $orderid = $_POST['id'];

        //判断用户审核是否通过
        $sql_s = "SELECT  `status`  FROM `check_info` WHERE userid='{$id}'";
        $result = mysqli_query($link, $sql_s);
        $arr = mysqli_fetch_array($result, MYSQL_ASSOC);
        if ($arr['status'] == '审核通过') {
            $sql = "UPDATE `mouqu`.`orders` SET `servicestatus` = '1', `serverid` = '{$id}' WHERE `orders`.`id` = { $orderid};";
            $result = mysqli_query($link, $sql);
            //0 接单失败  1 接单成功 2 未审核
            if (!$result) {
                $arr_code = array('status' => 0);
            } else {
                $arr_code = array('status' => 1);
            }
        } else {
            $arr_code = array('status' => 2);
        }

        exit(json_encode($arr_code));
        break;


    //结束
    default:
        exit(json_encode(0));


}

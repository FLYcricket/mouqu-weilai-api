<?php

session_start();

header('Content-Type:text/html;charset=utf-8');
include_once "db.php";

$action = $_POST['action'];
$id = $_SESSION['session_id'];
//echo $phone;
switch ($action) {
    //发送个人信息
    case "info";
        $sql = "SELECT  `username`, `phone`,`sex`, `age`, `tag`, `location`, `hometown`, `info`
                    FROM `user` WHERE id={$id}";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;

    //更改个人信息
    case "add_info";
        $username = $_POST['username'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $tag = $_POST['tag'];
        $phone = $_POST['phone'];
        $location = $_POST['location'];
        $hometown = $_POST['hometown'];
        $info = $_POST['info'];
        $date=date("Y-m-d H:i:s");
        $sql = "UPDATE `user` SET
                 `username`='{$username}',`sex`='{$sex}',,`phone`='{$phone}
                 `age`='{$age}'],`tag`='{$tag}',`created`='{$date}',
                 `location`='{$location}',`hometown`='{$hometown}',
                 `info`='{$info}' WHERE id={$id}";
        $result = mysqli_query($link, $sql);
        //0 更新失败  1 更新成功
        if (!$result) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //余额查询
    case "wallet";
        exit(json_encode($arr_code));
        break;

    //地址管理
    case "address";
        $sql = "SELECT `id`,`address`, `name`, `sex`, `phone`,`status` FROM `adress` WHERE userid={$id}";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;

    //添加地址
    case "add_address";
        $name = $_POST['username'];
        $sex = $_POST['sex'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $sql = "INSERT INTO `adress`(`userid`, `name`, `sex`, `phone`, `address`) VALUES
              ({$id},$name,$sex,$phone,$address)";
        $result = mysqli_query($link, $sql);
        //0 更新失败  1 更新成功
        if (!$result) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //设置默认地址
    case "de_address";
        //$status = $_POST['status'];
        $addressid=$_POST['id'];
        //先把所有地址重置下
        $sql="UPDATE `mouqu`.`address` SET `status` = '0' WHERE `address`.`userid` = {$id};";
        $result = mysqli_query($link, $sql);
        //设置默认地址
        $sql_m="UPDATE `mouqu`.`address` SET `status` = '1' WHERE `address`.`id` = {$addressid};";
        $result_m = mysqli_query($link, $sql_m);

        //0 更新失败  1 更新成功
        if (!$result_m) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //用户订单列表
    case "orders";
        //页码和一页显示条数
        $page_size = $_POST['page_size'];
        $page_num = $_POST['page_num'];
        $size = ($page_size - 1) * $page_num;
        $sql = "SELECT `id`,`content`, `price`,  `sername`, `orderstatus`, `create` FROM `orders`
                          WHERE ad_id='{$id}' limit {$size},{$page_num}";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;


    //商户订单列表
    case "orderslist";
        //页码和一页显示条数
        $page_size = $_POST['page_size'];
        $page_num = $_POST['page_num'];
        $size = ($page_size - 1) * $page_num;
        $sql = "SELECT a.content,a.num,a.price,a.address,b.username FROM orders a right JOIN user b ON b.id=a.ad_id WHERE a.serviceid='{$id}' limit {$size},{$page_num}";
        $result = mysqli_query($link, $sql);
        $arr_code = mysqli_fetch_all($result, MYSQL_ASSOC);
        exit(json_encode($arr_code));
        break;


    //评价
    case "assess";
        $stars=$_POST['stars'];
        $assess=$_POST['assess'];
        $order_id=$_POST['id'];
        //判断是否匿名评价  1 实名评价
        if($_POST['state']==1){
            $sql="UPDATE `orders` SET
                      `ad_id`={$id},`stars`={$stars},`assess`={$assess} WHERE id={$order_id}";
        }else{
            $sql="UPDATE `orders` SET
                      `stars`={$stars},`assess`={$assess} WHERE id={$order_id}";
        }
        $result = mysqli_query($link, $sql);
        //0 更新失败  1 更新成功
        if (!$result) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //商户入驻
    case "aut";
        require_once "upload.php";
        $name=$_POST['name'];
        $sex=$_POST['sex'];
        $type=$_POST['type'];
        $id_num=$_POST['id_num'];
        $pic_id1=$pic['0'];
        $pic_id2=$pic['1'];
        $business=$pic['2'];
        $other=$_POST['other'];
        $sql="INSERT INTO `check_info`( `userid`, `name`, `sex`, `type`, `id_num`, `pic_id1`, `pic_id2`, `business`, `other`)
                           VALUES ({$id},{$name},{$sex},{$type},{$id_num},{$pic_id1},{$pic_id2},[$business],{$other})";
        $result = mysqli_query($link, $sql);
        //0 t添加失败  1 添加成功
        if (!$result) {
            $arr_code = array('status' => 0);
        } else {
            $arr_code = array('status' => 1);
        }
        exit(json_encode($arr_code));
        break;

    //绑定手机号更改
    case "mobile";
        $phone = $_POST['phone'];
        $code = rand(1000, 9999);
        $arr_code = array('code' => $code, 'phone' => $phone);
        // echo  123;
        echo json_encode($arr_code);
        exit;
        break;

    //结束
    default:
        exit(json_encode(0));







}
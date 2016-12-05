<?php
/**
 * Created by PhpStorm.
 * User: xf231
 * Date: 2016/11/22
 * Time: 16:09
 */

// 连接mysql数据库
$link = mysqli_connect('localhost', 'root', '123456');
if (!$link) {
    echo "connect mysql error!";
    exit();
}

// 选中数据库 my_db为数据库的名字
$db_selected = mysqli_select_db($link, 'mouqu');
if (!$db_selected) {
    echo "<br>selected db error!";
    exit();
}

// 设置mysql字符集 为 utf8
$link->query("set names utf8");

if($_POST){
    $date=date("Y-m-d H:i:s");
    $senter=$_POST['senter'];
    $geter=$_POST['geter'];
    $content=$_POST['message'];
    $sql="INSERT INTO `mouqu`.`chart` (`sender`, `geter`, `content`, `created`)
                   VALUES ('{$senter}','{$geter}','{$content}','{$date}')";
    $result = mysqli_query($link, $sql);



    // $arr['qqq']=print_r($_POST);
    /*  $arr['time']=date("Y-m-d H:i:s");
        $arr['senter']=$_POST['senter'];
        $arr['geter']=$_POST['geter'];
        $arr['content']=$_POST['message'];
        echo json_encode($arr);*/

}

$sql_s = "SELECT `sender`, `geter`, `content`, `created` FROM `chart` WHERE 1";
$result_s = mysqli_query($link, $sql_s);
$arr= mysqli_fetch_all($result_s, MYSQL_ASSOC);
echo json_encode($arr);
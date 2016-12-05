<?php

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




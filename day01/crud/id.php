<?php

header("Content-Type:text/html;charset=utf-8");
//接收要删除的数据 主要删除数据id所在的数据
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $checkbox = $_POST['checkbox'];
    var_dump($_POST);
  }

//获取id并把id数组加到字符串中


?>
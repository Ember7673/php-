<?php
header("Content-Type:text/html;charset=utf-8");
    //接收要删除的数据 主要删除数据id所在的数据
    if(empty($_GET['id'])){
        exit('必须填入参数');
    }
    $id = $_GET['id'];

    // 建立连接
    $connect = mysqli_connect('127.0.0.1','root','123456','text');
    if(!$connect){
        exit('连接数据库失败');
    }
    // 开始查询
    $query = mysqli_query($connect,'delete from users where id in ('. $id .')');
    if(!$query){
        exit('数据库删除失败');
    }
    header("Location: 04-index.php");

?>
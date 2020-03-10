<?php
//此脚本在注册时响应ajax请求判断用户名是否可用
    include_once("configuration.php");
    //连接数据库
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        die("Connection failure: " . $conn->connect_error);
    } 
    //检查username字段
    if(empty($_REQUEST["username"])){
        die("NO USERNAME");
    }
    $username=$_REQUEST["username"];
    //查询数据库
    $sql='select * from agenda_user where username="'.$username.'";';
    $result=$conn->query($sql);
    if($result===FALSE){
        die($conn->error);
    }
    if($result->num_rows==0){
        echo("available");
    }
    else{
        echo("unavailable");
    }
    
    $conn->close();
?>
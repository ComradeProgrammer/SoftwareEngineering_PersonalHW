<?php
//此脚本为注册用脚本
    function show_error($info){
        echo("<script>alert('" . $info."');</script>");
        die("<script>window.location.replace('../register.html')</script>");
    }

    include_once("configuration.php");
    //连接数据库
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        show_error("connection failure:". $conn->connect_error);
    } 
    //检查密码账户名是否为空
    if(!isset($_REQUEST["username"]) ||empty($_REQUEST["username"])){
        show_error("非法的用户名");
    }
    if(!isset($_REQUEST["password"]) ||empty($_REQUEST["password"])){
        show_error("非法的密码");
    }
    //为密码加密
    $encrypted_password=password_hash($_REQUEST["password"],PASSWORD_DEFAULT);
    //尝试添加账户
    $sql="insert into agenda_user(username,password)
            values('".$_REQUEST["username"]."','".$encrypted_password."')";
    if($conn->query($sql)===TRUE){
        echo("<script>window.location.replace('../login.html')</script>");
    }
    else{
        show_error("create account failed!");
    }
?>
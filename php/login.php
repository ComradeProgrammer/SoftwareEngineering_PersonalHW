<?php
    //此脚本为响应登录用脚本
    //BUG 在数据库连不上的时候表现有问题
    function show_error($info){
        echo("<script>alert('" . $info."');</script>");
        die("<script>window.location.replace('../login.html')</script>");
    }

    include_once("configuration.php");

    //输入合法性检查
    if(!isset($_REQUEST["username"]) ||empty($_REQUEST["username"])){
        show_error("非法的用户名");
    }
    if(!isset($_REQUEST["password"]) ||empty($_REQUEST["password"])){
        show_error("非法的密码");
    }
    $username=$_REQUEST["username"];
    $password=$_REQUEST["password"];
    //连接数据库"
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if (!$conn||$conn->connect_error) {
        show_error("connection failure:". $conn->connect_error);
    } 
    
    $sql="select * from agenda_user where username='".$username."'";
    $result=$conn->query($sql);
    if($result->num_rows==0){
        show_error("不存在的用户名");
    }
    else{
        $encrypted_password=$result->fetch_assoc()["password"];
        if(password_verify($password,$encrypted_password)){
            session_start();
            $_SESSION["username"]=$username;
            echo("<script>alert('" . "登录成功"."');</script>");
            die("<script>window.location.replace('../main.html')</script>");
        }
        else{
            show_error("密码不正确");
        }
    }



?>
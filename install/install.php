<?php
    function show_error($info){
        echo("<script>alert(\"" . $info."\");</script>");
        die("<script>window.location.replace('install.html')</script>");
    }
    
    if(!isset($_POST["servername"])||empty($_POST["servername"])){
        show_error("服务器名不能为空");
    }
    if(!isset($_POST["username"])||empty($_POST["username"])){
        show_error("服务器名不能为空");
    }
    if(!isset($_POST["password"])||empty($_POST["password"])){
        show_error("服务器名不能为空");
    }
    if(!isset($_POST["database"])||empty($_POST["database"])){
        show_error("服务器名不能为空");
    }
    $_servername=$_POST["servername"];
    $_username=$_POST["username"];
    $_password=$_POST["password"];
    $_table=$_POST["database"];

    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        show_error($conn->connect_error);
    }

    $sql_user="create table agenda_user(
        username varchar(255) not null primary key,
        password varchar(255) not null
    );";
    $sql_detail="create table agenda_detail(
        agenda_id int unsigned auto_increment primary key,
        agenda_date date,
        agenda_title varchar(200),
        agenda_detail varchar(1000),
        agenda_username varchar(255) not null
    );";

    if (!$conn->query($sql_user)===TRUE){
        show_error($conn->error);
    }
    if (!$conn->query($sql_detail)===TRUE){
        show_error($conn->error);
    }

    $file=fopen("../php/configuration.php","w");
    $time=date("Y-m-d H:i:s");
    $content="<?php
     /*This file is auto-generated at $time*/ 
     \$_servername='$_servername';
     \$_username='$_username';
     \$_password='$_password';
     \$_table='$_table';
    ?>";
    fwrite($file,$content);
    fclose($file);
    echo("<script>alert('配置成功');</script>");
        die("<script>window.location.replace('postinstall.html')</script>");

    $conn->close();
?>
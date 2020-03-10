<?php
    function show_error($info){
        echo("<script>alert('" . $info."');</script>");
        die("<script>window.location.replace('../main.html')</script>");
    }
    session_start();
    include_once("configuration.php");
    //核查身份
    if(!isset($_SESSION["username"])||empty($_SESSION["username"])){
        show_error("身份过期请重新登录");
    }
    $username=$_SESSION["username"];
    //核查输入字段合法
    if(!isset($_REQUEST["id"])||empty($_REQUEST["id"])){
        show_error("非法请求");
    }
    //连接数据库
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        show_error("connection failure:". $conn->connect_error);
    } 
    $sql="delete from agenda_detail where agenda_username='".$username."' and agenda_id=".$_REQUEST["id"].";";
    if($conn->query($sql)===TRUE&&$conn->affected_rows>0){
        show_error("操作成功");
    }
    else{
        show_error("操作失败");
    }      
?>
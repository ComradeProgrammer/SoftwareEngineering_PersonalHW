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
    //连接数据库
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        show_error("connection failure:". $conn->connect_error);
    } 
    if($_REQUEST["date"]!=date("Y-m-d", strtotime($_REQUEST["date"]))){
        show_error("日期不合法");
    }

    if($_REQUEST["type"]=="create"){
        $sql_insert="insert into agenda_detail(agenda_date,agenda_title,agenda_detail,agenda_username)
                    values('".$_REQUEST["date"]."','".$_REQUEST["title"]."','".$_REQUEST["note"]."','".$username."'); ";
        if($conn->query($sql_insert)===TRUE&&$conn->affected_rows>0){
            show_error("操作成功");
        }
        else{
            show_error("操作失败");
        }        
    }
    else if($_REQUEST["type"]=="edit"){    
        $sql_edit="update agenda_detail set agenda_date='".$_REQUEST["date"]."',agenda_title='".$_REQUEST["title"]."',agenda_detail='".$_REQUEST["note"]."'
                    where agenda_id=".$_REQUEST["id"]." and agenda_username='".$username."';";
        if($conn->query($sql_edit)===TRUE&&$conn->affected_rows>0){
            show_error("操作成功");
        }
        else{
            show_error("操作失败");
        }     
    }
?>
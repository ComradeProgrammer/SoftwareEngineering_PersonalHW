<?php
    //此PHP文件响应main页面的ajax请求 以json形势返回各种类型日程的数目统计及其他信息
    class Respond{
        public $username="";
        public $date="";
        public $all_count="";
        public $today_count="";
        public $before_count="";
        public $after_count="";
    }

    include_once("configuration.php");
    //核查session身份
    session_start();
    $respond=new Respond();
    if(!isset($_SESSION["username"])||empty($_SESSION["username"])){
        die(json_encode($respond));
    }
    $respond->username=$_SESSION["username"];
    $username=$_SESSION["username"];
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        die("!connection failure:". $conn->connect_error);
    } 
    $date=date("Y-m-d");
    $respond->date=$date;

    $sql_all="select count(*) from agenda_detail
                where agenda_username='".$username."'";
    $sql_today="select count(*) from agenda_detail
            where agenda_username='".$username."'
            and agenda_date='".$date."'";
    $sql_before="select count(*) from agenda_detail
        where agenda_username='".$username."'
        and agenda_date<'".$date."'";
    $sql_after="select count(*) from agenda_detail
        where agenda_username='".$username."'
        and agenda_date>='".$date."'";

    $result=$conn->query($sql_all);
    $row = $result->fetch_assoc();
    $respond->all_count=$row["count(*)"];

    $result=$conn->query($sql_today);
    $row = $result->fetch_assoc();
    $respond->today_count=$row["count(*)"];

    $result=$conn->query($sql_before);
    $row = $result->fetch_assoc();
    $respond->before_count=$row["count(*)"];

    $result=$conn->query($sql_after);
    $row = $result->fetch_assoc();
    $respond->after_count=$row["count(*)"];

    echo(json_encode($respond));

?>
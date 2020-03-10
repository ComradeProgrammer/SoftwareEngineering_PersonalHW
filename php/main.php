<?php
    class Respond{
        public $username="";
        public $agenda=array();
    }

    class Item{
        public $title;
        public $date;
        public $detail;
        public $id;
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
    //连接数据库
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        die("!connection failure:". $conn->connect_error);
    } 

    //根据类型生成SQL语句
    $date=date("Y-m-d");
    if(!isset($_REQUEST["querytype"])||empty($_REQUEST["querytype"])){
        die("!illegal query type");
    }

    elseif($_REQUEST["querytype"]=="all"){
        //查询所有日程
        $sql="select * from agenda_detail
                where agenda_username='".$username."'";
    }
    elseif($_REQUEST["querytype"]=="today"){
        //查询今日日程
        $sql="select * from agenda_detail
                where agenda_username='".$username."'
                and agenda_date='".$date."'";
    }
    elseif($_REQUEST["querytype"]=="before"){
        //查询已过期日程
        $sql="select * from agenda_detail
                where agenda_username='".$username."'
                and agenda_date<'".$date."'";
    }
    elseif($_REQUEST["querytype"]=="after"){
        //查询未过期日程
        $sql="select * from agenda_detail
                where agenda_username='".$username."'
                and agenda_date>='".$date."'";
    }
    else{
        die("!illegal query type");
    }
    //查询数据库
    $result=$conn->query($sql);
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()) {
            $tmp=new Item();
            $tmp->title=$row["agenda_title"];
            $tmp->detail=$row["agenda_detail"];
            $tmp->date=$row["agenda_date"];
            $tmp->id=$row["agenda_id"];
            array_push($respond->agenda,$tmp);
        }
    }
    echo(json_encode($respond));
?>
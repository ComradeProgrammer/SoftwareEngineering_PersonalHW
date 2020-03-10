<?php
    class Respond{
        public $correct=FALSE;
        public $title="";
        public $date="";
        public $detail="";
    }
    include_once("configuration.php");
    session_start();
    $respond=new Respond();
    //核查身份
    if(!isset($_SESSION["username"])||empty($_SESSION["username"])){
        die(json_encode($respond));
    }
    $username=$_SESSION["username"];
    //连接数据库
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        die("!connection failure:". $conn->connect_error);
    } 
    //核查ID
    if(!isset($_REQUEST["id"])||empty($_REQUEST["id"])){
        die("!illegal query type");
    }
    $id=$_REQUEST["id"];
    $sql="select * from agenda_detail
                where agenda_username='".$username."'
                and agenda_id=".$id.";";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $respond->correct=TRUE;
        $respond->title=$row["agenda_title"];
        $respond->detail=$row["agenda_detail"];
        $respond->date=$row["agenda_date"];
    }
    die(json_encode($respond));
?>
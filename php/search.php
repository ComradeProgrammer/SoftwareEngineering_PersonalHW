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

    //核查keyword
    if(!isset($_REQUEST["key"])||empty($_REQUEST["key"])){
        die("!illegal request");
    }
    $key=$_REQUEST["key"];

    
    $conn = new mysqli($_servername, $_username, $_password,$_table);
    if ($conn->connect_error) {
        die("!connection failure:". $conn->connect_error);
    } 
    $sql="select * from agenda_detail
        where agenda_username='".$username."'
        and (agenda_title like '%".$key."%'
            or agenda_detail like '%".$key."%')";
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
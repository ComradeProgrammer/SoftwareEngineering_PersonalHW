<html>
    <head>
        <title>install</title>
    </head>
    <body>
        <?php
        //此PHP文件为安装脚本
            include_once("configuration.php");
            //检查连接
            $conn = new mysqli($_servername, $_username, $_password,$_table);
            if ($conn->connect_error) {
                die("Connection failure: " . $conn->connect_error);
            } 
            echo "connection success <br/>";

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

            if ($conn->query($sql_user)===TRUE){
                echo "successfully create table agenda_user<br/>";
            }
            else{
                echo $conn->error."<br>";
            }

            if ($conn->query($sql_detail)===TRUE){
                echo "successfully create table agenda_user<br/>";
            }
            else{
                echo $conn->error."<br>";
            }

            $conn->close();

        ?>
    </body>
</html>
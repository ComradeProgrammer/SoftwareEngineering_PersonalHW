window.onload=autoAdjustSize;
window.onresize=autoAdjustSize;

function autoAdjustSize(){
    var width=window.innerWidth;
    var login_box=document.getElementById("register_box");
    if(width<=750){
        login_box.style.width="600px";
    }
    else{
        login_box.style.width="80%";
    }
}

function check_username_validity(){
    document.getElementById("username_status").src="image/wait.png";
    var username=document.getElementById("username").value;
    //检查是否符合规则
    var reg=/^[a-zA-Z][a-zA-Z_0-9]*$/
    if(!reg.test(username)){
        document.getElementById("username_status").src="image/no.png";
        document.getElementById("alert_username").innerHTML="用户名只能包含大小写英文字母 数字与下划线且以字母开头";
        return false;
    }
    //请求后端检查是否名字有重复
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            if(this.responseText=="available"){
                document.getElementById("username_status").src="image/yes.png";
                document.getElementById("alert_username").innerHTML="";
            }
            else if(this.responseText=="unavailable"){
                document.getElementById("username_status").src="image/no.png";
                document.getElementById("alert_username").innerHTML="此用户名已被占用";
            }
            else{
                document.getElementById("username_status").src="image/no.png";
                alert(this.responseText);
            }
        }
    }
    xmlhttp.open("get","php/testusername.php?username="+username);
    xmlhttp.send();
    return true;
}

function check_password(){
    var password=document.getElementById("password").value;
    if(password.length<6||password.length>100){
        document.getElementById("password_status").src="image/no.png";
        document.getElementById("alert_password").innerHTML="密码不能少于6位或多于100位";
        return false;
    }
    else{
        document.getElementById("password_status").src="image/yes.png";
        document.getElementById("alert_password").innerHTML="";
        return true;
    }

}

function check_repassword(){
    var password=document.getElementById("password").value;
    var repassword=document.getElementById("confirm_password").value;
    if(password!=repassword||password==repassword&&password==""){
        document.getElementById("repassword_status").src="image/no.png";
        if(password!=""){
            document.getElementById("alert_confirm_password").innerHTML="两次密码不符";
        }
        return false;
    }
    else{
       
        document.getElementById("repassword_status").src="image/yes.png";
        document.getElementById("alert_confirm_password").innerHTML="";
        return true;
    }
}

function register(){
    if(!(check_password()&&check_repassword()&&check_username_validity())){
        return;
    }
    if(document.getElementById("username_status").src=="image/no.png"){
        return;
    }
    else{
        document.getElementById("hidden_button").click();
    }
}
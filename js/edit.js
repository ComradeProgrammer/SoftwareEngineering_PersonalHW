function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");  
}
function parseGET(){
    var str=window.location.search;
    var length=str.length;
    if(length==0){
        return null;
    }
    str=str.substring(1,length);
    length=length-1;
    var tmp=str.split("&");
    var res=new Object();
    for(var i=0;i<tmp.length;i++){
        var tmp2=tmp[i].split("=");
        if(tmp2.length==1){
            res[tmp2[0]]="";
        }
        else{
            res[tmp2[0]]=tmp2[1];
        }

    }
    return res;
}

function dateCheck(obj){
    var tmp=obj.value;
    var regex=/^(\d\d\d\d)-(\d\d)-(\d\d)$/;
    if(!regex.test(tmp)){
        document.getElementById("date_frame").style.color="red";
        return false; 
    }
    document.getElementById("date_frame").style.color="#bbbbbb";
    return true;
}

function checkandSubmit(){
    if(!dateCheck(document.getElementById("agenda_date"))){
        return;
    }
    var type=document.getElementById("agenda_type");
    var id=document.getElementById("agenda_id");
    var bundle=parseGET();
    if(bundle==null||bundle["type"]==null){
        alert("错误:请求类型非法");
        window.location.href="login.html";
    }
    if(bundle["type"]=="create"){
        type.value="create"
        id.value=""
    }
    else if(bundle["type"]=="edit"){
        type.value="edit"
        if(bundle["id"]==null || isNaN(bundle["id"])){
            alert("错误:请求类型非法");
            window.location.href="login.html";
        }
        else{
            id.value=bundle["id"];
        }
    }
    else{
        alert("错误:请求类型非法");
        window.location.href="login.html";
    }
    document.getElementById("hidden_submit").click();
}

function abortEdit(){
    window.location.href="main.html";
}

function pre_load(){
    var agenda_id;
    var bundle=parseGET();
    if(bundle==null||bundle["type"]==null){
        alert("错误:请求类型非法");
        window.location.href="login.html";
    }
    if(bundle["type"]=="create"){
        return;
    }
    else if(bundle["type"]=="edit"){
        if(bundle["id"]==null || isNaN(bundle["id"])){
            alert("错误:请求类型非法");
            window.location.href="login.html";
        }
        else{
            agenda_id=bundle["id"];
        }
    }
    else{
        alert("错误:请求类型非法");
        window.location.href="login.html";
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            if(this.responseText[0]=='!'){
                alert(this.responseText);
            }
            else{
                var respond=JSON.parse(this.responseText);
                if(respond.correcct==false){
                    alert("错误请求");
                    window.location.href="login.html";
                }
                else{
                    document.getElementById("agenda_date").value=respond.date;
                    document.getElementById("agenda_title").value=respond.title;
                    document.getElementById("agenda_detail").value=respond.detail;
                }
            }
        }
    }
    xmlhttp.open("get","php/editpreload.php?id="+agenda_id);
    xmlhttp.send();
}
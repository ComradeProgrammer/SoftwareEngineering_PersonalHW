window.onload=autoAdjustSize;
window.onresize=autoAdjustSize;
function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");  
}
function autoAdjustSize(){
    var width=window.innerWidth;
    var login_box=document.getElementById("main_body");
    if(width<=860){
        login_box.style.width="860px";
    }
    else{
        login_box.style.width=width+"px";
    }
}

function updateInformation(){
    var xmlhttp2=new XMLHttpRequest();
    xmlhttp2.onreadystatechange=function(){
        if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
            if(this.responseText[0]=='!'){
                alert(this.responseText);
            }
            else{
                var respond=JSON.parse(this.responseText);
                if(respond.username==""){
                    alert("登录过期，请重新登录");
                    window.location.href="login.html";
                }
                else{
                    document.getElementById("greetings").innerHTML="你好"+respond.username;
                    document.getElementById("date").innerHTML="今天是"+respond.date;
                    document.getElementById("agenda_today").innerHTML="今日日程数:"+respond.today_count;
                    document.getElementById("agenda_all").innerHTML="全部日程数:"+respond.all_count;
                    document.getElementById("agenda_past").innerHTML="已完成日程数:"+respond.before_count;
                    document.getElementById("agenda_future").innerHTML="未完成日程数:"+respond.after_count;
                }
            }
        }
    }
    xmlhttp2.open("get","php/information.php");
    xmlhttp2.send();
}
function generateItem(obj){
    var items=document.getElementById("agenda_items");
    var item=document.createElement("iframe");
    item.setAttribute("class","item");
    item.setAttribute("scrolling","no");
    item.setAttribute("src","item.html");
    item.onload=function(){
        this.contentWindow.document.getElementById("item_date").innerHTML=obj.date;
        this.contentWindow.document.getElementById("item_title").innerHTML=obj.title;
        this.contentWindow.document.getElementById("item_description").innerHTML=obj.detail;
        this.contentWindow.document.getElementById("item_id").innerHTML=obj.id;
    }
    items.appendChild(item);
}

function typeButtonOnClick(type,button){
    button.style.border='2px solid red';
    for(var i=1;i<=4;i++){
        var leftid="left"+i;
        var tmp=document.getElementById(leftid);
        if(tmp!=button){
            tmp.style.border="2px solid #363636";
        }
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            if(this.responseText[0]=='!'){
                alert(this.responseText);
            }
            else{
                var respond=JSON.parse(this.responseText);
                if(respond.username==""){
                    alert("登录过期，请重新登录");
                    window.location.href="login.html";
                }
                else{
                    var items=document.getElementById("agenda_items");
                    items.innerHTML="";
                    for(var i=0;i<respond.agenda.length;i++){
                        generateItem(respond.agenda[i]);
                    }
                }
            }
        }
    }
    xmlhttp.open("get","php/main.php?querytype="+type);
    xmlhttp.send();
}

function bodyOnload(){
    updateInformation();
    typeButtonOnClick("today",document.getElementById("left1"));
}

function createAgenda(){
    window.location.href="edit.html?type=create";
}

function editAgenda(agenda_id){
    window.location.href="edit.html?type=edit&id="+agenda_id;
}

function deleteAgenda(agenda_id){
    window.location.href="php/delete.php?id="+agenda_id;
}
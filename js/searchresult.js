function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");  
}

function editAgenda(agenda_id){
    window.location.href="edit.html?type=edit&id="+agenda_id;
}

function deleteAgenda(agenda_id){
    window.location.href="php/delete.php?id="+agenda_id;
}

function generateItem(obj){
    var items=document.getElementById("center_bar");
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

function requestSearchResult(){
    var str=window.location.search;
    var regex=/^\?key=.*$/;
    if(!regex.test(str)){
        alert("非法请求");
        window.location.href="main.html";
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            if(this.responseText[0]=='!'){
                alert(this.responseText);
                window.location.href="main.html";
            }
            else{
                var respond=JSON.parse(this.responseText);
                if(respond.username==""){
                    alert("登录过期，请重新登录");
                    window.location.href="login.html";
                }
                else{
                    var items=document.getElementById("center_bar");
                    items.innerHTML="";
                    document.getElementById("briefing").innerHTML="总计"+respond.agenda.length+" 个符合条件的结果";
                    for(var i=0;i<respond.agenda.length;i++){
                        generateItem(respond.agenda[i]);
                    }
                }
            }
        }
    }
    xmlhttp.open("get","php/search.php"+str);
    xmlhttp.send();
}
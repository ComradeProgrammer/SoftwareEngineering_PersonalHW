window.onload=autoAdjustSize;
window.onresize=autoAdjustSize;
function autoAdjustSize(){
    var width=window.innerWidth;
    var login_box=document.getElementById("login_box");
    if(width<=500){
        login_box.style.width="400px";
    }
    else{
        login_box.style.width="80%";
    }
}

function register_onclick(){
    window.location.href="register.html";
}
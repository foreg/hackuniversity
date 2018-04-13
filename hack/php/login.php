<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="rightMenu">
    <div class="korpus">
        <input type="radio" name="odin" checked="checked" id="vkl1"/><label id="label1" for="vkl1">Войти</label><input type="radio" name="odin" id="vkl2"/><label for="vkl2">Зарегистрироваться</label>
        <div><!--старый юзер-->
            <form class="vhod">
                <p class="small">Введите логин</p> 
                <input type="text" name="Email"             value=""                        placeholder="Логин"></input>
                <p class="small">Введите пароль</p> 
                <input type="password" name="Password"          value=""                        placeholder="Пароль"></input>
                <input type="button" name="add" class="btn" value="Войти" onclick = "login(this)"></input>
            </form>
        </div>
        <div> <!--новый юзер-->
            <form class="register">
                <p class="small">E-mail</p>                 
                <input type="text" name="email"             value=""                        placeholder="e-mail"></input>
                <p class="small">Пароль (не менее 6 латинских символов разного регистра)</p> 
                <input type="password" name="PasswordN"          value=""                        placeholder="Пароль"></input>
                <p class="small">Подтвердите пароль</p> 
                <input type="password" name="Confirm"           value=""                        placeholder="Подтвердите"></input>
                <input type="button" name="add" class="btn" value="Зарегистрироваться" onclick = "newUser(this)"></input>
            </form>
        </div>
    </div>
</div>
<?

?>


<script>
// instantLogin();
// function instantLogin() {
//     var xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if (this.DONE == this.readyState) {
//             if(this.responseText == "") {
//                 //alert("Такая связка логин-пароль не найдена");
//             }
//             else {
//                 //alert("Добро пожаловать " + this.responseText);
//                 setCookie("username",document.getElementsByName('Email')[0].value,365);
//                 window.location = "https://127.0.0.1/_lab4/cart.html";
//             }
//         }
    
//     };
//     xmlhttp.open("POST",'/_lab4/submit.php' , true);
//     xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xmlhttp.send();
// }
function login() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            if(this.responseText == "") {
                alert("Такая связка логин-пароль не найдена");
            }
            else {
                //alert("Добро пожаловать " + this.responseText);
                setCookie("username",document.getElementsByName('Email')[0].value,365);
                window.location = "https://127.0.0.1/hack/profile.php";
            }
        }
    
    };
    var body =  'Type=register' + 
                '&Email=' + document.getElementsByName('Email')[0].value + 
                '&Password='+ document.getElementsByName('Password')[0].value;
    xmlhttp.open("POST",'/hack/php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
}
function newUser(t) {
var regForEmail = /^[A-Za-z0-9]{1,}@\w{2,6}.\w{2,3}$/;

    if (regForEmail.test(document.getElementsByName('email')[0].value)) {
        if (document.getElementsByName('PasswordN')[0].value == document.getElementsByName('Confirm')[0].value) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.DONE == this.readyState){
                    if(this.responseText == "") {
                        alert("Пользователь успешно зарегистрирован. Войдите с аккаунт");
                        //alert(this.responseText.indexOf("Пользователь"+" с таким логином уже есть"));
                        location.reload();  
                    }
                    else {
                        alert(this.responseText);
                    }
                }
            };
            var body = 'Type=register' + 
            '&Email=' + document.getElementsByName('email')[0].value + 
            '&Password='+ document.getElementsByName('PasswordN')[0].value;
            xmlhttp.open("POST",'/hack/php/submit.php' , true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.send(body);
        }
        else {
            alert("Пароли должны совпадать");
        }
    }
    else {
        alert("Введен неправильный e-mail");                
    }
}

function setCookie(c_name,value,exdays) {
        var exdate=new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
        document.cookie=c_name + "=" + c_value;
    }
function getCookie(c_name){
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++) {
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name) {
            return unescape(y);
        }
    }
}
function checkCookie() {
    var username=getCookie("purchases");
    if (username!=null && username!="") {
        return true
    }
    else {
        return false;
    }
}


</script>
</body>
</html>
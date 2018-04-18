<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<div class="rightMenu">
    <div class="greetings">
        <span id="g"></span><div id = "placeForExitButton"></div>
    </div>
</div>
<div class = "content">
    <div class = "left">
        <input type = "button" id = "NewDog" onclick = "AddDog()" value = "Добавить собаку">
        <?
            include("DogHandler.php");
            Dog::Show($_COOKIE["username"]);
        ?>
        
    </div>
</div>



<script>
checkRights();
    function JoinCourses() {
        location = "../courses.html";
    }
    function OpenMap() {
        location = "../map.html";
    }
    function AddDog() {
        document.getElementById("NewDog").hidden = true;
        var div = document.createElement("div");
        div.id = "dog";
        div.classList.add("top", "dog");
        div.innerHTML = "<h1>Занесение информации о собаке</h1>";
        var closeBTN = document.createElement("img");
        closeBTN.src = "../img/close.png";
        closeBTN.classList.add("closeBTN");
        closeBTN.onclick = () => {
            document.getElementById("dog").remove();
        document.getElementById("NewDog").hidden = false;            
        }
        div.appendChild(closeBTN);
        var form  = document.createElement("form");
        form.id = "form";
        form.method = "POST";
        form.action = "DogHandler.php";
        
        var Type = document.createElement("input");
        Type.type = "hidden";
        Type.name = "Type";
        Type.value = "AddNewDog";

        var Name = document.createElement("input");
        Name.type = "text";
        Name.name = "name";
        Name.placeholder = "Кличка";

        var Breed = document.createElement("input");
        Breed.type = "text";
        Breed.name = "breed";
        Breed.placeholder = "Порода";
        
        var Size = document.createElement("input");
        Size.type = "text";
        Size.name = "size";
        Size.placeholder = "Размер";

        var Sex = document.createElement("input");
        Sex.type = "text";
        Sex.name = "sex";
        Sex.placeholder = "Пол";

        var Age = document.createElement("input");
        Age.type = "text";
        Age.name = "age";
        Age.placeholder = "Возраст";

        var Comments = document.createElement("input");
        Comments.type = "text";
        Comments.name = "comments";
        Comments.placeholder = "Комментарии";

        var Submit = document.createElement("input");
        Submit.type = "submit";
        Submit.name = "submit";
        Submit.value = "Добавить";

        
        document.body.appendChild(div);
        document.getElementById("dog").appendChild(form);
        document.getElementById("form").appendChild(Type);
        document.getElementById("form").appendChild(Name);
        document.getElementById("form").appendChild(Breed);
        document.getElementById("form").appendChild(Size);
        document.getElementById("form").appendChild(Sex);
        document.getElementById("form").appendChild(Age);
        document.getElementById("form").appendChild(Comments);
        document.getElementById("form").appendChild(Submit);
    }
    if (checkCookie()) {
        var btn = document.createElement ('input');
        btn.type = 'button';
        btn.onclick = exi;
        btn.value = 'Exit';
        document.getElementById('placeForExitButton').appendChild(btn);
        document.getElementById("g").innerHTML = "Добро пожаловать";
        document.getElementsByClassName("greetings")[0].classList.remove("displayNone");
        var menu = document.createElement("ul");
        menu.id = "menu";
        document.getElementsByClassName("greetings")[0].appendChild(menu); 
    }
function exi() {
    //alert("d");
    setCookie("username", "", {expires: -1})
	location = "login.php?in";
    }
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

function Walk(sender) {
var defaultAdress;
//alert(mark.name);
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.DONE == this.readyState) {
        defaultAdress = this.responseText;
    }
};
var body =  'Type=GetAdress' + 
            '&dogId=' + sender.id;
xmlhttp.open("POST",'/hack/php/submit.php' , true);
xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlhttp.send(body);
setTimeout(()=>{
var div = document.createElement("div");
div.id = "dog";
div.classList.add("top", "dog");
div.innerHTML = "<h1>Занесение информации о прогулке</h1>";
div.innerHTML += "<h3>" + sender.id+ "</h3>";
div.innerHTML += "<form action = 'submit.php' method='POST'> " 
+ "<input type='datetime-local' name = 'date'>"
+ "<input type='text' name = 'adress' value = '"+defaultAdress+"'>"
+ "<input type='text' name = 'duration' placeholder='duration'>"
+ "<input type='text' name = 'price' placeholder='price'>"
+ "<input type='hidden' name = 'dogId' value = "+sender.id+">"
+ "<input type='submit' name = 'Type' value = 'Отправить'>"; //поменять submit.php если менять value
+ "</form>";
var closeBTN = document.createElement("img");
closeBTN.src = "img/close.png";
closeBTN.classList.add("closeBTN");
closeBTN.onclick = () => {
    document.getElementById("dog").remove();
}
div.appendChild(closeBTN);
//alert(sender.name);
document.body.appendChild(div);
}, 300);

}


function checkRights() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            if(this.responseText == "0") {
                document.getElementsByClassName("left")[0].innerHTML += '<input type = "button" id = "JoinCourses" onclick = "JoinCourses()" value = "Записаться на курсы">';
            }
            else {
                document.getElementsByClassName("left")[0].innerHTML += '<input type = "button" id = "OpenMap" onclick = "OpenMap()" value = "Перейти к карте">';
            }
        }
    
    };
    var body =  'Type=checkRights' + 
                '&Username=' + getCookie("username") + 
    xmlhttp.open("POST",'/hack/php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
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
    var username=getCookie("username");
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
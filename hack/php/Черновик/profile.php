<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <!--    <link href="../css/style.css" rel="stylesheet">-->
    <link rel="stylesheet" href="libs/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
</head>
<body>
<div class="bgk1">
    <section class="contacts">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left"><span
                            class="glyphicon glyphicon-home"></span><span> г.Тюмень ул.Ленина 23</span>
                    </div>
                    <div class="pull-right mar"><span class="glyphicon glyphicon-envelope"></span>
                        WallkieDog@mail.ru
                    </div>
                    <div class="pull-right"><span class="glyphicon glyphicon-headphones"></span>
                        +7(12340)22-22-22
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="menu">
        <div class="container">
            <div class="row ">
                <div class="menuOpt">
                    <ul class="col-md-2 coord pull-left">
                        <li class="logo"><img src="img/logo.png" height="80" width="80"/></li>
                    </ul>
                    <ul class=" col-md-5 coord pull-left">
                        <li class="gyper"><a href="#">о нас</a></li>
                        <li class="gyper"><a href="#">выгульщики</a></li>
                        <li class="gyper"><a href="#">отзывы</a></li>
                        <li class="gyper"><a href="#">рейтинг</a></li>
                    </ul>
                    <ul class="col=md-2 coord pull-right">
                        <li>
                            <div id="placeForExitButton"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="main">
    <div class="OrderDogs">
        <h1>Ваши питомцы</h1>



        <div class = "left">
            <input type = "button" id = "NewDog" onclick = "AddDog()" value = "Добавить собаку">
            <?
            include("DogHandler.php");
            Dog::Show($_COOKIE["username"]);
            ?>
            <div class="medium">
                <!--            <input type="button" id="NewDog " onclick="AddDog()" class="submit2" value="Добавить">-->
                <input type="button" id="" onclick="Refresh()" class="submit2" value="Обновить">
                <input type="button" id="" onclick="Delete()" class="submit2" value="Удалить">
                <input type="submit" class="walking" id="submit2" value="Гулять"> </input>
            </div>
        </div>


        <!--        <a href="#"> <span id ="refresh" class='glyphicon glyphicon-refresh'> </span> </a>-->
        <!--        <a href="#"> <span id = "remove" class='glyphicon glyphicon-remove'> </span> </a>-->


        <!--<input type="button" id="submit2" name="submit" value="Изменить">-->
        <!--<input type="button" id="submit1" name="submit" value="Удалить">-->
        <! код Php !>
    </div>
    <form id="loginLK" action="#" method="post">
        <h1>Личный кабинет</h1>
        <fieldset id="inputs1">
            <div class="Blocks">
                <div class="textDiv">ФИО</div>
                <input id="username" name="login" type="text" placeholder="Слепченко В.П." autofocus required></div>
            <div class="Blocks1">
                <div class="textDiv">Телефон</div>
                <input id="password" name="password" type="text" placeholder="+79224789108" required></div>
            <div class="Blocks">
                <div class="textDiv">E-mail</div>
                <input id="password" name="password" type="text" placeholder="hedgehog9898@Mail.ru" required></div>
            <div class="Blocks1">
                <div class="textDiv">Адрес</div>
                <input id="password" name="password" type="text" placeholder="ул. Харьковская 27/кв 31" required></div>
            <div class="Blocks">
                <div class="textDiv">Соц.сети</div>
                <input id="password" name="password" type="text" placeholder="vk.com/login" required></div>
            <div class="Blocks1">
                <div class="textDiv">&nbsp;&nbsp;</div>
                <input name="password" class="orange" id="submit1" type="submit" value="Сохранить" required></div>
        </fieldset>
    </form>
</div>
<section class="end">
    <div class="container">
        <div class="row">
            <div class="col-md-3 ">
                <h3 class="Color2">Контакты</h3>
                <div class="Color2 pull-left "><span
                        class="glyphicon glyphicon-home"></span><span> г.Тюмень ул.Ленина 23</span>
                </div>
                <div class="Color2 pull-left topp"><span class="glyphicon glyphicon-envelope"></span>
                    WallkieDog@mail.ru
                </div>
                <div class="Color2 pull-left topp"><span class="glyphicon glyphicon-headphones"></span>
                    +7(12340)22-22-22
                </div>
            </div>
            <div class="col-md-2">
                <h3 class="Color2 about">Ссылки</h3>
                <ul class="coord1 Color2">
                    <li><a href="#">о нас</a></li>
                    <li><a href="#">выгульщики</a></li>
                    <li><a href="#">особенности</a></li>
                    <li><a href="#">рейтинг</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>




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
        closeBTN.onclick = () =>
        {
            document.getElementById("dog").remove();
            document.getElementById("NewDog").hidden = false;
        }
        div.appendChild(closeBTN);
        var form = document.createElement("form");
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
        var btn = document.createElement('input');
        btn.type = 'submit';
        btn.name = 'in';
        btn.onclick = exi;
        btn.className = 'btn1St Color3';


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
        setCookie("username", "", {expires: -1});
        location = "login.php";
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
        xmlhttp.onreadystatechange = function () {
            if (this.DONE == this.readyState) {
                if (this.responseText == "") {
                    alert("Такая связка логин-пароль не найдена");
                }
                else {
                    //alert("Добро пожаловать " + this.responseText);
                    setCookie("username", document.getElementsByName('Email')[0].value, 365);
                    window.location = "https://127.0.0.1/hack/profile.php";
                }
            }

        };
        var body = 'Type=register' +
            '&Email=' + document.getElementsByName('Email')[0].value +
            '&Password=' + document.getElementsByName('Password')[0].value;
        xmlhttp.open("POST", '/hack/php/submit.php', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send(body);
    }
    function newUser(t) {
        var regForEmail = /^[A-Za-z0-9]{1,}@\w{2,6}.\w{2,3}$/;

        if (regForEmail.test(document.getElementsByName('email')[0].value)) {
            if (document.getElementsByName('PasswordN')[0].value == document.getElementsByName('Confirm')[0].value) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.DONE == this.readyState) {
                        if (this.responseText == "") {
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
                    '&Password=' + document.getElementsByName('PasswordN')[0].value;
                xmlhttp.open("POST", '/hack/php/submit.php', true);
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
        xmlhttp.onreadystatechange = function () {
            if (this.DONE == this.readyState) {
                defaultAdress = this.responseText;
            }
        };
        var body = 'Type=GetAdress' +
            '&dogId=' + sender.id;
        xmlhttp.open("POST", '/hack/php/submit.php', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send(body);
        setTimeout(() = >{
            var div = document.createElement("div");}
        div.id = "dog";
        div.classList.add("top", "dog");
        div.innerHTML = "<h1>Занесение информации о прогулке</h1>";
        div.innerHTML += "<h3>" + sender.id + "</h3>";
        div.innerHTML += "<form action = 'submit.php' method='POST'> "
            + "<input type='datetime-local' name = 'date'>"
            + "<input type='text' name = 'adress' value = '" + defaultAdress + "'>"
            + "<input type='text' name = 'duration' placeholder='duration'>"
            + "<input type='text' name = 'price' placeholder='price'>"
            + "<input type='hidden' name = 'dogId' value = " + sender.id + ">"
            + "<input type='submit' name = 'Type' value = 'Отправить'>"; //поменять submit.php если менять value
        +"</form>";
        var closeBTN = document.createElement("img");
        closeBTN.src = "img/close.png";
        closeBTN.classList.add("closeBTN");
        closeBTN.onclick = () =>
        {
            document.getElementById("dog").remove();
        }
        div.appendChild(closeBTN);
//alert(sender.name);
        document.body.appendChild(div);
    },
        300
    )
        ;

    }


    function checkRights() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.DONE == this.readyState) {
                if (this.responseText == "0") {
                    document.getElementsByClassName("left")[0].innerHTML += '<input type = "button" id = "JoinCourses" onclick = "JoinCourses()" value = "Записаться на курсы">';
                }
                else {
                    document.getElementsByClassName("left")[0].innerHTML += '<input type = "button" id = "OpenMap" onclick = "OpenMap()" value = "Перейти к карте">';
                }
            }

        };
        var body = 'Type=checkRights' +
            '&Username=' + getCookie("username") +
            xmlhttp.open("POST", '/hack/php/submit.php', true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send(body);
    }
    function setCookie(c_name, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
        document.cookie = c_name + "=" + c_value;
    }
    function getCookie(c_name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == c_name) {
                return unescape(y);
            }
        }
    }
    function checkCookie() {
        var username = getCookie("username");
        if (username != null && username != "") {
            return true
        }
        else {
            return false;
        }
    }


</script>
</body>
</html>
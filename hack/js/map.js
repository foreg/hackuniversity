var myMap;

// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);
function init () {
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map").
    myMap = new ymaps.Map('map', {
        // При инициализации карты обязательно нужно указать
        // её центр и коэффициент масштабирования.
        center: [57.14, 65.56], // Тюмень
        //center: [59.99,30.29], // Питер
        zoom: 13,
        controls: ['zoomControl']
    });
    var geolocation = ymaps.geolocation;
    // geolocation.get({
    //     provider: 'yandex',
    //     mapStateAutoApply: true
    // }).then(function (result) {
    //     // Красным цветом пометим положение, вычисленное через ip.
    //     result.geoObjects.options.set('preset', 'islands#redCircleIcon');
    //     result.geoObjects.get(0).properties.set({
    //         balloonContentBody: 'Мое местоположение'
    //     });
    //     myMap.geoObjects.add(result.geoObjects);

    // });
    geolocation.get({
        provider: 'auto',
        timeout: 5000
        //mapStateAutoApply: true
    }).then(function (result) {
        // Синим цветом пометим положение, полученное через браузер.
        // Если браузер не поддерживает эту функциональность, метка не будет добавлена на карту.
        //result.geoObjects.options.set('preset', 'islands#blueCircleIcon');
        //myMap.geoObjects.add(result.geoObjects);
        myMap.setCenter(result.geoObjects.position, 15  );
        //var mark = AddMark(myMap.getCenter());
        // var myGeoCoder = ymaps.geocode('Тюмень', {
        //     results:1
        // }).then(function(res){
        //     mark.getAddressLine();
        // });
        //myMap.geoObjects.add(mark);
        //myMap.setZoom(15);
    }, function(error) {
        //myMap.geoObjects.add(AddMark(myMap.getCenter()));
    });

    geoCollection = new ymaps.GeoObjectCollection(null, {
        preset: 'islands#blackStretchyIcon'
    });
    // Ids = [0,1];
    // Coords = [[57.15034181391009,65.57326084136761], [57.15534181391009,65.57326084136761]];
    // Titles = ["Пес1", "Пес2"];
    // ShortDescription = ["Шибаину", "Мопс"];
    // FullDescription = [ "ФОТО, Шиба, средний размер, гулять 50 минут, телефон владельца +79999999999",
    //                     "Мопс, маленький, гулять 30 минут, телефон +79999999999"];
    // for (var i = 0, l = Coords.length; i < l; i++) {
    //     geoCollection.add(new ymaps.Placemark(Coords[i], {
    //         iconContent: Titles[i],
    //         balloonContent: ShortDescription[i] + "<input type='button' value = 'Хочу выгуливать' name='" + Ids[i].toString() + "' onclick=Book(this)>"
    //     }));
    //     // var d = geoCollection.get(i);
    //     // d.ballon.iconContent = i.toString();
    // }
    ShowDogs();
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function demo() {

        await sleep(2000);
    }

    demo();
    // myGeoObject = new ymaps.GeoObject({
    //     // Описание геометрии.
    //     geometry: {
    //         type: "Point",
    //         coordinates: [57.15034181391009,65.57326084136761]
    //     },
    //     // Свойства.
    //     properties: {
    //         // Контент метки.
    //         iconContent: 'Кличка',
    //         hintContent: 'Порода песи'
    //     }
    // }, {
    //     // Опции.
    //     // Иконка метки будет растягиваться под размер ее содержимого.
    //     preset: 'islands#blackStretchyIcon',
    //     draggable: true
    //     // Метку можно перемещать.
    // })
    geoCollection.events.add(['dragend'], function (e) {
        alert(e.originalEvent.target.geometry._coordinates);
    });
    myMap.geoObjects.add(geoCollection);

}

function Book(sender) {
    //SELECT Walks.Id,`DogID`, Dogs.OwnerId, Dogs.Name, Dogs.Breed, Dogs.Size, Dogs.Sex, Dogs.Age, Dogs.Comments, Users.Name, Users.Phone,`Date`,`Duration`,`Price` FROM Walks INNER Join Dogs ON Dogs.Id = Walks.DogID INNER JOIN Users ON Dogs.OwnerId = Users.id
    var div = document.createElement("div");
    div.id = "info";
    div.classList.add("top", "info");
    // div.innerHTML = "<h1>" + sender.name + "</h1>";

    var xmlhttp = new XMLHttpRequest();
    //var walkId;
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            var res = this.responseText.split('_');
            //walkId = res[0];

            var mas = ["Участники аукциона","Кличка","Порода","Размер","Пол","Возраст","Коментарии","Имя выгульщика","Телефон","Дата/время заказа","Время прогулки","Деньги(Руб.)"];
            var t=1;
            for (var i = 3; i < res.length; i++) {

                var span = document.createElement("span");
                span.classList.add("top");

                span.innerHTML = mas[t]+": ";

                span.innerHTML += res[i] +"<br>";
                div.appendChild(span);
                t++;
            }
        }

    };
    var body =  'Type=WalkInfo' +
        '&walkId=' + sender.name;
    xmlhttp.open("POST",'php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);


    var closeBTN = document.createElement("img");
    closeBTN.src = "img/close.png";
    closeBTN.classList.add("closeBTN");
    closeBTN.onclick = () => {
        document.getElementById("info").remove();
        clearInterval(timerId);
    }
    div.appendChild(closeBTN);
    //alert(sender.name);
    document.body.appendChild(div);

    //ShowBets(walkId);
}

function Refresh(walkId) {
    var itemsToDelete =document.getElementsByClassName("auction");
    for (var i = 0; itemsToDelete.length > 0; i++) {
        itemsToDelete[i].remove();
        i--;
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            var res = this.responseText.split('_');

            for (var i = 0; i < res.length; i++) {
                var span = document.createElement("span");
                //span.classList.add("auction");
                span.className = "auction";
                var current = res[i].split('|');
                span.innerHTML = current[0] + ' ' + current[1] + 'р ' + current[2] + ' ' + "<br>";
                document.getElementById("bets").appendChild(span);
            }
        }

    };
    var body =  'Type=ShowBets' +
        '&walkId=' + walkId;
    xmlhttp.open("POST",'php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
}
var timerId;
function ShowBets(walkId) {
    var bets = document.createElement("div");
    bets.id = "bets";
    bets.classList.add();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            var res = this.responseText.split('_');
            for (var i = 0; i < res.length; i++) {
                var span = document.createElement("span");
                span.classList.add("auction");
                var current = res[i].split('|');
                span.innerHTML = current[0] + ' ' + current[1] + 'р ' + current[2] + ' ' + "<br>";
                bets.appendChild(span);
            }
        }

    };
    var body =  'Type=ShowBets' +
        '&walkId=' + walkId;
    xmlhttp.open("POST",'php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
    setTimeout(()=>{
        timerId = setInterval(() => {Refresh(walkId);},3000);
    //var timerId = setInterval('alert("sdg")',3000);
},500);

    //alert(sender.name);

    document.getElementById("info").appendChild(bets);

    var form  = document.createElement("form");
    form.id = "form";
    form.method = "POST";
    //form.action = "php/submit.php";

    var price = document.createElement("input");
    price.classList.add("inp");
    price.type = "text";
    price.name = "price";
    price.id = "price";
    price.placeholder = "price";

    var hiddenWalkId = document.createElement("input");
    hiddenWalkId.type = "hidden";
    hiddenWalkId.name = "walkId";
    hiddenWalkId.id = "walkId";
    hiddenWalkId.value = walkId;
    var walkerId;

    var xmlhttp1 = new XMLHttpRequest();
    xmlhttp1.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            walkerId = this.responseText;
        }

    };
    var body =  'Type=GetID';
    xmlhttp1.open("POST",'php/submit.php' , true);
    xmlhttp1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp1.send(body);
    setTimeout(()=>{
        var hiddenWalkerId = document.createElement("input");
    hiddenWalkerId.type = "hidden";
    hiddenWalkerId.value = walkerId;
    hiddenWalkerId.id = "walkerId";
    hiddenWalkerId.name = "walkerId";

    var Submit = document.createElement("input");
    Submit.type = "button";
    Submit.name = "submit";
    Submit.value = "Сделать ставку";
    Submit.addEventListener("click", PlaceBet);

    document.getElementById("bets").appendChild(form);
    document.getElementById("form").appendChild(price);
    document.getElementById("form").appendChild(hiddenWalkId);
    document.getElementById("form").appendChild(hiddenWalkerId);
    document.getElementById("form").appendChild(Submit);
},400);
}


function AddMark(place) {
    myGeoObject = new ymaps.GeoObject({
        // Описание геометрии.
        geometry: {
            type: "Point",
            coordinates: place
        },
        // Свойства.
        properties: {
            // Контент метки.
            iconContent: "я здесь",
            balloonContent: "<input type='button' value = 'Добавить' name='"+place+"' onclick=AddDog(this)>"
        }
    }, {
        // Опции.
        // Иконка метки будет растягиваться под размер ее содержимого.
        preset: 'islands#blackStretchyIcon',
        draggable: true
        // Метку можно перемещать.
    })
    myGeoObject.events.add("dragend", function(e) {
        e.originalEvent.target.properties._data.balloonContent = "<input type='button' value = 'Добавить' name='"+e.originalEvent.target.geometry._coordinates+"' onclick=AddDog(this)>";

    });
    return myGeoObject;
}
function AddDog(mark) {

    //alert(mark.name);

    var div = document.createElement("div");
    div.id = "dog";
    div.classList.add("top", "dog");
    div.innerHTML = "<h1>Занесение информации о собаке</h1>";
    div.innerHTML += "<h3>" + mark.name+ "</h3>";
    var closeBTN = document.createElement("img");
    closeBTN.src = "close.png";
    closeBTN.classList.add("closeBTN");
    closeBTN.onclick = () => {
        document.getElementById("dog").remove();
    }
    div.appendChild(closeBTN);
    //alert(sender.name);
    document.body.appendChild(div);
}
function ShowDogs() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            if(this.responseText == "") {

            }
            else {
                var dogsCoords = this.responseText.split('_');
                for (var i = 0; i < dogsCoords.length-1; i++) {
                    var dog = dogsCoords[i].split('|');
                    var shortDate = new Date(dog[2]);
                    var months = ["янв", "фев", "март", "апр", "май", "июнь", "июль", "авг", "сен", "окт", "ноя", "дек"];
                    geoCollection.add(new ymaps.Placemark(dog[0].split(','), {
                        iconContent: shortDate.getDate() + ' ' + months[shortDate.getMonth()] + " " + dog[4] + "руб.",
                        balloonContent: "Продолжительность выгула " + dog[3]+ "<br>" + dog[5] + "<br><input type='button' value = 'Хочу выгуливать' name='" + dog[6] + "' onclick='Book(this); ShowBets(this.name)'>"
                    }));
                }
            }
        }

    };
    var body =  'Type=ShowWalks';
    xmlhttp.open("POST",'php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
}
function PlaceBet() {
    if (document.getElementById("price").value != "") {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.DONE == this.readyState) {
                if (this.responseText != "") {
                    alert(this.responseText);
                }
            }

        };
        var body =  'Type=PlaceBet' +
            '&walkId=' + document.getElementById("walkId").value +
            '&walkerId=' + document.getElementById("walkerId").value +
            '&price=' + document.getElementById("price").value;
        xmlhttp.open("POST",'php/submit.php' , true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send(body);
    }
}
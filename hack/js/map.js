var myMap;

// Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);
function init () {
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map").
    myMap = new ymaps.Map('map', {
        // При инициализации карты обязательно нужно указать
        // её центр и коэффициент масштабирования.
        //center: [57.14, 65.56], // Тюмень
        center: [59.99,30.29], // Питер 
        zoom: 11,
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
        myMap.setCenter(result.geoObjects.position, 13  );
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
    Ids = [0,1];
    Coords = [[57.15034181391009,65.57326084136761], [57.15534181391009,65.57326084136761]];
    Titles = ["Пес1", "Пес2"];
    ShortDescription = ["Шибаину", "Мопс"];
    FullDescription = [ "ФОТО, Шиба, средний размер, гулять 50 минут, телефон владельца +79999999999",
                        "Мопс, маленький, гулять 30 минут, телефон +79999999999"];
    for (var i = 0, l = Coords.length; i < l; i++) {
        geoCollection.add(new ymaps.Placemark(Coords[i], {
            iconContent: Titles[i],
            balloonContent: ShortDescription[i] + "<input type='button' value = 'Хочу выгуливать' name='" + Ids[i].toString() + "' onclick=Book(this)>"
        }));
        // var d = geoCollection.get(i);
        // d.ballon.iconContent = i.toString();
    }
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
    div.innerHTML = "<h1>" + sender.name + "</h1>";

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.DONE == this.readyState) {
            var res = this.responseText.split('_');
            for (var i = 0; i < res.length; i++) {
                var span = document.createElement("span");
                span.classList.add("top");
                span.innerHTML = res[i] + "<br>";
                div.appendChild(span);                    
            }
        }
    
    };
    var body =  'Type=WalkInfo' + 
                '&walkId=' + sender.name;
    xmlhttp.open("POST",'/hack/php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);


    var closeBTN = document.createElement("img");
    closeBTN.src = "img/close.png";
    closeBTN.classList.add("closeBTN");
    closeBTN.onclick = () => {
        document.getElementById("info").remove();
    }
    div.appendChild(closeBTN);
    //alert(sender.name);
    document.body.appendChild(div);
}
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
                span.classList.add("top");
                span.innerHTML = res[i] + "<br>";
                bets.appendChild(span);                    
            }
        }
    
    };
    var body =  'Type=ShowBets' + 
                '&walkId=' + walkId;
    xmlhttp.open("POST",'/hack/php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
    //alert(sender.name);
    document.body.appendChild(div);
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
                    geoCollection.add(new ymaps.Placemark(dog[0].split(','), {
                        iconContent: /*"<img src='"+dog[1]+"'</img>"*/shortDate.getDate() + '.' + (shortDate.getMonth()+1) + " " + dog[4],
                        balloonContent: "Продолжительность выгула " + dog[3]+ "<br>" + dog[5] + "<br><input type='button' value = 'Хочу выгуливать' name='" + dog[6] + "' onclick=Book(this)>"
                    }));
                }
            }
        }
    
    };
    var body =  'Type=ShowWalks';
    xmlhttp.open("POST",'/hack/php/submit.php' , true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.send(body);
}
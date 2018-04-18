<?
class Auth 
{
    public function Register($_email, $_password) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT `Email` FROM `Users` WHERE `Email` = '".$_email."'");
        if (($row = $rows->fetch()) == true) {//значит уже есть юзер 
            echo "Пользователь с таким логином уже есть";
        }
        else {
            $connection->exec("INSERT INTO Users (`Email`, `Password`, `hash`) VALUES ('".$_email."', '".md5($_password)."', '".md5($_email.$_password)."')");
        }
    }
    public function Login($_email, $_password) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT `Password`, `Email` FROM `Users` WHERE `Email` = '".$_email."'");  
        // var_dump($rows);  
        if (($row = $rows->fetch()) == true) {
            $name = $row['Email'];
            $password = $row['Password'];
            if ($password == md5($_password)) {
                echo $name;
            }
        }
    }
}

class User
{
    public function CheckRight($_hash) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT `Rights` FROM `Users` WHERE `hash` = '".$_hash."'");  
        if (($row = $rows->fetch()) == true) {
            echo $row['Rights'];
        }
    }
    public function GetAdress($_dogId) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT Users.OpenAdress, Users.ClosedAdress FROM Dogs INNER JOIN Users ON Dogs.OwnerId = Users.id WHERE Dogs.Id = $_dogId");  
        if (($row = $rows->fetch()) == true) {
            echo $row[0].' '.$row[1];
            //var_dump($_dogId);
        }
    }
    public function GetId() {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT Id FROM Users WHERE `hash` = '".$_COOKIE['username']."'");  
        if (($row = $rows->fetch()) == true) {
            echo $row[0];
            //var_dump($_dogId);
        }
        //var_dump("SELECT Id FROM Users WHERE `hash` = '".$_COOKIE['username']."'");        
    }
}

class Walk
{
    public function AddWalk($dogId, $date, $adress, $duration, $price)
    {
        $adress = urlencode($adress);
        //var_dump("https://geocode-maps.yandex.ru/1.x/?geocode=$adress");
        $response = file_get_contents("https://geocode-maps.yandex.ru/1.x/?geocode=$adress");
        $coords = new SimpleXMLElement($response);
        $coords = $coords->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
        //var_dump($coords);/*
        $coords = explode(' ', $coords);
        $coords = implode(',', array($coords[1], $coords[0]));
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $connection->exec("INSERT INTO Walks (`DogID`,`Date`,`Coords`,`Duration`,`Price`) VALUES ($dogId, '$date', '$coords' , '$duration' , '$price')");
        header("Location: profile.php");
    }

    public function ShowWalks() {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT Walks.Id,`DogID`,`Name`,`Date`,`Coords`,`Duration`,`Price` FROM `Walks` INNER JOIN Dogs on Dogs.Id = DogID");
        while (($row = $rows->fetch()) == true) {//значит уже есть юзер 
            $res = $row["Coords"].'|';
            $res.= $row['DogID'].'|';
            $res.= $row['Date'].'|';
            $res.= $row['Duration'].'|';
            $res.= $row['Price'].'|';
            $res.= $row['Name'].'|';
            $res.= $row['Id'].'_';
            /*res = implode('|', $row); //переписать как человек + файл map
            $res .= '_';*/

            echo $res;
        }
    }
    public function WalkInfo($walkId) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT Walks.Id,`DogID`, Dogs.OwnerId, Dogs.Name, Dogs.Breed, Dogs.Size, Dogs.Sex, Dogs.Age, Dogs.Comments, Users.Name, Users.Phone,`Date`,`Duration`,`Price` FROM Walks INNER Join Dogs ON Dogs.Id = Walks.DogID INNER JOIN Users ON Dogs.OwnerId = Users.id WHERE Walks.Id = $walkId");
        if (($row = $rows->fetch(PDO::FETCH_NUM)) == true) {//значит уже есть юзер 
            $res = implode('_', $row); //переписать как человек + файл map
            
            echo $res;
        }
    }
}

class Bet
{
    public function ShowBets($walkId) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT Users.Name, Bets.Price, Bets.time FROM Bets INNER JOIN Users ON Bets.WalkerID = Users.id INNER JOIN Walks ON Walks.Id = Bets.WalkID WHERE Walks.Id = $walkId ORDER BY Bets.time DESC LIMIT 3");
        $result;
        while (($row = $rows->fetch(PDO::FETCH_NUM)) == true) {//значит уже есть юзер 
            $res = implode('|', $row); //переписать как человек + файл map

            $result[] = $res;
        }
        if (isset($result))
            echo implode('_', $result);
        else {
            echo "Ставок нет";
        }
    }

    public function PlaceBet($walkId, $walkerId, $price) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $connection->exec("INSERT INTO Bets (WalkID, WalkerID, `time`, Price) VALUES ('$walkId', '$walkerId', NOW(), '$price')");
        //echo "INSERT INTO Bets (WalkID, WalkerID, `time`, Price) VALUES ('$walkId', '$walkerId', NOW(), '$price')";
        //header("Location: ../map.html");        
    }
}



if (isset($_POST["Type"])) 
    switch($_POST["Type"]) {
        case "register": {
            Auth::Register($_POST['Email'], $_POST['Password']);
            break;
        }
        case "login": { //старый юзер
            Auth::Login($_POST['Email'], $_POST['Password']);
            break;
        }
        case "checkRights": { //проверить права юзера
            User::CheckRight($_COOKIE["username"]);
            break;
        }
        case "ShowWalks": { //проверить права юзера
            Walk::ShowWalks();
            break;
        }
        case "WalkInfo": { //проверить права юзера
            Walk::WalkInfo($_POST["walkId"]);
            break;
        }
        case "Отправить":  {
            Walk::AddWalk($_POST["dogId"], $_POST["date"], $_POST["adress"], $_POST["duration"], $_POST["price"]);
            break;
        }
        case "GetAdress": {
            User::GetAdress($_POST["dogId"]);
            break;
        }
        case "GetID": { 
            User::GetId();
            break;
        }
        case "ShowBets": { 
            Bet::ShowBets($_POST["walkId"]);
            break;
        }
        case "PlaceBet":  { 
            Bet::PlaceBet($_POST['walkId'], $_POST['walkerId'], $_POST['price']);
            break;
        }
    }
else {
    // if (isset($_POST["price"])) {
    //     Bet::PlaceBet($_POST['walkId'], $_POST['walkerId'], $_POST['price']);
    // }
}
?>
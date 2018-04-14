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
}

class Walk
{
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



if (isset($_POST["Type"])) {
    if ($_POST["Type"] == "register") { //новый  юзер
        Auth::Register($_POST['Email'], $_POST['Password']);
    } 
    if ($_POST["Type"] == "login") { //старый юзер
        Auth::Login($_POST['Email'], $_POST['Password']);
    }
    if ($_POST["Type"] == "checkRights") { //проверить права юзера
        User::CheckRight($_COOKIE["username"]);
    }
    if ($_POST["Type"] == "ShowWalks") { //проверить права юзера
        Walk::ShowWalks();
    }
    if ($_POST["Type"] == "WalkInfo") { //проверить права юзера
        Walk::WalkInfo($_POST["walkId"]);
    }
}
?>
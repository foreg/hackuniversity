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
        $rows = $connection->query("SELECT `Password`, `Name` FROM `Users` WHERE `Email` = '".$_email."'");  
        // var_dump($rows);  
        if (($row = $rows->fetch()) == true) {
            $name = $row['Name'];
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
}
?>
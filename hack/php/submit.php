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
            $connection->exec("INSERT INTO Users (`Email`, `Password`) VALUES ('".$_email."', '".md5($_password)."')");
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
    public function IsAuth($_name) {
        if (isset($_COOKIE[$_name])) {
            return true;
        }
        return false;
    }
}
if (Auth::IsAuth("username")) {
    echo $_POST['Email'];
}
else {
    if (isset($_POST["Type"])) {
        if ($_POST["Type"] == "register") {
            if (isset($_POST["Email"])) { //новый  юзер
                Auth::Register($_POST['Email'], $_POST['Password']);
            } 
            else { //старый юзер
                Auth::Login($_POST['Email'], $_POST['Password']);
            }
        }
    }
}

?>
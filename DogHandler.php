<?
class Dog 
{
    public static function Show($user) {
        
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT `id` FROM `Users` WHERE `hash` = '".$user."'");
        $userId;
        if (($row = $rows->fetch()) == true) {//значит уже есть юзер 
            $userId = $row[0];
        }
        else {
            header("Location: login.php");
            die("ошибка");
        }
        $rows = $connection->query("SELECT `Name`, `Id` FROM `Dogs` WHERE `OwnerId` = '$userId'");
        while (($row = $rows->fetch()) == true) {//значит уже есть юзер 
            echo "<div class='myDog'>";
            echo "<span>".$row['Name']."</span>";
            echo "<input type='button' id = ".$row['Id']." value = '&#128021;' onclick = 'Walk(this)'></input>";
            
            echo "</div>";
        }
    }
    public function New($user, $name, $breed, $size, $sex, $age, $comments) {
        $connection = new PDO('mysql:host=localhost;dbname=hack;charset=utf8', 'root');
        $rows = $connection->query("SELECT `id` FROM `Users` WHERE `hash` = '".$user."'");
        $userId;
        if (($row = $rows->fetch()) == true) {//значит уже есть юзер 
            $userId = $row[0];
        }
        else {
            header("Location: login.php");
            die("ошибка");
        }
        $connection->exec("INSERT INTO `Dogs` (`Id`, `OwnerId`, `Name`, `Breed`, `Size`, `Sex`, `Age`, `Comments`) VALUES (NULL,'$userId', '$name', '$breed', '$size', '$sex', '$age', '$comments')");
    }
}
//var_dump($_COOKIE["username"]);
if (isset($_POST["Type"])) {
switch ($_POST["Type"]) {
    case 'AddNewDog':
        {
            Dog::New($_COOKIE["username"], $_POST["name"], $_POST["breed"], $_POST["size"], $_POST["sex"], $_POST["age"], $_POST["comments"]);
            header("Location: profile.php");
        }
        break;
}
}
?>
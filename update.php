<?php
session_start();
require_once("config.php");
$user = $_SESSION["user"];

if(isset($_SESSION["quantity"])) {
    $quantity = $_SESSION["quantity"];
    $arrayId = $_SESSION["arrId"];
    
    $pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass)
        or die("Connect ERROR!");
    $pdo->exec("set names utf8");
    $sql = "UPDATE orderlist SET quantity=:quantity WHERE id=:id";
    $result = $pdo->prepare($sql);
    $num = count($arrayId);
    for($i = 0; $i < $num; $i++) {
        $result->bindValue(":id", $arrayId[$i], PDO::PARAM_STR);
        $result->bindValue(":quantity", $quantity[$i], PDO::PARAM_INT);
        $result->execute();
    }
    $pdo = null;
    header("Location:shoppingCar_Person.php");
    exit();
}
?>
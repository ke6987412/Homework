<?php
session_start();
require_once("config.php");
$user = $_SESSION["user"];

if(!isset($_SESSION["user"])) {
    header("Location:shoppingCar_Login.php");
    exit();
} else {
    $userName = $_SESSION["user"];
}

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass)
        or die("Connect ERROR!");
    $pdo->exec("set names utf8");
    $sql = "SELECT * FROM product WHERE id = $id";
    $rows = $pdo->query($sql);
    $result = $rows->fetch();
    
    $sql = "INSERT INTO orderlist(user, name, money) 
                VALUES('$user', '$result[name]', '$result[money]')";
    if(!$pdo->exec($sql)) {
        echo "ERROR!";
    } else{
        $pdo = null;
        header("Location:shoppingCar_index.php");
        exit();
    }
}
?>
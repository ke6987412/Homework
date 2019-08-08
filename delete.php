<?php
session_start();
require_once("config.php");
$user = $_SESSION["user"];

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    $pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass)
        or die("Connect ERROR!");
    $pdo->exec("set names utf8");
    $sql = "DELETE FROM orderlist WHERE id = $id";
    $pdo->exec($sql);
    $pdo = null;
    header("Location:shoppingCar_Person.php");
    exit();
}
?>
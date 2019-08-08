<?php
session_start();
require_once("config.php");
$userName = "Guest";
$quanity = 0;
$arrayProduct;

if(isset($_SESSION["user"])){
    $userName = $_SESSION["user"];
}
if(isset($_POST["buy"])) {
    echo $_POST["quanity"];
    
    //header("Location:shoppingCar_Person.php");
    //exit();
}
if(isset($_POST["checkout"])) {
    header("Location:shoppingCar_Person.php");
    exit();
}

$pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass)
        or die("Connect ERROR!");
$pdo->exec("set names utf8");
$sql = "SELECT * FROM product";
$rows = $pdo->query($sql);
$result = $rows->fetchAll();
$num = count($result);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>歡迎<?= $userName ?>來到本購物網站!</h1>
    <div style="text-align:right;">
            <a href="shoppingCar_Person.php">購物車</a> | 
    <?php if(!isset($_SESSION["sign"])) { ?>   
            <a href="shoppingCar_Login.php">會員登入</a>
    <?php } else{ ?>
            <a href="shoppingCar_Login.php?signout=1">會員登出</a>
    <?php } ?>
    </div><hr>
    <h2>商品列表:</h2><br>
    <table border="1">
        <thead>
            <tr>
                <th>商品名稱</th>
                <th>售價</th>
                <th>選項</th>
            </tr>
        </thead>
        <tbody>
    <?php    if($num > 0) {
                foreach($result as $row) {   ?> 
                    <tr>
                <?php   $id = $row["id"]; ?>                
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["money"] ?></td>
                        <td><a href="insert.php?id=<?= $id ?>">加入購物車</a>|
                            <a href="shoppingCar_Person.php".php?id=<?= $id ?>">結帳</a></td>                   
                    </tr>
    <?php       }
            } $pdo = null; ?>           
        </tbody>
    </table>        
    
</body>
</html>
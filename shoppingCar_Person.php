<?php
session_start();
require_once("config.php");
$userName = "";
$total = 0;

if(!isset($_SESSION["user"])) {
    header("Location:shoppingCar_Login.php");
    exit();
} else {
    $userName = $_SESSION["user"];
}


$pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass)
        or die("Connect ERROR!");
$pdo->exec("set names utf8");
$sql = "SELECT * FROM orderlist";
$result = $pdo->query($sql);
$rows = $result->fetchAll();
$num = count($rows);

if(isset($_POST["add"])) {
    $quantity = $_POST["quantity"];
    $_SESSION["quantity"] = $quantity;
    $arrayId = $_SESSION["arrId"];
    header("Location:update.php");
    exit();
}

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
    <h1><?= $userName ?>的購物車</h1>
    <div style="text-align:right;">
            <a href="shoppingCar_index.php">首頁</a> | 
    <?php if(!isset($_SESSION["sign"])) { ?>   
            <a href="shoppingCar_Login.php">會員登入</a>
    <?php } else{ ?>
            <a href="shoppingCar_Login.php?signout=1">會員登出</a>
    <?php } ?>
    </div><hr>
    <form action="" method="post">
    <table border="1">
        <thead>
            <tr>
                <th>商品名稱</th>
                <th>售價</th>
                <th>目前數量</th>
                <th>欲更改數量</th>
                <th>選項</th>
            </tr>
        </thead>
        <tbody>
    <?php    if($num > 0) {
                for($i = 0; $i < $num; $i++) {   
                    $row = $rows[$i];   ?> 
                    <tr>
                <?php   $id = $row["id"]; 
                        $_SESSION["arrId"][$i] = $id;
                        $total += $row["money"]*$row["quantity"]  ?>                
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["money"] ?></td>
                        <td><?= $row["quantity"] ?></td>
                        <td><input type="text" name="quantity[]" 
                                value="<?= $row["quantity"] ?>"></td>
                        <td><input type="submit" name="add" value="選擇數量">
                            <a href="delete.php?id=<?= $id ?>">取消商品</a></td>               
                    </tr>
    <?php       }
            } $pdo = null; ?>           
        </tbody>
    </table>        
    </form><hr>
    <h2>總計:<?= $total ?></h2>
</body>
</html>
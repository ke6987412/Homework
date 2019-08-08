<?php
session_start();
require_once("config.php");
$msg = "";
$account = "";
$password = "";

if(isset($_GET["signout"])){
    unset($_SESSION["user"]);
    unset($_SESSION["sign"]);
    header("Location:shoppingCar_index.php");
    exit();
}
if(isset($_POST["returnIndex"])){
    header("Location:shoppingCar_index.php");
    exit();
}

if(isset($_POST["send"])) {
    $account = $_POST["account"];
    $password = $_POST["password"];
    if($account == "") {
        $msg = "Please Input Account !";
    } else if($password == "") {
        $msg = "Please Input Password !";
    } else{
        $pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPass)
            or die("Connect ERROR!");
        $pdo->exec("set names utf8");
        $sql = "SELECT * FROM member WHERE user = :user AND password = :pass";
        $result = $pdo->prepare($sql);
        $result->bindValue(":user", $account, PDO::PARAM_STR);
        $result->bindValue(":pass", $password, PDO::PARAM_STR);
        $result->execute();
        $num = count($result->fetchAll());
        if($num > 0){
            $_SESSION["user"] = $account;
            $_SESSION["sign"] = 1;
            header("Location:shoppingCar_index.php?sign=1");
            exit();
        }else {
            $msg = "沒有此會員!";
        }
        $pdo = null;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登入頁面</title>
</head>
<body>
    <h1>會員登入</h1><br/>
    <form method = "post" action "">
        <label for = "account">帳號:</label>
        <input type = "text" name = "account" 
            id = "account" value = "<?php echo $account ?>"/><br/><br/>
        <label for = "password">密碼:</label>
        <input type = "text" name = "password" 
            id = "password" value = "<?php echo $password ?>"/><br/><br/>
        <input type = "submit" name = "send" 
                            value = "登入"/>
        <input type = "reset" name = "reset" 
                            value = "重設"/>
        <input type = "submit" name = "returnIndex" 
                            value = "回購物頁面"/>
    </form><hr>
    <?php echo $msg ?>
</body>
</html>
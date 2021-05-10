<?php

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_SESSION["userInfo"])){
    if(time() - $_SESSION["userInfo"]["expireTime"] > 1){
        session_unset();
        session_destroy();
        echo "<script>window.location.href='http://localhost:8080/backend-web/picShop';</script>";
    }
}


if(!isset($_SESSION['cart'])){
    $_SESSION['cart']=[];
}
if(!isset($_SESSION['userPics'])){
    $_SESSION['userPics']=[];
}

if(isset($_GET["logout"])){
        session_unset();
        session_destroy();
        echo "<script>window.location.href='http://localhost:8080/backend-web/picShop';</script>";
}

?>

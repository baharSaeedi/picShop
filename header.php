<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>picShop</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/loginStyle.css">
    <link rel="stylesheet" href="css/Style.css">

<?php
    require_once "includes/include.php";
    require_once "includes/session.php";


$cats=Categories::getAllCategories();

if(isset($_SESSION["userInfo"]) && empty($_SESSION["cart"]))
{
    Pictures::cartCounter($_SESSION["userInfo"]["id"]);
}
if(isset($_SESSION["userInfo"]) && empty($_SESSION["userPics"]))
{
    Pictures::getUserImage($_SESSION["userInfo"]["id"]);
}



?>
</head>
<body>

<!-----------------------------------------header------------------------------------------>
<header>
    <nav class="navbar  navbar-expand-xl mainmenu pb-4 d-flex flex-nowrap ">


        <div class="shadow"></div>

        <div class="collapse navbar-collapse pl-5 pl-md-2" id="navbarSupportedContent">
            <div class="col-12 d-flex d-xl-none menuTxt justify-content-between mt-4 mb-1 mb-lg-5">
                <div class="col-1 p-0 mt-2 mb-5">
                    <p>Menu</p>
                </div>
                <div class="col-1 mb-5">
                    <span class="iconify closeCollapse" data-icon="clarity:times-circle-line" data-inline="false" style="color: #c48f56;" data-width="30" data-height="30"></span>
                </div>
            </div>



            <ul class="navbar-nav ml-auto  mt-2 mr-1 pl-1 p-xl-0">
                <li class="nav-item d-none d-xl-inline-block"><a class="nav-link" style="cursor: pointer" ><i class="fa fa-search"></i></a></li>
                <li class="nav-item d-none d-xl-inline-block"><a class="nav-link" href="cart.php" ><i class="fa fa-shopping-cart"><span class="shopCart"><?php echo count($_SESSION["cart"]); ?></span></i></a></li>
                <li class="nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/" id="home">صفحه اصلی</a></li>
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle nav-link " href="#collection" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">دسته بندی محصولات</a>
                    <ul class="dropdown-menu text-right" aria-labelledby="navbarDropdown1">
                        <li class="nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/" id="manager">تمامی محصولات</a></li>
                        <?php

                        $url= $_SERVER['SCRIPT_NAME'];
                        $url.= "?cat=";

                        foreach($cats as  $cat): ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $url.$cat->id; ?>" id="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php
                if (isset($_SESSION["userInfo"])) :
                ?>
                <li class=" nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/userPanel.php" id="panel">ورودبه پنل کاربری </a></li>

                    <li class="nav-item"><a class="nav-link" href="#" id="logOut">خروج</a></li>

                    <script>
                        $("#logOut").click(function (event) {
                            event.preventDefault();
                            swal({
                                title: "می خواهید خارج شوید؟",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                                .then((willDelete) => {
                                    if (willDelete) {
                                        window.location = "http://localhost:8080/backend-web/picShop?logout=out";
                                    }
                                });
                        })
                    </script>

                <?php else: ?>
                <li class=" nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/login.php" id="logIn">ورود/ثبت نام کاربر  </a></li>
                <?php endif; ?>

            </ul>
        </div>

        <div class="containerBox d-flex">
            <a style="cursor: pointer"><i class="fa fa-search d-xl-none d-block py-1 mt-4 mr-4" ></i></a>
            <button class="menuBar navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </button>

        </div>


        <div class="brand ml-0 ml-sm-5">
            <a href="#" style="">PicShop</a>
        </div>
    </nav>
</header>





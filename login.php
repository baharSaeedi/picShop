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


    <style>
        header
        {
            position: static;
        }
    </style>

</head>

<?php
include_once "includes/include.php";
include_once "includes/session.php";



$queryPass = null ;
$queryLogIn=null;
$queryExist = null ;
$msgErr = false;
$msgSuccess = false;
$errors=0;

if(isset($_POST["submit"]) ) {


    if ( !empty($_POST["email"])  and !empty($_POST["password"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) and strlen($_POST["password"]) > 5   ) {


        $captchaKey="6LfkV6EaAAAAANWR2_6UXsK7mVRoHcTzSEkSKGsv";
        $responseKey=$_POST["g-recaptcha-response"];
        $ip=$_SERVER["REMOTE_ADDR"];
        $url="https://www.google.com/recaptcha/api/siteverify?secret=$captchaKey&response=$responseKey&Ip=$ip";

        $response=file_get_contents($url);
        $response=json_decode($response);


        $queryExist = Users::isUserExist(trim($_POST["email"]));
        if ($queryExist)
        {

            $queryPass=Users::checkPassword(trim($_POST["email"]),trim($_POST["password"]));

            if ($queryPass==1)
            {


                if (!$response->success)
                {

                    if (Users::isUserAvailable($_POST["email"])==1)
                    {
                        if (isset($_POST["rememberMe"])) {
                            $queryLogIn = Users::LoginUser(trim($_POST["email"]), trim($_POST["password"]), trim($_POST["rememberMe"]));
                        } else {
                            $queryLogIn = Users::LoginUser(trim($_POST["email"]), trim($_POST["password"]));
                        }
                    }
                    else
                    {
                        $msgErr = true;
                        $msg = "لطفا ابتدا اکانت خود را فعال کنید.";
                    }


                    if ($queryLogIn) {
                        $msgSuccess = true;
                        $msg = "خوش آمدید!";

                    }

                }
                else
                {
                    $msgErr = true;
                    $msg = "لطفا ربات نبودن خود را تایید کنید :)";

                }
            }
            else
            {
                $msgErr = true;
                $msg = "رمز عبور یا ایمیل وارد شده صحیح نیست";
            }

        }
        else
        {

            $msgErr = true;
            $msg = "رمز عبور یا ایمیل وارد شده صحیح نیست";

        }
    }

    else
    {
        $msgErr = true;
        $msg = "اطلاعات وارد شده صحیح نیست";
        if(empty($_POST["password"])){
            $errors++;
        }
        if(strlen($_POST["password"]) <= 5){
            $errors++;
        }

        if(empty($_POST["email"])){
            $errors++;
        }
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $errors++;
        }
    }


}


?>

<!-----------------------------------------header------------------------------------------>
<body>
<!--<header>-->
<!--    <nav class="navbar  navbar-expand-xl mainmenu pb-4 d-flex flex-nowrap ">-->
<!---->
<!---->
<!--        <div class="shadow"></div>-->
<!---->
<!--        <div class="collapse navbar-collapse pl-5 pl-md-2" id="navbarSupportedContent">-->
<!--            <div class="col-12 d-flex d-xl-none menuTxt justify-content-between mt-4 mb-1 mb-lg-5">-->
<!--                <div class="col-1 p-0 mt-2 mb-5">-->
<!--                    <p>Menu</p>-->
<!--                </div>-->
<!--                <div class="col-1 mb-5">-->
<!--                    <span class="iconify closeCollapse" data-icon="clarity:times-circle-line" data-inline="false" style="color: #c48f56;" data-width="30" data-height="30"></span>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!---->
<!---->
<!--            <ul class="navbar-nav ml-auto  mt-2 mr-1 pl-1 p-xl-0">-->
<!--                <li class="nav-item d-none d-xl-inline-block"><a class="nav-link" style="cursor: pointer" ><i class="fa fa-search"></i></a></li>-->
<!--                <li class="nav-item d-none d-xl-inline-block"><a class="nav-link" href="#" ><i class="fa fa-shopping-cart"><span class="shopCart">0</span></i></a></li>-->
<!--                <li class="nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/" id="home">صفحه اصلی</a></li>-->
<!--                <li class="dropdown nav-item">-->
<!--                    <a class="dropdown-toggle nav-link " href="#collection" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">دسته بندی محصولات</a>-->
<!--                    <ul class="dropdown-menu text-right" aria-labelledby="navbarDropdown1">-->
<!--                        <li class="nav-item"><a class="nav-link" href="#people" id="people">اشخاص </a></li>-->
<!--                        <li class="nav-item"><a class="nav-link" href="#food" id="food">غذا و خوراکی</a></li>-->
<!--                        <li class="nav-item"><a class="nav-link" href="#nature" id="nature">طبیعت</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--                <li class="nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/adminPanel.php" id="manager">پنل مدیریت</a></li>-->
<!--                <li class=" nav-item"><a class="nav-link" href="http://localhost:8080/backend-web/picShop/login.php" id="logIn">ورود کاربر </a></li>-->
<!---->
<!---->
<!--            </ul>-->
<!--        </div>-->
<!---->
<!--        <div class="containerBox d-flex">-->
<!--            <a style="cursor: pointer"><i class="fa fa-search d-xl-none d-block py-1 mt-4 mr-4" ></i></a>-->
<!--            <button class="menuBar navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">-->
<!--                <div class="bar1"></div>-->
<!--                <div class="bar2"></div>-->
<!--                <div class="bar3"></div>-->
<!--            </button>-->
<!---->
<!--        </div>-->
<!---->
<!---->
<!--        <div class="brand ml-0 ml-sm-5">-->
<!--            <a href="#" style="">PicShop</a>-->
<!--        </div>-->
<!--    </nav>-->
<!--</header>-->

<!-------------------------body---------------------------------->
<?php if($errors>0): ?>
    <script>
        swal({
            icon: 'error',
            title: 'خطا',
            text: '!لطفا اطلاعات را به درستی وارد کنید'


        })
    </script>
<?php endif; ?>

<?php  if($msgErr) : ?>
    <script>
        swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:3000}).then(function () {
            window.location=window.location.pathname
        })
    </script>

<?php endif; ?>

<?php  if($msgSuccess) : ?>
        <script>
            swal({
                title:"با موفقیت وارد شدید",
                text:'<?php echo $msg ?>',
                icon:"success" ,
                button:"بستن",
                timer:3000
            }) .then( function () {
                window.location = "http://localhost:8080/backend-web/picShop";
            })
        </script>

    </div>
<?php endif; ?>



<section>
    <div class="container justify-content-around mb-4">
        <div class="row">
            <div class="col-12">
                <h2 class="text-right mb-1">ورود کاربر</h2>
                <div class="loginBox">
                    <form  id="loginUser" method="post" class="text-right"   action="http://localhost:8080/backend-web/picShop/login.php">
                        <div class="form-group">
                            <label for="Email"></label>
                            <input type="email" class="form-control" name="email" id="Email" aria-describedby="emailHelp" placeholder="ایمیل خود را وارد کنید.">
                            <?php if (isset($_COOKIE["userEmail"])): ?>
                                <script>
                                    $("input[name='email']").val('<?php echo $_COOKIE["userEmail"]?>')
                                </script>
                            <?php  endif; ?>
                        </div>




                        <div class="form-group">
                            <label for="password">رمز عبور</label>
                            <input type="password" class="form-control"  name="password" id="password" placeholder="************">
                            <?php if (isset($_COOKIE["userPass"])): ?>
                                <script>
                                    $("input[name='password']").val('<?php echo $_COOKIE["userPass"]?>')
                                </script>
                            <?php  endif; ?>
                        </div>






                        <div class="form-group form-check" style="margin: 30px 0">
                            <input name="rememberMe" type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label mr-3" style="transform: translate(0,-3px)" for="exampleCheck1"><small class="text-muted"> مرا به خاطربسپار</small></label>
                                <?php if (isset($_COOKIE["userPass"])): ?>
                                    <script>
                                        $("input[name='rememberMe']").attr("checked","checked");
                                    </script>
                                <?php endif; ?>
                        </div>

                        <input type="hidden" name="send" value="0">



                        <div class="form-group text-left">
                            <div  class="g-recaptcha" data-sitekey="6LfkV6EaAAAAANWR2_6UXsK7mVRoHcTzSEkSKGsv"></div>
                        </div>


                        <div class="form-group">
                            <input type="submit"  data-add="logInUser" class="btn btn-dark loginBtn btn-block d-block mt-1" name="submit" value="ورود به سایت" >
                        </div>
                        <a href="http://localhost:8080/backend-web/picShop/signUp.php"><small>در صورتی که عضو نیستید می توانید از این لینک ثبت نام کنید.</small></a>

                        <br>

                        <a href="http://localhost:8080/backend-web/picShop/giveEmail.php"><small>بازیابی رمز عبور </small></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<!---------------------------footer------------------------------------->
<section class="footerSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 footer ">
                <div class="row justify-content-around pt-4">
                    <div class="col-lg-3 col-6 text-right">
                        <h5 class="ml-4"><a href="#">ارتباط با ما</a></h5>
                        <a class="d-block" href="#"><i class="fa fa-phone ml-2"></i>+98 9122222222</a>
                        <a class="d-block" href="#"><i class="fa fa-mail-bulk  ml-2"></i>b.saeesi.ha@gmail.com</a>
                        <small>Copyright © 2021 Promo Theme. All Rights Reserved.</small>
                    </div>
                    <div class="col-lg-3 col-6 ">
                        <h5 class="text-right   ml-4"><a href="#">آخرین تصاویر</a></h5>
                        <div class="row">
                            <div class="col-6 p-1"><a href="#"><img class="img-thumbnail" src="images/slide30-1-scaled.jpg" alt=""></a></div>
                            <div class="col-6 p-1"><a href="#"><img class="img-thumbnail" src="images/slide30-1-scaled.jpg" alt=""></a></div>
                            <div class="col-6 p-1"><a href="#"><img class="img-thumbnail" src="images/slide30-1-scaled.jpg" alt=""></a></div>
                            <div class="col-6 p-1"><a href="#"><img class="img-thumbnail" src="images/slide30-1-scaled.jpg" alt=""></a></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <h4 class="text-left   ml-4"><a href="#">PicShop</a></h4>
                        <p class="text-right">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>








<div class="modal fade" id="MyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding: 0 0 0 0">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 vh-100">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <div class="col-6 text-right">
                        <h2 class="picName h1"></h2>
                        <h4 class="typePic"></h4>
                        <h2 class="pricePic h1"></h2>
                        <button class="addPic btn btn-lg btn-danger">افزودن به سبد خرید</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="javaScript/js.js"></script>
<script src="javaScript/formJs.js"></script>


</body>
</html>


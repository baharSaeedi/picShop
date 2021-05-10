<?php
require_once "header.php";
require_once "includes/include.php";
?>
<style>
    header
    {
        position: static;
    }
</style>

<!--------------------------body----------------------------------------->

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>




    <?php


    $queryInsert = null ;
    $queryExist = null ;
    $msgErr = false;
    $msgSuccess = false;
    $errors=0;
    $isActivationExist = null;

//    if(isset($_GET["activationKey"]) and !empty($_GET["activationKey"])){
//        $isActivationExist = Users::isSameActivationKey($_GET["activationKey"]);
//        if($isActivationExist){
//            Users::activateUser($_GET["activationKey"]);
//            $msgSuccess = true;
//            $msg = "اکانت شما با موفقیت فعال گردید";
//        }
//        else{
//            echo "OH OH OH!";
//        }
//    }





    if(isset($_POST["submit"])) {


        if (!empty($_POST["firstName"]) and !empty($_POST["lastName"]) and !empty($_POST["userName"]) and !empty($_POST["repassword"]) and !empty($_POST["email"]) and !empty($_POST["mobile"]) and !empty($_POST["pass"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) and strlen($_POST["pass"]) > 5  and strlen($_POST["mobile"]) == 11 and substr($_POST["mobile"], 0, 2) == "09" and is_numeric($_POST["mobile"])) {

                if ($_POST["pass"]==$_POST["repassword"]){
                    $queryExist = Users::isUserExist($_POST["email"]);
                    if ($queryExist) {

                        $msgErr = true;
                        $msg = "ایمیل وارد شده تکراری است";


                    } else {

                        $currentTime = microtime(true);
                        $token = md5($_POST["email"] . $currentTime);
                        $activationKey = $token;

                        $queryInsert = Users::InsertUser($_POST["firstName"], $_POST["lastName"], $_POST["userName"], $_POST["email"], $_POST["pass"], $_POST["mobile"] , "user", $activationKey);


                        if ($queryInsert) {

                            $msgSuccess = true;
                            $msg = "لینک فعالسازی برای شما ارسال شد.";


                            $mail_subject = "لینک تایید ایمیل";
                            $mail_body = '
                         <section style="width: 40%;padding: 50px;margin: auto;background-color:#F2F2F2 ;box-shadow: 1px 1.5px 8px #b7b7b7;direction: rtl;font-family: Tahoma;border-radius: 2.5px;">
       <h1 style="color: silver;text-align: center;padding: 0;margin: 0;padding-bottom: 25px;font-weight: 100;">لینک فعالسازی حساب کاربری</h1>
       <hr color="silver" size="0.5" style="width: 70%">   
          <center><a href="http://localhost:8080/backend-web/picShop?activationKey='.$activationKey.'&email='.$_POST["email"].'" style="display: inline-block;padding: 18px 20px;text-decoration: none;border: 1px solid;text-align: center;border-radius: 5px;color: #FFF;background-color: #494f54;font-size: 18px;border-right:2px solid #0b2e13;border-bottom: 5px solid #0b2e13;margin-top: 30px">فعالسازی حساب کاربری</a></center>
   <p style="text-align: center;color: tomato;margin: 25px 0;"><small>درصورت ارسال اشتباه ایمیل آنرا نادیده بگیرید</small></p></section>';
                            Users::sendMail($_POST["email"], $mail_subject, $mail_body);
                        }
                    }
                }
        }



        else{
            if(empty($_POST["firstName"])){
                $errors++;
            }
            if(empty($_POST["lastName"])){
                $errors++;
            }
            if(empty($_POST["userName"])){
                $errors++;
            }
            if(empty($_POST["pass"])){
                $errors++;
            }
            if(empty($_POST["mobile"])){
                $errors++;
            }


            if(strlen($_POST["pass"]) <= 5){
                $errors++;
            }

            if(empty($_POST["email"])){
                $errors++;
            }
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $errors++;
            }

            if(strlen($_POST["mobile"]) != 11 || substr($_POST["mobile"],0,2) != "09" || !is_numeric($_POST["mobile"])){
                $errors++;
            }
        }
    }




    ?>
</head>
<body>




<div class="container">
    <div class="row">
        <div class="col-12 mx-auto">
            <h2 class="text-right mb-1">ثبت نام کاربر</h2>
            <div class="loginBox mb-2">




                <?php if($errors>0): ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا',
                            text: '!لطفا اطلاعات را به درستی وارد کنید'


                        })
                    </script>
                <?php endif; ?>

                <?php  if($msgErr) : ?>
                    <script>
                        swal({title:"خطا دوست من",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:3000})
                    </script>

                <?php endif; ?>

                <?php  if($msgSuccess) : ?>

                        <script>
                            swal({title:"با موفقیت انجام شد",
                                text:'<?php echo $msg ?>',
                                icon:"success" ,
                                button:"بستن",
                                timer:3000}).then(function () {
                                    window.location = "http://localhost:8080/backend-web/picShop/login.php";
                            })
                        </script>
                <?php endif; ?>





                    <form action="#" method="post" id="SignUp">

                        <fieldset>
                            <div class="form-group text-right">
                                <label for="" class="">نام</label>
                                <input type="text" name="firstName" class="form-control text-right" placeholder="نام" data-validation-role="required,number">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">نام خانوادگی</label>
                                <input type="text" name="lastName" class="form-control text-right" placeholder="نام خانوادگی">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">نام کاربری</label>
                                <input type="text" name="userName" class="form-control text-right" placeholder="نام کاربری">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">ایمیل</label>
                                <input type="text" name="email" class="form-control text-right" placeholder="ایمیل">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">رمزعبور</label>
                                <input type="password" name="pass" class="form-control text-right" placeholder="رمزعبور">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">تکرار رمزعبور</label>
                                <input type="password" name="repassword" class="form-control text-right" placeholder="رمزعبور">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">تلفن همراه</label>
                                <input type="text" name="mobile" class="form-control text-right" placeholder="تلفن همراه">
                                <small class="err"></small>
                            </div>

                            <div class="form-group text-left">
                               <div class="g-recaptcha" data-sitekey="6LfkV6EaAAAAANWR2_6UXsK7mVRoHcTzSEkSKGsv"></div>
                            </div>

                            <div class="form-group">
                                <input type="submit"  data-add="addUser" class="btn btn-success btn-block" name="submit" value="ثبت نام" >
                            </div>

                            <input type="hidden" name="send" value="0">


                        </fieldset>


                    </form>
            </div>
        </div>
    </div>
</div>


<?php
require_once "footer.php";


?>


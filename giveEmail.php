<?php
require_once "header.php";
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


$msgErr=null;
$msg=null;
if (isset($_POST["btn"]))
{
    if (isset($_POST["email"]) && !empty($_POST["email"]))
    {
        $currentTime =  microtime(true);
        $token = md5($_POST["email"] . $currentTime);
        $resetKey = $token ;
//        $hashEmail=sha1($_POST["email"]);

        $msgErr=Users::checkEmail($_POST["email"]);




        $mail_subject = "لینک تایید ایمیل";
        $mail_body = '
                         <section style="width: 40%;padding: 50px;margin: auto;background-color:#F2F2F2 ;box-shadow: 1px 1.5px 8px #b7b7b7;direction: rtl;font-family: Tahoma;border-radius: 2.5px;">
       <h1 style="color: silver;text-align: center;padding: 0;margin: 0;padding-bottom: 25px;font-weight: 100;">لینک فعالسازی حساب کاربری</h1>
       <hr color="silver" size="0.5" style="width: 70%">   
          <center><a href="http://localhost:8080/backend-web/picShop/changePass.php?activationKey='.$resetKey.'&email='.$_POST["email"].'" style="display: inline-block;padding: 18px 20px;text-decoration: none;border: 1px solid;text-align: center;border-radius: 5px;color: #FFF;background-color: #494f54;font-size: 18px;border-right:2px solid #0b2e13;border-bottom: 5px solid #0b2e13;margin-top: 30px">فعالسازی حساب کاربری</a></center>
   <p style="text-align: center;color: tomato;margin: 25px 0;"><small>درصورت ارسال اشتباه ایمیل آنرا نادیده بگیرید</small></p></section>';
        Users::sendMail($_POST["email"],$mail_subject,$mail_body);




        if ($msgErr==0)
        {
            $msg="کابری با ایمیل مورد نظر موجود نیست";
        }
        else
        {
            Users::setKeyChangePass($_POST["email"],$resetKey);
            $msg="ایمیل تایید با موفقیت ارسال شد";
        }
    }
    else
    {
        $msg="ایمیل نمی تواند خالی باشد";
    }
}




?>
</head>
<body>




<div class="container">
    <div class="row">
        <div class="col-12 mx-auto">
            <h2 class="text-right mb-1">ایمیل پشتیبان حساب</h2>
            <div class="loginBox mb-2">




                <form action="#" method="post" id="changePass">

                    <fieldset>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="Email"></label>
                                <input type="email" class="form-control" name="email" id="Email" aria-describedby="emailHelp" placeholder="ایمیل خود را وارد کنید.">
                            </div>
                            <div class="form-group mb-0">

                                <input name="btn" type="submit" class="btn btn-dark btn-block" value="دریافت ایمیل تایید "  />

                                <?php  if($msgErr==0 && isset($msg)) : ?>
                                    <script>
                                        swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:3000});
                                    </script>

                                <?php endif; ?>
                                <?php  if($msgErr==1) : ?>
                                    <script>
                                        swal({title:"با موفقیت انجام شد",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:3000})
                                        $(".card-body").html("<div class='alert-success text-center'>ایمیل با موفقیت ارسال شد</div>");
                                    </script>

                                <?php endif; ?>
                            </div>


                    </fieldset>


                </form>
            </div>
        </div>
    </div>
</div>


<?php
require_once "footer.php";


?>


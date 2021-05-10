<?php
ob_start();
require_once "header.php";
//require_once "includes/include.php";
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
if (isset($_POST["btnChange"]))
{

    if (isset($_GET["email"]) && !empty($_GET["activationKey"]) &&  !empty($_GET["email"]) && isset($_GET["activationKey"]))
    {
        if (isset($_POST["newPass"]) && isset($_POST["reNewPass"]))
        {

            $check= Users::checkEmail($_GET["email"]);

            if ($check==1)
            {
                $msgErr=Users::changePass($_POST["newPass"] , $_POST["reNewPass"], $_GET["activationKey"]);


                if ($msgErr==0)
                {
                    $msg="رمز خود را به درستی وارد کنید";
                }
                else
                {
                    $msg="رمز شما تغییر کرد";
                    Users::saveReqChangePass($_GET["email"],Users::getUserId($_GET["email"]),$_POST["newPass"]);
                    Users::nullReset($_GET["email"]);
                    Users::updateCookie($_GET["email"],$_POST["newPass"]);

                }
            }

        }
        else
        {
            $msg="رمز خود را به درستی وارد کنید";
        }
    }
    else
    {
        $msg="مبدا درست نیست.";
    }
}
?>




<div class="container">
    <div class="row">
        <div class="col-12 mx-auto">
            <h2 class="text-right mb-1">تغییر رمز عبور</h2>
            <div class="loginBox mb-2">




                <form action="#" method="post" id="changePass"  class="text-right">

                    <fieldset>


                        <div class="form-group">
                            <label for="newPass">رمز عبور</label>
                            <input  type="password" class="form-control"  name="newPass" id="password1" placeholder="************">
                        </div>

                        <div class="form-group">
                            <label for="reNewPass">رمز عبور</label>
                            <input  type="password" class="form-control"  name="reNewPass" id="password2" placeholder="************">
                        </div>

                        <div class="form-group mb-0">

                            <input name="btnChange" type="submit" class="btn btn-dark btn-block" value="تغییر رمز عبور"  />

                            <?php  if(!$msgErr && isset($msg)) : ?>
                                <script>
                                    swal({title:"خطا",text:'<?php echo $msg ?>',icon:"error" , button:"بستن",timer:3000});
                                </script>

                            <?php endif; ?>
                            <?php  if($msgErr) : ?>
                                <script>
                                    swal({title:"با موفقیت انجام شد",text:'<?php echo $msg ?>',icon:"success" , button:"بستن",timer:3000}).then(function () {
                                        window.location = "http://localhost:8080/backend-web/picShop/login.php";
                                    })
                                </script>

                            <?php endif; ?>
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

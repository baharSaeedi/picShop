<?php

require_once "header.php";
require_once "includes/include.php";
?>
<style>
    header
    {
        position: static;
    }
    .userInfo
    {
        border: 2px solid #c48f56 ;
        border-radius: 5px;
        width: 100vw;
    }
</style>




<!------------------------------------body------------------------------->
<?php
if (isset($_SESSION["userInfo"]))
{
    ?>
<div class="container">
    <div class="row w-100">
        <div class="userInfo text-right p-3">
            <p><strong>نام :  <?php echo $_SESSION["userInfo"]["firstName"] ?></strong></p>
            <hr>
            <p><strong>نام خانوادگی :  <?php echo $_SESSION["userInfo"]["lastName"] ?></strong></p>
            <hr>
            <p><strong>نام کاربری :  <?php echo $_SESSION["userInfo"]["userName"] ?></strong></p>
            <hr>
            <p><strong>ایمیل  :  <?php echo $_SESSION["userInfo"]["userEmail"] ?></strong></p>
            <hr>
            <p><strong>شماره تلفن :  <?php echo $_SESSION["userInfo"]["mobile"] ?></strong></p>
            <hr>
        </div>
    </div>
</div>
<?php
    }
     else
         {
//           ?>
         <script>
             swal({
                 title:"لطفا مجددا لاگین کنید!",
                 icon:"warning" ,
                 button:"بستن",
                 timer:3000
             }) .then( function () {
                 window.location = "http://localhost:8080/backend-web/picShop/login.php";
             })
         </script>
<?php
         }
?>

<div class="container-fluid">
    <div class="row">
        <div class="cartBox">

            <?php if(isset($_SESSION["userInfo"]) && !empty($_SESSION["userPics"])):  ?>
                <?php foreach ($_SESSION["userPics"] as $pic)  : $picInfo=Pictures::getPicById($pic) ?>
                    <?php if(in_array($picInfo->id,$_SESSION["userPics"])): ?>
                        <div class="col-12 d-flex m-3 border-bottom">
                            <div class="col-2 picBox mb-2">
                                <a href="<?php echo $picInfo->path; ?>" download="download"><img src="<?php echo $picInfo->path; ?>" alt=""  class="img-fluid img-thumbnail"></a>
                            </div>
                            <div class="col text-right align-self-end">
                                <h2><?php echo $picInfo->title; ?></h2>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(isset($_SESSION["userInfo"]) && empty($_SESSION["userPics"])):  ?>
                <div class="h3 text-center alert-warning p-5">شما تا به حال خریدی نداشته اید!</div>
            <?php endif; ?>

            <?php if(!isset($_SESSION["userInfo"])):  ?>
                <div class="h3 text-center alert-warning p-5">لطفا وارد حساب کاربری خود شوید.</div>
            <?php endif; ?>
        </div>
    </div>
</div>






















<?php
require_once "footer.php";


?>

<?php
require_once "header.php";
require_once "includes/include.php";

if (isset($_POST["submit"]))
{
    $price=0;
    $pid="";
    foreach ($_SESSION["cart"] as $pic)
    {
        $picInfo=Pictures::getPicById($pic);
//        $price+=$picInfo->price;
//        $pid .= ",".strval($picInfo->id);
        Pictures::addShopping($picInfo->id,$_SESSION["userInfo"]["id"],$picInfo->price);
        Pictures::deletePicFromCart($picInfo->id);
        $key=array_search($picInfo->id,$_SESSION['cart']);
        if($key!==false)
            unset($_SESSION['cart'][$key]);
        ?>
        <script>
            $(".shopCart").text(parseInt($(".shopCart").text())-1);
        </script>
        <?php
        if(!in_array($picInfo->id,$_SESSION['userPics']))
        {
            $_SESSION['userPics'][] = $picInfo->id;
        }

    }
    ?>
    <script>
        swal({title:"انجام شد",text:'سفارش شما با موفقیت ثبت شد',icon:"success" , button:"بستن",timer:3000})
    </script>
    <?php


}

if (isset($_GET["pd"]) && !empty($_GET["pd"]))
{
        Pictures::deletePicFromCart($_GET["pd"]);
        $key=array_search($_GET['pd'],$_SESSION['cart']);
        if($key!==false)
        unset($_SESSION['cart'][$key]);
    ?>
    <script>
        $(".shopCart").text(parseInt($(".shopCart").text())-1);
        swal({title:"انجام شد",text:'محصول از سبد خرید شما حذف شد',icon:"success" , button:"بستن",timer:1000})
    </script>
    <?php
}
?>

<style>
    header
    {
        position: static;
    }
</style>



<!---------------------------------------body section------------------------------------------>
<div class="container-fluid">
    <div class="row">
        <div class="cartBox">

            <?php if(isset($_SESSION["userInfo"]) && !empty($_SESSION["cart"])): $price=0; ?>
                <?php foreach ($_SESSION["cart"] as $pic)  : $picInfo=Pictures::getPicById($pic) ?>
                        <div class="col-12 d-flex m-3 border-bottom">
                            <div class="col-2 picBox mb-2">
                                <img src="<?php echo $picInfo->path; ?>" alt=""  class="img-fluid img-thumbnail">
                            </div>
                            <div class="col text-right align-self-end">
                                <h2><?php echo $picInfo->title; ?></h2>
                                <p data-price="<?php echo $picInfo->price; ?>">تومان <?php $price+=$picInfo->price; echo $picInfo->price; ?></p>
                            </div>
                            <div class="col-1 align-self-center">
                                <a href="http://localhost:8080/backend-web/picShop/cart.php?pd=<?php echo $picInfo->id; ?>" class="btn btn-outline-danger " >حذف عکس</a>
                            </div>
                        </div>
                <?php endforeach; ?>
                    <div class="h3 text-right alert-success mt-5 px-3 py-1">جمع مبلغ پرداختی : <?php echo $price; ?></div>
                <form action="#" method="post">
                    <input type="submit" name="submit" class="btn btn-block btn-outline-dark mt-3" value="پرداخت">
                </form>
            <?php endif; ?>

            <?php if(isset($_SESSION["userInfo"]) && empty($_SESSION["cart"])):  ?>
                <div class="h3 text-center alert-warning p-5">سبد خرید شما خالی است!</div>
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

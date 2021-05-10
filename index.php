<?php
require_once "header.php";
require_once "includes/include.php";
$msgErrInsert=false;
if (isset($_GET["email"]) && !empty($_GET["activationKey"]) &&  !empty($_GET["email"]) && isset($_GET["activationKey"]))
{
    Users::activateUser($_GET["activationKey"],$_GET["email"]);
    Users::nullReset($_GET["email"]);
}

if (isset($_GET["pageIn"]) && !empty(isset($_GET["pageIn"])))
{
    if (isset($_GET["cat"]))
    {
        $pics=Pictures::getCatPictures(MAX_POST,$_GET["pageIn"]*9 , $_GET["cat"]);
        $count=Pictures::CountPicsBYCat($_GET["cat"]);
    }
    else
    {
        $pics=Pictures::getCountPictures(MAX_POST,$_GET["pageIn"]*9);
        $count=Pictures::CountPics();
    }
}
else
{
    if (isset($_GET["cat"]))
    {
        $pics=Pictures::getCatPictures(MAX_POST,0 , $_GET["cat"]);
        $count=Pictures::CountPicsBYCat($_GET["cat"]);
    }
    else
    {
        $pics=Pictures::getCountPictures(MAX_POST,0);
        $count=Pictures::CountPics();
    }

}
if (isset($_SESSION["userInfo"]))
{
    if(isset($_SESSION['cart']) && isset($_GET["pic"]) && !empty(isset($_GET["pic"])))
    {
        if(!in_array($_GET['pic'],$_SESSION['cart']) && !in_array($_GET["pic"],$_SESSION['userPics']))
        {
            ?>
            <script>
                $(".shopCart").text(parseInt($(".shopCart").text())+1);
                swal({title:"انجام شد",text:'محصول به سبد خرید اضافه شد',icon:"success" , button:"بستن",timer:1000})
            </script>
            <?php
            $addPicResult=Pictures::addPicCart($_SESSION["userInfo"]["id"], $_GET["pic"]);
            $_SESSION['cart'][] = $_GET['pic'];
        }

        else
        {
            $msgErrInsert=true;
        }
    }
}
else if (isset($_GET["pic"]) && !isset($_SESSION["userInfo"]))
{
    ?>
    <script>
        swal({title:"خطا",text:'لطفا ابتدا وارد حساب کاربری خود شوید',icon:"warning" , button:"بستن",timer:1000}).then(function () {
            window.location= window.location.pathname;
        })
    </script>
    <?php
}

?>
<!-----------------------------------------slider----------------------------------------->
<section id="sliderSection">
    <div class="container-fluid">
        <div class="row">
            <div class="col-1  rightSide">
                <ol class="carousel-indicators ind1">
                    <li  data-target="#myCarousel" data-slide-to="0" class="active">01</li>
                </ol>
                <ol class="carousel-indicators  ind2">
                    <li  data-target="#myCarousel" data-slide-to="1">02</li>
                </ol>
                <ol class="carousel-indicators ind3">
                    <li  data-target="#myCarousel" data-slide-to="2">03</li>
                </ol>
            </div>
            <div class="col-10  middleSide">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/slide30-1-scaled.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="images/slide27-1-scaled.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="images/slide28-1-scaled.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1 leftSide" >
                <a href="#">اینستاگرام<i class="fab fa-instagram"></i></a>
                <a href="#">توئیتر<i class="fab fa-twitter"></i></a>
                <a href="#">فیسبوک<i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </div>

</section>
<?php  if($msgErrInsert) : ?>
    <script>
        swal({title:"خطا",text:'عکس مورد نظر در سبد خرید شما موجود است',icon:"error" , button:"بستن",timer:1000}).then(function () {
            const params = new URLSearchParams(location.search)
            params.delete('pic')
            if (params.toString()=="")
            {
                window.location= window.location.pathname
            }
            else
            {
                window.location= window.location.pathname+"?"+params.toString()
            }
        })
    </script>
<?php  unset($_GET["id"]); endif; ?>
<!------------------------------body section--------------------------------------->
<section class="shoppingSection">
    <div class="container">
        <div class="row">
            <div class="col-4 col-lg-3 sideBar">
                <div class="row">
                    <div class="col-12">
                        <a href="#"> <h5 class="text-right d-block mb-3">درباره ی ما</h5></a>
                        <img src="images/slide30-1-scaled.jpg" class="img-fluid" alt="">
                        <p class="d-block text-right mt-3">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="text-right d-block mt-3"><h4>پرفروش ترین ها</h4></a>
                        <?php $images=Pictures::maxSelling();
                        if ($images!=0){
                        foreach ($images as $key=>$value): $mypic=Pictures::getPicById($value)?>
                            <div class="col-12 my-5 text-right">
                                <div class="picCard"  data-toggle="modal" data-target="#MyModal">
                                    <img class="img-fluid" src="<?php echo $mypic->thumb_url;?>" alt="">
                                    <div class="showCard">
                                        <a href="#">افزودن به سبد خرید<i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <h4 class="mt-2 d-block picName"><strong><?php echo $mypic->title; ?></strong></h4>
                                <p class="typePic d-block my-0"><span><?php echo $mypic->name; ?></span></p>
                                <p class="pricePic d-block"><?php echo $mypic->price;?></p>
                            </div>
                        <?php endforeach; }?>
                    </div>
                </div>
            </div>
            <div class="col-8 col-lg-9  shopBody mt-5 d-flex flex-wrap ">

                    <div class="row">
                        <div class="container-fluid d-flex flex-wrap">
                        <?php

                        if (isset($_GET["cat"]) && isset($_GET["pageIn"]))
                        {
                            if (isset($_GET["pic"]))
                            {
                                $url= $_SERVER['SCRIPT_NAME'];
                                $url.= '?pageIn='.$_GET["pageIn"].'&cat='.$_GET["cat"];
                                $url.= "&pic=";
                            }
                            else
                            {
                                $url= $_SERVER['REQUEST_URI'];
                                $url.= "&pic=";
                            }
                        }
                        else if(isset($_GET["pageIn"]))
                        {
                            if (isset($_GET["pic"]))
                            {
                                $url= $_SERVER['SCRIPT_NAME'];
                                $url= '?pageIn='.$_GET["pageIn"];
                                $url.= "&pic=";
                            }
                            else
                            {
                                $url= $_SERVER['REQUEST_URI'];
                                $url.= "&pic=";
                            }
                        }
                        else if (isset($_GET["cat"]))
                        {
                            if (isset($_GET["pic"]))
                            {
                                $url= $_SERVER['SCRIPT_NAME'];
                                $url= '?cat='.$_GET["cat"];
                                $url.= "&pic=";
                            }
                            else
                            {
                                $url= $_SERVER['REQUEST_URI'];
                                $url.= "&pic=";
                            }
                        }
                        else
                        {
                            $url= $_SERVER['SCRIPT_NAME'];
                            $url.= "?pic=";
                        }
                        if ($pics != 0){
                        foreach ($pics as $pic) : ?>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="picCard"  data-toggle="modal" data-target="#MyModal">
                                    <img class="img-fluid w-100" src="<?php echo $pic->thumb_url; ?>" alt="">
                                    <div class="showCard">
                                        <a href="#" class="picAdd" data-pic="<?php echo $url.$pic->id; ?>">افزودن به سبد خرید<i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <h4 class="mt-2 d-block picName"><strong><?php echo $pic->title; ?></strong></h4>
                                <p class="typePic d-block my-0"><span><?php echo $pic->name; ?></span></p>
                                <p class="pricePic d-block"><span><?php echo $pic->price; ?> تومان</span></p>

                            </div>
                        <?php  endforeach; }?>
                    </div>
                    </div>




                <div class="row">
                    <div class="col-12 align-content-end text-center d-flex  align-items-end">
                        <?php
                        if (isset($_GET["cat"]))
                        {
                            if (isset($_GET["pageIn"]))
                            {
                                $url= $_SERVER['SCRIPT_NAME'];
                                $url= '?cat='.$_GET["cat"];
                                $url.= "&pageIn=";
                            }
                            else
                            {
                                $url= $_SERVER['REQUEST_URI'];
                                $url.= "&pageIn=";
                            }
                        }
                        else
                        {
                            $url= $_SERVER['SCRIPT_NAME'];
                            $url.= "?pageIn=";
                        }
                        for ($i=0; $i<$count/9 ; $i++): ?>
                            <div class="col  pageIn float-left">
                                <a href=<?php echo $url.$i;?>><?php echo $i+1;?></a>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>






<?php
require_once "footer.php";
?>




<?php require_once "includes/include.php"; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loginStyle.css">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>
<!---------------------add image--------------------------->
<?php if (isset($_GET["addPic"]) && !empty($_GET["addPic"])): ?>

<?php
$msgSuccess=false;
$msgErr=false;
$msg=null;
if (isset($_POST["submit"]))
{
    if ( isset($_POST["title"]) && !empty($_POST["title"]) && isset($_POST["cat"]) && !empty($_POST["cat"]) && isset($_POST["price"]) && !empty($_POST["price"]) && isset($_FILES["userFile"]) && !empty($_FILES["userFile"]))
    {
        $uploadDir=__DIR__ . "/images/";
        $name= strval(rand(11,99)) . "_" . $_FILES["userFile"]["name"];
        $thumbName= "thumb"  . $name;
        $destImagePath="thumbs/".$thumbName;
        $path="images/". $name;
        $locationFile=$uploadDir . $name ;
        $allowedFileType=array("image/jpeg", "image/jpg");

        if (in_array($_FILES["userFile"]["type"],$allowedFileType))
        {
            move_uploaded_file($_FILES["userFile"]["tmp_name"], $locationFile);


            $result=Categories::isCatExist($_POST["cat"]);
            if($result != false)
            {

                $objThumbImage = new ThumbImage($locationFile);
                $objThumbImage->createThumb($destImagePath, 400);
                $addResult=Pictures::InsertPicture($_POST["title"],$result,$_POST["price"],$path,$destImagePath);
                $msgSuccess=true;
            }
            else
            {
                $objThumbImage = new ThumbImage($locationFile);
                $objThumbImage->createThumb($destImagePath, 400);
                Categories::addCat($_POST["cat"]);
                $resultCat=Categories::getCatId($_POST["cat"]);
                $addResult=Pictures::InsertPicture($_POST["title"],$resultCat,$_POST["price"],$path,$destImagePath);
                $msgSuccess=true;

            }
        }
        else
        {
            $msgErr=true;
            $msg="فرمت فایل وارد شده درست نیست";
        }


    }
}
    ?>
<body>
<div class="container mt-5">
    <div class="row mt-5">
        <div class="col mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="post" id="MyForm"  enctype="multipart/form-data">

                        <fieldset>
                            <legend class="text-center">افزودن عکس جدید</legend>
                            <div class="form-group text-right">
                                <label for="" class="">عنوان عکس</label>
                                <input type="text" name="title" class="form-control text-right" placeholder="عنوان عکس" data-validation-role="required,number">
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">دسته بندی</label>
                                <input type="text" name="cat" class="form-control text-right" placeholder="دسته بندی">
                            </div>

                            <div class="form-group text-right">
                                <label for="" class="">قیمت</label>
                                <input type="number" name="price" class="form-control text-right" placeholder=" قیمت به تومان">
                            </div>
                            <div class="form-group text-right">
                                <label for="" class="">فایل</label>
                                <input type="file" name="userFile" class="form-control-file text-right" >
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-block" name="submit" value="افزودن" >
                            </div>
                            <div class="form-group">
                                <a href="http://localhost:8080/backend-web/picShop/panel.php" class="btn btn-outline-danger btn-sm px-2 btn-block"> بازگشت به صفحه اصلی  </a>
                                </li>
                            </div>


                        </fieldset>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>
</html>


<?php endif; ?>


<!-----------------------add user---------------------->
<?php if (isset($_GET["addUser"]) && !empty($_GET["addUser"])): ?>

    <?php
    $msgSuccess=false;
    $msgErr=false;
    if (isset($_POST["submit"]))
    {
        if (!empty($_POST["firstName"]) and !empty($_POST["lastName"]) and !empty($_POST["userName"])  and !empty($_POST["email"]) and !empty($_POST["mobile"]) and !empty($_POST["pass"]) and filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) and strlen($_POST["pass"]) > 5  and strlen($_POST["mobile"]) == 11 and substr($_POST["mobile"], 0, 2) == "09" and is_numeric($_POST["mobile"]))
        {
            $currentTime = microtime(true);
            $token = md5($_POST["email"] . $currentTime);
            $activationKey = $token;

            $queryInsert = Users::InsertUser($_POST["firstName"], $_POST["lastName"], $_POST["userName"], $_POST["email"], $_POST["pass"], $_POST["mobile"] , "user", $activationKey);


            if ($queryInsert) {


                $mail_subject = "لینک تایید ایمیل";
                $mail_body = '
                         <section style="width: 40%;padding: 50px;margin: auto;background-color:#F2F2F2 ;box-shadow: 1px 1.5px 8px #b7b7b7;direction: rtl;font-family: Tahoma;border-radius: 2.5px;">
       <h1 style="color: silver;text-align: center;padding: 0;margin: 0;padding-bottom: 25px;font-weight: 100;">لینک فعالسازی حساب کاربری</h1>
       <hr color="silver" size="0.5" style="width: 70%">   
          <center><a href="http://localhost:8080/backend-web/picShop?activationKey='.$activationKey.'&email='.$_POST["email"].'" style="display: inline-block;padding: 18px 20px;text-decoration: none;border: 1px solid;text-align: center;border-radius: 5px;color: #FFF;background-color: #494f54;font-size: 18px;border-right:2px solid #0b2e13;border-bottom: 5px solid #0b2e13;margin-top: 30px">فعالسازی حساب کاربری</a></center>
   <p style="text-align: center;color: tomato;margin: 25px 0;"><small>درصورت ارسال اشتباه ایمیل آنرا نادیده بگیرید</small></p></section>';
                Users::sendMail($_POST["email"], $mail_subject, $mail_body);
                $msgSuccess=true;
            }
        }
    }
    ?>
    <body>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" id="MyForm"  enctype="multipart/form-data">

                            <fieldset>
                                <legend class="text-center">افزودن کاربر جدید</legend>
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
                                        <label for="" class="">تلفن همراه</label>
                                        <input type="text" name="mobile" class="form-control text-right" placeholder="تلفن همراه">
                                        <small class="err"></small>
                                    </div>


                                    <div class="form-group">
                                        <input type="submit"  data-add="addUser" class="btn btn-success btn-block" name="submit" value="ثبت نام" >
                                    </div>
                                <div class="form-group">
                                    <a href="http://localhost:8080/backend-web/picShop/panel.php" class="btn btn-outline-danger btn-sm px-2 btn-block"> بازگشت به صفحه اصلی  </a>
                                    </li>
                                </div>


                            </fieldset>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    </body>
    </html>


<?php endif; ?>


<!--------------------add category----------------------->
<?php if (isset($_GET["cat"]) && !empty($_GET["cat"])): ?>


    <?php
$msgSuccess=false;
$msgErr=false;
    if (isset($_POST["submit"]))
    {
        if (isset($_POST["name"]) && !empty($_POST["name"]) )
        {
                $result=Categories::addCat($_POST["name"]);
                if ($result)
                {
                    $msgSuccess=true;
                }
                else
                {
                    $msgErr=true;
                    $msg="دسته بندی وارد شده تکراری است";
                }
        }
    }
    ?>






    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post">

                            <fieldset>
                                <legend class="text-center">افزودن عکس جدید</legend>
                                <div class="form-group text-right">
                                    <label for="" class="">نام دسته بندی</label>
                                    <input type="text" name="name" class="form-control text-right" placeholder="نام" data-validation-role="required,number">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-block" name="submit" value="افزودن" >
                                </div>
                                <div class="form-group">
                                    <a href="http://localhost:8080/backend-web/picShop/panel.php" class="btn btn-outline-danger btn-sm px-2 btn-block"> بازگشت به صفحه اصلی  </a>
                                    </li>
                                </div>


                            </fieldset>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php endif; ?>

<!-------------------edit category------------------>
<?php if (isset($_GET["catE"]) && !empty($_GET["catE"])): ?>
<?php
    $msgSuccess=false;
    $msgErr=false;
$cat=Categories::getCatById($_GET["catE"]);
if (isset($_POST["submit"]))
{
    if (isset($_POST["name"]) && !empty($_POST["name"]) )
    {
        $result=Categories::updateCat($_POST["name"],$_GET["catE"]);
        if ($result)
        {
            $msgSuccess=true;
        }
        else
        {
            $msgErr=true;
        }
    }
    echo "<script>const params = new URLSearchParams(location.search); window.location=window.location.pathname+'?'+params.toString(); </script>";
}
?>
<div class="container mt-5">
    <div class="row mt-5">
        <div class="col mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="post">

                        <fieldset>
                            <legend class="text-center">ایجاد تغییر</legend>
                            <div class="form-group text-right">
                                <label for="" class="">نام دسته بندی</label>
                                <input type="text" name="name" class="form-control text-right" placeholder="نام" data-validation-role="required,number" value="<?php echo  $cat->name ; ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-block" name="submit" value="تغییر" >
                            </div>
                            <div class="form-group">
                                <a href="http://localhost:8080/backend-web/picShop/panel.php" class="btn btn-outline-danger btn-sm px-2 btn-block"> بازگشت به صفحه اصلی  </a>
                                </li>
                            </div>


                        </fieldset>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?php endif; ?>


<!--------------------edit  image------------------->
<?php if (isset($_GET["imageE"]) && !empty($_GET["imageE"])): ?>
    <?php
    $msgSuccess=false;
    $msgErr=false;
    $pic=Pictures::getPicById($_GET["imageE"]);

    if (isset($_POST["submit"]))
    {
        if ( isset($_POST["title"]) && !empty($_POST["title"])  && isset($_POST["price"]) && !empty($_POST["price"])   && isset($_POST["cat"]) && !empty($_POST["cat"]))
        {

            $result=Categories::isCatExist($_POST["cat"]);
            if($result != false)
            {

                $addResult=Pictures::editPic($_POST["title"],$result,$_POST["price"],$_GET["imageE"]);
                $msgSuccess=true;
            }
            else
            {
                Categories::addCat($_POST["cat"]);
                $resultCat=Categories::getCatId($_POST["cat"]);
                $addResult=Pictures::editPic($_POST["title"],$resultCat,$_POST["price"],$_GET["imageE"]);
                $msgSuccess=true;
            }
        }
        echo "<script>const params = new URLSearchParams(location.search); window.location=window.location.pathname+'?'+params.toString(); </script>";
    }
    ?>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post">

                            <fieldset>
                                <legend class="text-center">ایجاد تغییر</legend>
                                <div class="form-group text-right">
                                    <label for="" class="">عنوان</label>
                                    <input type="text" name="title" class="form-control text-right" placeholder="عنوان" data-validation-role="required,number" value="<?php echo $pic->title; ?>">
                                </div>
                                <div class="form-group text-right">
                                    <label for="" class="">دسته بندی</label>
                                    <input type="text" name="cat" class="form-control text-right" placeholder="دسته بندی" data-validation-role="required,number" value="<?php echo $pic->name; ?>">
                                </div>
                                <div class="form-group text-right">
                                    <label for="" class="">قیمت</label>
                                    <input type="number" name="price" class="form-control text-right" placeholder="قیمت به تومان" data-validation-role="required,number" value="<?php echo $pic->price; ?>">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-block" name="submit" value="تغییر" >
                                </div>
                                <div class="form-group">
                                    <a href="http://localhost:8080/backend-web/picShop/panel.php" class="btn btn-outline-danger btn-sm px-2 btn-block"> بازگشت به صفحه اصلی  </a>
                                    </li>
                                </div>


                            </fieldset>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php endif; ?>

<!--------------------edit user---------------------->
<?php if (isset($_GET["uid"]) && !empty($_GET["uid"])): ?>
    <?php
$msgSuccess=false;
$msgErr=false;
$user=Users::getUserById($_GET["uid"]);
    if (isset($_POST["submit"]))
    {
        if ( isset($_POST["firstName"]) && !empty($_POST["firstName"])  && isset($_POST["lastName"]) && !empty($_POST["lastName"])   && isset($_POST["userName"]) && !empty($_POST["userName"]) && isset($_POST["mobile"]) && !empty($_POST["mobile"]) && isset($_POST["status"]) && !empty($_POST["status"]))
        {


            $result=Users::editUser($_POST["firstName"] , $_POST["lastName"] , $_POST["userName"] , $_POST["mobile"] , $_POST["status"] , $_GET["uid"]);
            $msgSuccess=true;
        }
        echo "<script>const params = new URLSearchParams(location.search); window.location=window.location.pathname+'?'+params.toString(); </script>";
    }
    ?>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post">

                            <fieldset>
                                <legend class="text-center">ایجاد تغییر</legend>
                                    <div class="form-group text-right">
                                        <label for="" class="">نام</label>
                                        <input type="text" name="firstName" class="form-control text-right" placeholder="نام" data-validation-role="required,number" value="<?php echo  $user->firstName ; ?>">
                                        <small class="err"></small>
                                    </div>

                                    <div class="form-group text-right">
                                        <label for="" class="">نام خانوادگی</label>
                                        <input type="text" name="lastName" class="form-control text-right" placeholder="نام خانوادگی"  value="<?php echo  $user->lastName ; ?>">
                                        <small class="err"></small>
                                    </div>

                                    <div class="form-group text-right">
                                        <label for="" class="">نام کاربری</label>
                                        <input type="text" name="userName" class="form-control text-right" placeholder="نام کاربری"  value="<?php echo  $user->userName ; ?>">
                                        <small class="err"></small>
                                    </div>


                                    <div class="form-group text-right">
                                        <label for="" class="">تلفن همراه</label>
                                        <input type="text" name="mobile" class="form-control text-right" placeholder="تلفن همراه"  value="<?php echo  $user->mobile ; ?>">
                                        <small class="err"></small>
                                    </div>

                                <div class="form-group text-right">
                                    <label for="" class="">وضعیت</label>
                                    <input type="number" max="1" min="0" name="status" class="form-control text-right" placeholder="وضعیت "  value="<?php echo  $user->status ; ?>">
                                    <small class="err"></small>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-block" name="submit" value="تغییر" >
                                </div>
                                <div class="form-group">
                                    <a href="http://localhost:8080/backend-web/picShop/panel.php" class="btn btn-outline-danger btn-sm px-2 btn-block"> بازگشت به صفحه اصلی  </a>
                                    </li>
                                </div>


                            </fieldset>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php endif; ?>



<?php  if($msgSuccess) : ?>

    <script>
        swal({title:"با موفقیت انجام شد",
            icon:"success" ,
            button:"بستن",
            timer:3000}).then(function () {
            const params = new URLSearchParams(location.search);
            window.location=window.location.pathname+'?'+params.toString();

        })
    </script>
<?php endif; ?>
<?php  if($msgErr) : ?>

    <script>
        swal({title:"خطا",
            text:"<?php echo $msg ;?>",
            icon:"warning" ,
            button:"بستن",
            timer:3000}).then(function () {
            const params = new URLSearchParams(location.search);
            window.location=window.location.pathname+'?'+params.toString();

        })
    </script>
<?php endif; ?>

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
<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="javaScript/formJs.js"></script>
</body>
</html>
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
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        @font-face {
            font-family: is-sans;
        }
        .card{
            direction: rtl;
            text-align: right;
            font-family: is-sans;
        }
    </style>
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


    <?php
    require_once "includes/include.php";

    if(isset($_POST["form-type"]))
    {
        switch ($_POST["form-type"])
        {
            case 2:
                {
                    Users::deleteUser($_POST["ID"]);
                }
            break;
            case 3:
            {
                if(!empty($_POST['check_listUser']) ){
                    foreach($_POST['check_listUser'] as $selected)
                    {
                        Users::deleteUser($selected);
                    }
                }
            }
            break;
            case 4:
            {
                Pictures::deletePicture($_POST["ID"]);
            }
            break;
            case 5:
            {
                if(!empty($_POST['check_listPics']) ){
                    foreach($_POST['check_listPics'] as $selected)
                    {
                        Pictures::deletePicture($selected);
                    }
                }
            }
            break;
            case 6:
                {

                    Categories::deleteCat($_POST["ID"]);
                }
                break;
            case 7:
                {
                    if(!empty($_POST['check_listPics']) ){
                        foreach($_POST['check_listPics'] as $selected)
                        {
                            Categories::deleteCat($selected);
                        }
                    }
                }
                break;

        }
    }











    ?>
</head>
<body>




<div class="container">


    <div class="row">
        <div class="col-12 mx-auto">
            <div class="card text-center">
                <div class="card">
                    <div class="card-header bg-light ">
                        <h1 class="card-title text-muted text-center">
                            پنل مدیریت
                        </h1>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item myTab" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">داشبورد</a>
                            </li>
                            <li class="nav-item myTab" role="presentation">
                                <a class="nav-link " id="user-tab" data-toggle="tab" href="#users" role="tab" aria-controls="user" aria-selected="false">کاربران سایت</a>
                            </li>
                            <li class="nav-item myTab" role="presentation">
                                <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">محصولات</a>
                            </li>
                            <li class="nav-item myTab" role="presentation">
                                <a class="nav-link"id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">سفارشات</a>
                            </li>
                            <li class="nav-item myTab" role="presentation">
                                <a class="nav-link" id="cats-tab" data-toggle="tab" href="#cats" role="tab" aria-controls="cats" aria-selected="false">دسته بندی ها</a>
                            </li>



                            <li class="nav-item">
                                <form id="adminForm" action="" method="post">
                                    <input type="hidden" class="form-type" name="form-type">
                                    <input type="hidden" class="form-type" name="form-sub" >
                                    <input type="hidden" name="ID" data-key="token" >
                                    <input type="hidden" name="fName" data-key="token" >
                                    <input type="hidden" name="lName" data-key="token" >
                                    <input type="hidden" name="uName" data-key="token" >
                                    <input type="hidden" name="pass" data-key="token" >
                                    <input type="hidden" name="roles" data-key="token" >
                                    <input type="hidden" name="statuss" data-key="token" >
                                    <input type="hidden" name="activation" data-key="token" >
                                    <input type="hidden" name="Email" data-key="token" >
                                    <input type="hidden" name="phone" data-key="token" >
                            <li>
                            </li>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title"></h1>
                </div>

                <div class="card-body">
                    <div class=" tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <h2 class="text-right">اطلاعات کلی فروشگاه</h2>
                        <hr>
                        <p class="h4 text-muted"><strong>  تعداد عکس ها :</strong>  <?php echo Pictures::CountPics(); ?> </p>
                        <p class="h4 text-muted"><strong>  تعداد کاربران :</strong>  <?php echo Users::CountUser(); ?> </p>
                        <p class="h4 text-muted"><strong>  تعداد سفارشات تا به این لحظه :</strong>  <?php echo Orders::CountOrders(); ?> </p>
                        <p class="h4 text-muted"><strong>  مجموع درآمد تا به این لحظه :</strong>  <?php echo Orders::CountCache();?> تومان </p>


                    </div>


                    <div class="tab-pane fade d-none" id="users" role="tabpanel" aria-labelledby="user-tab">

                        <button   class="btnUser  btn btn-sm btn-outline-danger mx-2 mb-3">حذف کلی <i class="fa fa-times mx-1"></i> </button>
                        <a href="http://localhost:8080/backend-web/picShop/adminInsert?addUser=1" class="btn mb-3 btn-outline-primary  btn-sm px-2"> ایجاد کاربر<i class="fa fa-plus mx-1"></i> </a>


                    <table class="table table-hover table-bordered table-striped  " >
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" name="check-allUser" value="0" ></th>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام کامل</th>
                            <th class="text-center">نام کاربری</th>
                            <th class="text-center">ایمیل</th>
                            <th class="text-center">موبایل</th>
                            <th class="text-center">وضعیت کاربری</th>
                            <th class="text-center">نوع کاربری</th>
                            <th class="text-center">عملیات</th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $findAllUser = null;
                        $findAllUser = Users::getAllUsers();


                        if (Users::getAllUsers()!= false)
                        {
                            $count1=1;
                            foreach ($findAllUser as $row1): ?>

                                <tr>
                                    <input type="hidden" name="uid" value="<?php echo $row1->id ?>">
                                    <input type="hidden" name="firstName" value="<?php echo $row1->firstName ?>">
                                    <input type="hidden" name="lastName" value="<?php echo $row1->lastName ?>">
                                    <input type="hidden" name="userName" value="<?php echo $row1->userName ?>">
                                    <input type="hidden" name="password" value="<?php echo $row1->password ?>">
                                    <input type="hidden" name="role" value="<?php echo $row1->role ?>">
                                    <input type="hidden" name="status" value="<?php echo $row1->status ?>">
                                    <input type="hidden" name="activationKey" value="<?php echo $row1->activationKey ?>">
                                    <input type="hidden" name="email" value="<?php echo $row1->email ?>">
                                    <input type="hidden" name="mobile" value="<?php echo $row1->mobile ?>">
                                    <td class="text-center"><input type="checkbox" name="check_listUser[]" class="checkboxUser"  value="<?php echo $row1->id ?>"></td>
                                    <td class="text-center"><?php echo $count1  ?></td>
                                    <td class="text-center"><?php echo $row1->firstName . " " . $row1->lastName ?></td></td>
                                    <td class="text-center"><?php echo $row1->userName ;?></td></td>
                                    <td class="text-center"><?php echo $row1->email ?></td></td>
                                    <td class="text-center"><?php echo $row1->mobile ;?></td></td>


                                    <td class="text-center">
                                        <?php
                                        switch ($row1->role){
                                            case "user":
                                                echo '<span class="btn btn-sm btn-outline-dark">کاربر</span>';
                                                break;
                                            case "admin":
                                                echo '<span class="btn btn-sm btn-outline-primary">ادمین سایت</span>';

                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php
                                        switch ($row1->status){
                                            case 0:
                                                echo '<span class="btn btn-sm btn-danger">غیر فعال</span>';
                                                break;
                                            case 1:
                                                echo '<span class="btn btn-sm btn-success">فعال</span>';
                                                break;


                                        }
                                        ;?></td>

                                    <td>
                                        <a href="http://localhost:8080/backend-web/picShop/adminInsert?uid=<?php echo $row1->id ?>" class="text-center float-left " ><i class="fa fa-edit"></i></a>
                                        <a href="#" class="text-center float-right text-danger" data-deleteUser="on"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>

                                <?php $count1++; endforeach; }?>


                        </tbody>

                    </table>
                    </div>


                <div class="tab-pane fade d-none" id="images" role="tabpanel" aria-labelledby="images-tab">

                    <button   class="btnPics btn btn-sm btn-outline-danger mx-2 mb-3">حذف کلی <i class="fa fa-times mx-1"></i> </button>
                    <a href="http://localhost:8080/backend-web/picShop/adminInsert?addPic=1" class="btn btn-outline-primary  btn-sm px-2 mb-3">افزودن عکس<i class="fa fa-plus mx-1"></i> </a>


                    <table  class=" table table-hover table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" name="check-allPics" value="0" ></th>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">عنوان عکس</th>
                            <th class="text-center">دسته بندی</th>
                            <th class="text-center">آدرس عکس اصلی</th>
                            <th class="text-center">آدرس عکس thumb_nail</th>
                            <th class="text-center">قیمت عکس</th>
                            <th class="text-center">عملیات</th>

                        </tr>
                        </thead>

                    <tbody>
                    <?php
                    $findimages = null;
                    $findImages = Pictures::getAllPictures();


                    if (Pictures::getAllPictures()!= false)
                    {

                        $count2=1;
                        foreach ($findImages as $row2): ?>

                            <tr>
                                <input type="hidden" name="pid" value="<?php echo $row2->id ?>">
                                <input type="hidden" name="title" value="<?php echo $row2->title ?>">
                                <input type="hidden" name="path" value="<?php echo $row2->path ?>">
                                <input type="hidden" name="name" value="<?php echo Categories::getCatName($row2->cat_id) ?>">
                                <input type="hidden" name="thumb_url" value="<?php echo $row2->thumb_url ?>">
                                <input type="hidden" name="price" value="<?php echo $row2->price ?>">
                                <input type="hidden" name="cat_id" value="<?php echo $row2->cat_id ?>">
                                <td class="text-center"><input type="checkbox" name="check_listPics[]" class="checkboxPics"  value="<?php echo $row2->id ?>"></td>
                                <td class="text-center"><?php echo $count2  ?></td>
                                <td class="text-center"><?php echo $row2->title ?></td>
                                <td class="text-center"><?php echo Categories::getCatName($row2->cat_id) ;?></td>
                                <td class="text-center"><?php echo  $row2->path ?></td>
                                <td class="text-center"><?php echo $row2->thumb_url ;?></td>
                                <td class="text-center"><?php echo $row2->price ;?></td>


                                <td>
                                    <a href="http://localhost:8080/backend-web/picShop/adminInsert?imageE=<?php echo $row2->id ?>" class="text-center float-left " ><i class="fa fa-edit"></i></a>
                                    <a href="#" class="text-center float-right text-danger" data-deletePics="on"><i class="fa fa-trash-alt"></i></a>
                                </td>
                            </tr>

                            <?php $count2++; endforeach; }?>

                    </tbody>
                    </table>
                </div>



                    <div class="tab-pane fade d-none" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    <table  class=" table table-hover table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" name="check-all" value="0" ></th>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">آیدی کاربر</th>
                            <th class="text-center">آیدی محصول</th>
                            <th class="text-center">هزینه پرداختی</th>
                            <th class="text-center">تاریخ ثبت سفارش</th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $allOrders = null;
                        $allOrders = Orders::getAllOrders();


                        if (Orders::getAllOrders()!= false)
                        {

                            $count3=1;
                            foreach ($allOrders as $row3): ?>

                                <tr>
                                    <input type="hidden" name="pid" value="<?php echo $row3->id ?>">
                                    <input type="hidden" name="title" value="<?php echo $row3->image_id ?>">
                                    <input type="hidden" name="path" value="<?php echo $row3->user_id ?>">
                                    <input type="hidden" name="thumb_url" value="<?php echo $row3->create_date ?>">
                                    <input type="hidden" name="price" value="<?php echo $row3->price ?>">
                                    <td class="text-center"><input type="checkbox" name="check_list[]" class="checkbox"  value="<?php echo $row3->id ?>"></td>
                                    <td class="text-center"><?php echo $count3  ?></td>
                                    <td class="text-center"><?php echo $row3->user_id ?></td>
                                    <td class="text-center"><?php echo $row3->image_id ;?></td>
                                    <td class="text-center"><?php echo  $row3->price ?></td>
                                    <td class="text-center"><?php echo $row3->create_date ;?></td>
                                </tr>

                                <?php $count3++; endforeach; }?>

                        </tbody>
                    </table>
                    </div>

                    <div class="tab-pane fade d-none"  id="cats" role="tabpanel" aria-labelledby="cats-tab">
<!--                        <button   class="btnCat btn btn-sm btn-outline-danger mx-2 mb-3">حذف کلی <i class="fa fa-times mx-1"></i> </button>-->
                        <a href="http://localhost:8080/backend-web/picShop/adminInsert?cat=1" class="btn btn-outline-primary  btn-sm px-2 mb-3">افزودن دسته بندی<i class="fa fa-plus mx-1"></i> </a>

                        <table class=" table table-hover table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" name="check-allCats" value="0" ></th>
                            <th class="text-center">ردیف</th>
                            <th class="text-center">نام دسته بندی</th>
                            <th class="text-center">عملیات</th>

                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $allCat = null;
                        $allCat= Categories::getAllCategories();


                        if (Categories::getAllCategories()!= false)
                        {

                            $count4=1;
                            foreach ($allCat as $row4): ?>

                                <tr>
                                    <input type="hidden" name="pid" value="<?php echo $row4->id ?>">
                                    <input type="hidden" name="title" value="<?php echo $row4->name ?>">
                                    <input type="hidden" name="path" value="<?php echo $row4->ord ?>">
                                    <td class="text-center"><input type="checkbox" name="check_listCat[]" class="checkboxCat"  value="<?php echo $row4->id ?>"></td>
                                    <td class="text-center"><?php echo $count4  ?></td>
                                    <td class="text-center"><?php echo $row4->name ?></td>


                                    <td>
                                        <a href="http://localhost:8080/backend-web/picShop/adminInsert?catE=<?php echo $row4->id ?>" class="text-center float-left " ><i class="fa fa-edit"></i></a>
<!--                                        <a href="#" class="text-center float-right text-danger" data-deleteCats="on"><i class="fa fa-trash-alt"></i></a>-->
                                    </td>
                                </tr>

                                <?php $count4++; endforeach; }?>

                        </tbody>
                    </table>
                    </div>







                    </form>
                </div>



                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</div>



<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules//sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="node_modules//sweetalert2/dist/sweetalert2.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="javaScript/panelJS.js"></script>
</body>
</html>

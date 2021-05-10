<?php

include_once "MainClass.class.php";
class Pictures extends MainClass
{
    protected $data = array(
        "id" => 0 ,
        "cat_id" => 0 ,
        "title" => "" ,
        "path" => "" ,
        "thumb_url" => "" ,
        "price" => "",
        "name" => ""
    );


    public static  function InsertPicture($title,$cat_id,$price,$path,$thumb){
        $connect = self::connect();
        $title = trim($title);
        $title = sanitize($title);
        $cat_id = trim($cat_id);
        $cat_id = sanitize($cat_id);
        $price = trim($price);
        $price = sanitize($price);


        $sql = ("INSERT ".DB_IMAGES." SET `title` = ? , `cat_id` = ? , `path` = ? , `price` = ? , `thumb_url` = ?  ");


        $result = $connect->prepare($sql);
        $result->bindValue(1,$title);
        $result->bindValue(2,$cat_id);
        $result->bindValue(3,$path);
        $result->bindValue(4,$price);
        $result->bindValue(5,$thumb);

        $result->execute();

        return $result ;
    }

    public static function getAllPictures(){
        $connect = self::connect();
        $sql = ("select * from ". DB_IMAGES);
        $result = $connect->prepare($sql);
        $result->execute();
        if($result->rowCount()){
            $pics = array();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC) ;
            foreach ($rows as $row){
                $pics[] = new Pictures($row);
            }
            $ret = $pics ;
        }
        else
            $ret = 0 ;
        self::disconnect($connect);
        return $ret ;
    }


    public static function getPicById($id){
        $connect = self::connect();
        $sql = ("select images.* , `name` from `". DB_IMAGES ."` , `".DB_CATEGORIES."` WHERE images.cat_id=categories.id and images.id = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$id);
        $result->execute();
        if($result->rowCount()){
            $row = $result->fetch(PDO::FETCH_ASSOC) ;
            $pic = new Pictures($row);
            $ret = $pic ;
        }
        else
            $ret = false ;
        self::disconnect($connect);
        return $ret ;
    }

    public static function deletePicture($id)
    {
        $connect = self::connect();
        $sql = ("DELETE  from ". DB_IMAGES ." WHERE `id` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$id);
        $result->execute();
        if($result->rowCount()){
            return true;
        }
        else
            return false ;
        self::disconnect($connect);

    }


    public static function getCountPictures($limit=0 , $start=0){
        $connect = self::connect();
        $limiter = $limit > 0 ? "LIMIT $start , $limit " : "";
        $sql = ("select images.* , `name` from `". DB_IMAGES ."` , `".DB_CATEGORIES."` WHERE images.cat_id=categories.id ORDER BY `create_date` desc  $limiter");
        $result = $connect->prepare($sql);
        $result->execute();
        if($result->rowCount()){
            $pics = array();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC) ;
            foreach ($rows as $row){
                $pics[] = new Pictures($row);
            }
            $ret = $pics ;
        }
        else
            $ret = 0 ;
        self::disconnect($connect);
        return $ret ;
    }

    public static function getCatPictures($limit=0 , $start=0 , $cat){
        $connect = self::connect();
        $limiter = $limit > 0 ? "LIMIT $start , $limit " : "";
        $sql = ("select images.* , `name` from `". DB_IMAGES ."` , `".DB_CATEGORIES."` WHERE images.cat_id=categories.id and `cat_id` = ? ORDER BY `create_date` desc  $limiter");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$cat);
        $result->execute();
        if($result->rowCount()){
            $pics = array();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC) ;
            foreach ($rows as $row){
                $pics[] = new Pictures($row);
            }
            $ret = $pics ;
        }
        else
            $ret = false ;
        self::disconnect($connect);
        return $ret ;
    }


    public static function CountPics()
    {
        $connect = self::connect();
        $sql = ("select count(id) from ". DB_IMAGES);
        $result = $connect->prepare($sql);
        $result->execute();
        if($result->rowCount()){
            $count = $result->fetch(PDO::FETCH_ASSOC) ;
            $count=$count["count(id)"];
        }
        else
            $count = false ;
        self::disconnect($connect);
        return $count ;
    }
    public static function CountPicsBYCat($cat)
    {
        $connect = self::connect();
        $sql = ("select count(id) from ". DB_IMAGES ." WHERE cat_id = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$cat);
        $result->execute();
        if($result->rowCount()){
            $count = $result->fetch(PDO::FETCH_ASSOC) ;
            $count=$count["count(id)"];
        }
        else
            $count = false ;
        self::disconnect($connect);
        return $count ;
    }

    public  static function editPic(  $title ,$cid , $price ,$imgid )
    {
        $connect = self::connect();
        $sql = ("UPDATE `".DB_IMAGES."` SET `title` = ? , `cat_id` = ? , `price`  = ?  WHERE `id` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$title);
        $result->bindValue(2,$cid);
        $result->bindValue(3,$price);
        $result->bindValue(4,$imgid);
        $result->execute();
        if($result->rowCount()){
            return 1;
        }
        else
            return 0 ;
        self::disconnect($connect);
    }

    public static  function addPicCart($uid,$pid)
    {
        $connect = self::connect();
        $sql = ("INSERT ".DB_CART." SET `uid` = ? , `pid` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$uid);
        $result->bindValue(2,$pid);
        $result->execute();
        if ($result -> rowCount())
        {
            return true;
        }
        else
            return false;
    }


    public static function cartCounter($uid)
    {
        $connect = self::connect();
        $sql = ("select pid from ". DB_CART ." WHERE `uid` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$uid);
        $result->execute();
        if($result->rowCount()){
            $rows = $result->fetchAll(PDO::FETCH_ASSOC) ;
            foreach ($rows as $row){
                $_SESSION['cart'][] = $row["pid"];
            }
            return true;

        }
        else
            return false ;
        self::disconnect($connect);

    }

    public static function getUserImage($uid)
    {
        $connect = self::connect();
        $sql = ("select image_id from ". DB_ORDERS ." WHERE `user_id` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$uid);
        $result->execute();
        if($result->rowCount()){
            $rows = $result->fetchAll(PDO::FETCH_ASSOC) ;
            foreach ($rows as $row){
                $_SESSION['userPics'][] = $row["image_id"];
            }
            return true;

        }
        else
            return false ;
        self::disconnect($connect);

    }

    public static function deletePicFromCart($pid)
    {
        $connect = self::connect();
        $sql = ("DELETE  from ". DB_CART ." WHERE `pid` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$pid);
        $result->execute();
        if($result->rowCount()){
            return true;
            }
        else
            return false ;
        self::disconnect($connect);

    }

    public static  function addShopping($image_id,$user_id , $price)
    {
        $connect = self::connect();
        $sql = ("INSERT ".DB_ORDERS." SET `image_id` = ? , `user_id` = ?  , `price` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$image_id);
        $result->bindValue(2,$user_id);
        $result->bindValue(3,$price);
        $result->execute();
        if ($result -> rowCount())
        {
            return true;
        }
        else
            return false;
    }

    public static  function maxSelling()
    {
        $connect = self::connect();
        $sql = ("SELECT `image_id`,COUNT(user_id)  from ".DB_ORDERS." GROUP BY `image_id` limit 3");
        $result = $connect->prepare($sql);
        $result->execute();
        if ($result -> rowCount())
        {
            $count = $result->fetchall(PDO::FETCH_ASSOC) ;
            foreach ($count as $row){
                $pic[] = $row["image_id"];
            }
            return $pic;
        }
        else
            return 0;
    }


}
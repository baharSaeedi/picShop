<?php

include_once "MainClass.class.php";
class Categories extends MainClass
{
    protected $data = array(
        "id" => 0 ,
        "name" => "" ,
        "ord" => 0 ,
    );



    public  static  function getAllCategories()
    {
        $connect = self::connect();
        $sql = ("select * from " . DB_CATEGORIES);
        $result = $connect->prepare($sql);
        $result->execute();
        if ($result->rowCount()) {
            $cats = array();
            $rows = $result->fetchAll(PDO::FETCH_ASSOC) ;
            foreach ($rows as $row){
                $cats[] = new Categories($row);
            }
            $ret = $cats ;
        }
        else
            $ret = false ;
        self::disconnect($connect);
        return $ret ;
    }

    public static function  getCatName($cat_id)
    {
        $connect = self::connect();
        $sql = ("SELECT `name`  FROM `".DB_CATEGORIES."` WHERE `id` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$cat_id);

        $result->execute();

        if($result->rowCount()){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row["name"];
        }
    }
    public static function  getCatId($name)
    {
        $connect = self::connect();
        $sql = ("SELECT `id`  FROM `".DB_CATEGORIES."` WHERE `name` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$name);

        $result->execute();

        if($result->rowCount()){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row["id"];
        }
        else false;
    }

    public static function  addCat($name)
    {
        $connect = self::connect();
        $sql = ("INSERT ".DB_CATEGORIES."  set  name  = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$name);

        $result->execute();

        if($result->rowCount()){
            return true;
        }
        else
            return false;
    }

    public static function deleteCat($id)
    {
        $connect = self::connect();
        $sql = ("DELETE  from ". DB_CATEGORIES ." WHERE `id` = ? ");
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

    public static function getCatById($id){
        $connect = self::connect();
        $sql = ("select * from ". DB_CATEGORIES . " WHERE `id` = ?");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$id);
        $result->execute();
        if($result->rowCount()){
            $row = $result->fetch(PDO::FETCH_ASSOC) ;
            $cat = new Categories($row);
            $ret = $cat ;
        }
        else
            $ret = false ;
            self::disconnect($connect);
            return $ret ;
    }

    public static function updateCat( $name , $id)
    {
        $connect = self::connect();
        $sql = ("UPDATE `".DB_CATEGORIES."` SET `name` = ?   WHERE `id` = ? ");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$name);
        $result->bindValue(2,$id);
        $result->execute();
        if($result->rowCount()){
            return true;
        }
        else
            return false ;
        self::disconnect($connect);

    }

    public static function isCatExist($name)
    {
        $connect = self::connect();
        $catName = sanitize($name);
        $sql = ("SELECT `id` FROM ".DB_CATEGORIES." WHERE `name` = ?");
        $result = $connect->prepare($sql);
        $result->bindValue(1,$catName);
        $result->execute();
        if($result->rowCount() > 0){
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row["id"];
        }
        return false ;
    }
}
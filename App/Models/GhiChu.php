<?php

namespace App\Models;

use PDO;

class GhiChu extends \Core\Model
{
    //mảng các lối
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    public static function ThemGhiChu($user_id){
        $sql = 'call ThemSuaGC( :maghichu , :user_id , :iconGC , :tieudeGC , :ndGC , :trangthai )';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':maghichu', 0, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':iconGC', "&#x1F4C4;", PDO::PARAM_STR);
        $stmt->bindValue(':tieudeGC', "", PDO::PARAM_STR);
        $stmt->bindValue(':ndGC', " ", PDO::PARAM_STR);
        $stmt->bindValue(':trangthai', 1, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetch();
    }

    public function ThemSuaGhiChu()
    {
        $trave = 0;
        $sql =  'call ThemSuaGC( :maghichu , :user_id , :iconGC , :tieudeGC , :ndGC , :trangthai)';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':maghichu', $this->maghichu, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(':iconGC', $this->iconghichu, PDO::PARAM_STR);
        $stmt->bindValue(':tieudeGC', $this->tieudeghichu, PDO::PARAM_STR);
        $stmt->bindValue(':ndGC', $this->ndghichu, PDO::PARAM_STR);
        $stmt->bindValue(':trangthai', $this->trangthai, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        return $stmt->fetch()->ghichuid;
    }

    public static function XoaGhiChu($maghichu)
    {
        $sql = "CALL `ql_ghichu`.`XoaGC`( :maghichu )";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':maghichu', $maghichu, PDO::PARAM_INT);
        return $stmt->execute();

    }
    public static function FindByUserId($userid)
    {
        $sql = "SELECT maghichu,iconghichu,tieudeghichu FROM ghichu WHERE user_id = :user_id order by ngaytao DESC";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public static function findByTitle($userid, $title)
    {
        $sql = "SELECT maghichu,iconghichu,tieudeghichu FROM ghichu WHERE tieudeghichu like :tieudeghichu and user_id = :user_id order by ngaytao DESC";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':tieudeghichu', "%".$title."%", PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $userid, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public static function findByThes($userid, $thes)
    {
        $sql = "SELECT maghichu,iconghichu,tieudeghichu from ghichu where ghichu.user_id = 1 
        and maghichu in (SELECT maghichu FROM theghichu where mathe = 1 
        and maghichu in (SELECT maghichu FROM theghichu where mathe = 2 
        and maghichu in (SELECT maghichu FROM theghichu where mathe = 4
        ))) order by ngaycapnhat";

        $ng = "";
        $sql1 = "SELECT maghichu,iconghichu,tieudeghichu from ghichu where ghichu.user_id = $userid";
        for($i = 0; $i < sizeof($thes);$i++){
            $sql1 = $sql1." and maghichu in (SELECT maghichu FROM theghichu where mathe = ".$thes[$i]." ";
            $ng = $ng.")";
        }
        $sql1 = $sql1.$ng.' order by ngaycapnhat DESC ';
        $db = static::getDB();
        $stmt = $db->prepare($sql1);

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;

    }
    public static function ghichuKoThe($userid){
        $sql = "SELECT * FROM ghichu where user_id = :user_id and maghichu not in(SELECT maghichu FROM theghichu) order by ngaytao DESC ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $userid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public static function getGhiChuById($id)
    {
        $sql = "SELECT * FROM ghichu WHERE maghichu = :maghichu";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':maghichu', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $bien = $stmt->fetch();
        return $bien;
    }
    public static function isUserNote($user_id,$maghichu){
        $sql = "SELECT maghichu,tieudeghichu,user_id FROM ghichu WHERE maghichu = :maghichu and user_id = :user_id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':maghichu', $maghichu, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $bien = $stmt->fetch();
        if($bien){
            return true;
        }else{
            return false;
        }
    }
}



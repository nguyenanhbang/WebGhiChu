<?php
namespace App\Models;
use PDO;
class The extends \Core\Model{
    
    public static function SuaThe($mathe,$tenthe){
        $sql = "UPDATE the SET tenthe = :tenthe WHERE mathe = :mathe";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':tenthe', $tenthe, PDO::PARAM_STR);
        $stmt->bindValue(':mathe', $mathe, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function ThemThe($user_id,$name){
        $sql = "INSERT INTO the(tenthe,user_id) VALUES( :tenthe , :user_id )";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':tenthe', $name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $lastId = $db->lastInsertId();
        return static::GetTheById($lastId);
    }
    public static function findThesById($user_id){
        $sql = "SELECT * FROM the WHERE user_id = :user_id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public static function XoaThe($mathe){

        $sql ="DELETE FROM the WHERE mathe = :mathe";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':mathe', $mathe, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function GetTheById($the_id){
        $sql = "SELECT * FROM the WHERE mathe = :mathe ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':mathe', $the_id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $bien = $stmt->fetch();
        return $bien;
    }
    public static function CheckTenThe($user_id,$name){
        $sql = "SELECT * FROM the WHERE tenthe = '$name' and user_id = $user_id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $bien = $stmt->fetch();
        return $bien;
    }
}
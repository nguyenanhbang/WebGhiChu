<?php

namespace App\Models;

use PDO;

class TheGhiChu extends \Core\Model
{
    //mảng các lối
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
    public static function SuaTheGhiChu($maghichu, $dsmathe)
    {
        $sql = "INSERT INTO theghichu(mathe,maghichu) VALUES( :mathe , :maghichu )";
        $db = static::getDB();
        if (!isset($dsmathe) || empty($dsmathe)) {
        } else {
            foreach ($dsmathe as $key) {
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':mathe', $key, PDO::PARAM_INT);
                $stmt->bindValue(':maghichu', $maghichu, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }
    public static function dsThecuaGhiChu($maghichu)
    {
        $sql = " SELECT * FROM theghichu WHERE maghichu = :maghichu ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':maghichu', $maghichu, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function XoaTheGhiChu($maghichu)
    {
        $sql = "DELETE FROM theghichu WHERE maghichu = $maghichu";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        //$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->execute();
    }
    public static function XoaGhiChuThe($mathe){
        $sql ="DELETE FROM theghichu WHERE mathe = $mathe";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
       // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        return $stmt->execute();
    }
}

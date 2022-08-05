<?php
namespace App\Models;

use PDO;
use App\LuuDNModel;
use App\Token;
use App\TaiKhoanModel;
class LuuDangNhap extends \Core\Model{

    public static function themLuuDN($hashed_token,$id,$expiry_timestamp){
        

        $sql = 'INSERT INTO luudangnhap (token, user_id, ngayhethan)
                VALUES (:token, :user_id, :ngayhethan)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':ngayhethan', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function getUserByToken($token){
        $sql = 'SELECT token,`user_id`as id,ngayhethan  FROM luudangnhap WHERE token = :token';
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();
        $bien = $stmt->fetch();
        return $bien;
    }

    public static function xoaLuuDN($token){
        $sql = "DELETE FROM luudangnhap WHERE token = :token";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        return $stmt->execute();
    }
}

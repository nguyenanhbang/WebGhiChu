<?php
namespace App\Models;
use PDO;
class TaiKhoan extends \Core\Model{
    //mảng các lối
    public $errors = [];

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    public static function DangNhap($email, $password){
        $sql = 'SELECT * FROM taikhoan WHERE email = :email and password = :password';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email',$email,PDO::PARAM_STR);
        $stmt->bindValue(':password',$password,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        $bien = $stmt->fetch();
        return $bien;
    }

    public static function findByEmail($email){
        $sql = 'SELECT * FROM taikhoan WHERE email = :email';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email',$email,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        return $stmt->fetch();
    }

    public static function findByID($id){
        $sql = 'SELECT * FROM taikhoan WHERE id = :id';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        $bien = $stmt->fetch();
        return $bien;
    }

    public function DangKy(){
        $sql = 'INSERT INTO taikhoan(`name`,`email`,`password`,`linkanh`,`trangthai`) VALUES (:name, :email, :password, :linkanh, :trangthai);';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name',$this->txt_name,PDO::PARAM_STR);
        $stmt->bindValue(':email',$this->txt_email,PDO::PARAM_STR);
        $stmt->bindValue(':password',$this->txt_pass,PDO::PARAM_STR);
        $stmt->bindValue(':linkanh','Không có',PDO::PARAM_STR);
        $stmt->bindValue(':trangthai',1,PDO::PARAM_INT);
        $stmt->execute();
        $lastId = $db->lastInsertId();
        return static::findByID($lastId);
    }

    public static function updateLinkAvatar($id,$linkanh){
        $sql = "UPDATE taikhoan SET linkanh = :linkanh WHERE id = :id ";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':linkanh',$linkanh,PDO::PARAM_STR);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        return $stmt->execute();
    }
}

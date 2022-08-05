<?php
namespace App;

class TaiKhoanModel{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $linkanh;
    public int $trangthai;

    function __construct( $id, $name, $email, $password, $linkanh, $trangthai ){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->linkanh = $linkanh;
        $this->trangthai = $trangthai;
    }
}

class LuuDNModel{
    public string $token;
    public int $user_id;
    public string $ngayktdn;
    function __construct($token,$user_id,$ngayktdn){
        $this->token=$token;
        $this->user_id=$user_id;
        $this->ngayktdn=$ngayktdn;
    }
}

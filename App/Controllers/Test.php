<?php
namespace App\Controllers;
use \Core\View;
use \App\Models\TaiKhoan;
use \App\Models\LuuDangNhap;
use \App\Models\GhiChu;
use \App\Config;
use \App\Token;
use \App\Flash;
use App\Models\TheGhiChu;

class Test extends \Core\Controller{

    public function indextkAction(){
        $taikhoan = TaiKhoan::findByEmail('long129363@nuce.edu.vn');
        echo $taikhoan->email . '|' . $taikhoan->name;
    }
    public function indexldnAction(){
        $token = new Token();
        
        $expiry_timestamp = time() + 60 * 60 * 24 * 7;
        $luudn = LuuDangNhap::themLuuDN($token->getHash(),1,$expiry_timestamp);
        setcookie("luudangnhap",$token->getValue(),$expiry_timestamp,"/",);

        echo $luudn;
    }
    public function dangkyAction(){
        echo $_SERVER['SERVER_NAME'];
        echo $_SERVER['REQUEST_URI'];
    }
    public function openthtmlAction(){
        
        View::renderTemplate("/Test/testwriteText.html",["emoji"=>"js/emoji.js"]);
    }
    public function thtmlAction(){
        $dstheghichu = TheGhiChu::dsThecuaGhiChu(7);
        echo var_dump($dstheghichu);
    }

}
<?php
namespace App\Controllers;

use App\Config;
use \Core\View;
use \App\Models\TaiKhoan;
use \App\Models\LuuDangNhap;
use \App\XacThuc;
use \App\Token;
use \App\Flash;
use \App\TaiKhoanModel;
class Login extends \Core\Controller{

    public function indexAction(){
        View::renderTemplate("/Login/login.html");
    }

    public function dangnhapAction(){
        //echo "open action in controller login".$_POST["email"].$_POST["password"];
        $user = TaiKhoan::DangNhap($_POST["email"],$_POST["password"]);
        $remember_me = isset($_POST['remember_me']);

        if(empty($user)){
            Flash::addMessage("Login not success!!!",Flash::WARNING);
            View::renderTemplate("Login/login.html",[
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }else{
            
            if($remember_me){
                XacThuc::capnhatRememberLogin($user->id);
                
            }else{
                session_regenerate_id(true);
                $_SESSION[Config::SESSION_REMEMBER_USER_ID] = $user->id;
            }
            $this->redirect("/");
        }
        
    }
    public function logoutAction(){
        XacThuc::logout();
        $this->redirect("/");
    }
}
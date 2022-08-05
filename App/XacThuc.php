<?php

namespace App;

use \App\Models\TaiKhoan;
use \App\Config;
use App\Models\LuuDangNhap;

class XacThuc
{

    public static function rememberRequestedPage()
    {
        $_SESSION[Config::SESSION_REMEMBER_PAGE] = $_SERVER['REQUEST_URI'];
    }

    public static function getReturnToPage()
    {
        return $_SESSION[Config::SESSION_REMEMBER_PAGE] ?? '/';
    }

    public static function loginFromRememberCookie()
    {
        if (!empty($_COOKIE[Config::SESSION_REMEMBER_TOKEN])) {

            $token = new Token($_COOKIE[Config::SESSION_REMEMBER_TOKEN]);

            $remembered_login = LuuDangNhap::getUserByToken($token->getValue());

            if (!empty($remembered_login)) {
                //echo "di qua";
                $user = TaiKhoan::findByID($remembered_login->id);
                return $user;
            }
        }
    }

    public static function getTaiKhoan()
    {
        if (!empty($_SESSION[Config::SESSION_REMEMBER_USER_ID])) {

            return TaiKhoan::findByID($_SESSION[Config::SESSION_REMEMBER_USER_ID]);
        } else {
            return static::loginFromRememberCookie();
        }
    }

    public static function capnhatRememberLogin($id)
    {

        //session_regenerate_id(true);
        $_SESSION[Config::SESSION_REMEMBER_USER_ID] = $id;

        $token = new Token();
        $expiry_timestamp = time() + 60 * 60 * 24 * 7; //7 ngay ko dang nhap se het han

        LuuDangNhap::themLuuDN($token->getValue(), $id, $expiry_timestamp);

        setcookie(Config::SESSION_REMEMBER_TOKEN, $token->getValue(), $expiry_timestamp, "/",);
    }

    public static function logout()
    {
        // Unset all of the session variables
        $_SESSION = [];

        LuuDangNhap::xoaLuuDN($_COOKIE[Config::SESSION_REMEMBER_TOKEN]);
        // Delete the session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Finally destroy the session
        session_destroy();
    }

    public static function CheckBeforeUpload($file){
        $target_dir = getcwd() . "/img/avatar/";
        $target_file = $target_dir . basename($file["file_avatar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["file_avatar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            //File is not an image
            $uploadOk = 2;
            return $uploadOk;
        }

        // Check file size
        if ($file["file_avatar"]["size"] > 50000000) {
            //Sorry, your file is too large
            $uploadOk = 3;
            return $uploadOk;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") 
            {
            //"Chi nhan file jpg,png,jpeg,gif"
            $uploadOk = 4;
            return $uploadOk;
        }

        return $uploadOk;
    }

    public static function Upload_avatar($file, $id)
    {
        $target_dir = getcwd() . "/img/avatar/";
        $target_file = $target_dir . basename($file["file_avatar"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["file_avatar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            Flash::addMessage("File is not an image.",Flash::WARNING);
            $uploadOk = 0;
        }

        // Check if file already exists
        // if (file_exists($target_file)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Check file size
        if ($file["file_avatar"]["size"] > 50000000) {
            Flash::addMessage("Sorry, your file is too large.",Flash::WARNING);
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            Flash::addMessage("Sorry, your file is too large.",Flash::WARNING);
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
        } else {
            $new_target_file = $target_dir . $id . "." . $imageFileType;
            if (move_uploaded_file($file["file_avatar"]["tmp_name"], $new_target_file)) {
                return $id . "." . $imageFileType;
            } else {
                return false;
            }
        }
    }
}

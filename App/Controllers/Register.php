<?php

namespace App\Controllers;

use PDO;
use App\XacThuc;
use App\Models\TaiKhoan;
use App\Flash;

class Register extends \Core\Controller
{
    public $errors = [];
    public function newAction()
    {
        //echo "Register";
        \Core\View::renderTemplate("/Register/register.html");
    }
    public function dangkyAction()
    {
        $useremail = TaiKhoan::findByEmail($_POST["txt_email"]);
        $havepic =0;
        //echo var_dump($_POST);
        //echo var_dump($useremail);
        if (isset($_POST["ck_ts"])) {
            // Name
            if ($_POST['txt_name'] == '') {
                $this->errors[] = 'Tên không được để trống';
            }

            // email address
            if (filter_var($_POST['txt_email'], FILTER_VALIDATE_EMAIL) === false) {
                $this->errors[] = 'Định dạng email không đúng';
            }
            if (isset($useremail->id)) {
                $this->errors[] = 'Email đã tồn tại';
            }

            // Password
            if (isset($_POST['txt_pass'])) {

                if (strlen($_POST['txt_pass']) < 6) {
                    $this->errors[] = 'Mật khẩu có ít nhất 6 ký tự';
                }

                if (preg_match('/.*[a-z]+.*/i', $_POST['txt_pass']) == 0) {
                    $this->errors[] = 'Mật khẩu có ít nhất 1 chữ cái';
                }

                if (preg_match('/.*\d+.*/i', $_POST['txt_pass']) == 0) {
                    $this->errors[] = 'Mật khẩu có ít nhất 1 chữ số';
                }
            }

            if($_FILES['file_avatar']['type'] != ""){
                $ckupload = XacThuc::CheckBeforeUpload($_FILES);
                switch($ckupload){
                    case 1:
                        //du dieu kien upload
                        $havepic =1;
                        break;
                    case 2:
                        //File is not an image
                        $this->errors[] = 'File không phải là hình ảnh';
                        break;
                    case 3:
                        //Sorry, your file is too large
                        $this->errors[] = 'File có kích thước quá lớn !!!';
                        break;
                    case 4:
                        //"Chi nhan file jpg,png,jpeg,gif"
                        $this->errors[] = 'Chỉ nhận file có định dạng: jpg ,png ,jpeg ,gif !!!';
                        break;
                }
            }

            if (empty($this->errors)) {
                $tk = new TaiKhoan($_POST);
                $iduser = $tk->DangKy()->id;
                if($iduser >0){
                    if($havepic ==1){
                        $filename =  XacThuc::Upload_avatar($_FILES,$iduser);
                        if($filename){
                            TaiKhoan::updateLinkAvatar($_SERVER['SERVER_NAME']."/sendpic&name=".$filename,$iduser);
                        }else{
                            TaiKhoan::updateLinkAvatar($_SERVER['SERVER_NAME']."/sendpic&name="."minh.jpg",$iduser);
                        }
                        session_regenerate_id(true);
                        $_SESSION[\App\Config::SESSION_REMEMBER_USER_ID] = $iduser;
                        $this->redirect("/");
                    } else {
                        \Core\View::renderTemplate("/Register/register.html", ["errors" => "Some error!!!"]);
                    }
                }

            } else {
                \Core\View::renderTemplate("/Register/register.html", ["errors" => $this->errors]);
            }
        } else {
            Flash::addMessage("Bạn chưa đồng ý với điều khoản");
            \Core\View::renderTemplate("/Register/register.html", ["errors" => $this->errors]);
        }

        //XacThuc::Upload_avatar($_FILES,1);
    }
}
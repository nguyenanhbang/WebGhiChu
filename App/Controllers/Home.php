<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\TaiKhoan;
use \App\Models\GhiChu;
use \App\Models\The;
use \App\Models\TheGhiChu;
use \App\XacThuc;
use \App\Config;

class Home extends \Core\Controller
{
    public function indexAction()
    {

        if (!empty($_SESSION[Config::SESSION_REMEMBER_USER_ID])) {

            $this->RenderHome($_GET);
        } else {
            $user = XacThuc::loginFromRememberCookie();
            if (empty($user)) {

                View::renderTemplate("/Login/login.html");
            } else {


                XacThuc::capnhatRememberLogin($user->id);
                $this->RenderHome($_GET);
            }
        }
    }

    protected function RenderHome($maghichu)
    {
        $dsghichu = GhiChu::FindByUserId($_SESSION[Config::SESSION_REMEMBER_USER_ID]);

        if (isset($maghichu["currentmaghichu"])) {
            if (GhiChu::isUserNote($_SESSION[Config::SESSION_REMEMBER_USER_ID], $maghichu["currentmaghichu"])) {
                $ghichunew = $maghichu["currentmaghichu"];
            } else {

                $ghichunew = $dsghichu[0]["maghichu"];
            }
        } else {
            if (empty($dsghichu)) {
                $ghichunew = 0;
            } else {
                $ghichunew = $dsghichu[0]["maghichu"];
            }
            
        }
        $infoghichunew = GhiChu::getGhiChuById($ghichunew);
        $dsthe = The::findThesById($_SESSION[Config::SESSION_REMEMBER_USER_ID]);
        $dsthecurrentghichu = $dsthe;

        $currenttheghichu = TheGhiChu::dsThecuaGhiChu($ghichunew);

        foreach ($dsthecurrentghichu as $key => $value) {
            $bien = false;
            foreach ($currenttheghichu as $value1) {
                if ($value['mathe'] == $value1['mathe']) {
                    $bien = true;
                }
            }
            $dsthecurrentghichu[$key]["checked"] = $bien;
        }

        View::renderTemplate("/Home/home.html", [
            "dsthe" => $dsthe,
            "dsghichu" => $dsghichu,
            "currentghichu" => $infoghichunew,
            "ghichuactive" => $ghichunew,
            "dscurrentghichuthe" => $dsthecurrentghichu

        ]);
    }
    public function newnoteAction()
    {
        $ghichunew  = GhiChu::ThemGhiChu($_SESSION[Config::SESSION_REMEMBER_USER_ID]);
        //echo var_dump($ghichunew);
        echo json_encode(GhiChu::getGhiChuById($ghichunew->ghichuid));
    }
    public function updatenoteAction()
    {
        $model = array();
        $model['maghichu'] = $_POST["myGCid"];
        $model['user_id'] = $_SESSION[Config::SESSION_REMEMBER_USER_ID];
        $model['iconghichu'] = $_POST["myGCicon"];
        $model['tieudeghichu'] = $_POST["myTitle"];
        $model['ndghichu'] = $_POST["myDoc"];
        $model['trangthai'] = 1;
        //var_dump($model);
        $modelGC = new GhiChu($model);
        $dsthe = $_POST["dsthe"];
        $idghichu = $modelGC->ThemSuaGhiChu();
        if ($_POST["myGCid"] == 0) {
            TheGhiChu::XoaTheGhiChu($idghichu);
            TheGhiChu::SuaTheGhiChu($idghichu, $dsthe);
        } else {
            TheGhiChu::XoaTheGhiChu($_POST["myGCid"]);
            TheGhiChu::SuaTheGhiChu($_POST["myGCid"], $dsthe);
        }
        echo $idghichu;
    }
    public function deletenoteAction()
    {
        //check user note
        $maghichu = $_GET["currentmaghichu"];
        GhiChu::XoaGhiChu($maghichu);
    }
    public function searchtitleAction()
    {
        $name = $_GET["name"];
        $maghichu = $_GET["currentmaghichu"];
        $dstk = GhiChu::findByTitle($_SESSION[Config::SESSION_REMEMBER_USER_ID], $name);
        $taothea = "";
        foreach ($dstk as $key => $value) {
            if ($value["maghichu"] == $maghichu) {
                $magc = $value["maghichu"];
                $tieudeghichu = $value["tieudeghichu"];
                $iconghichu = $value["iconghichu"];
                $taothea = $taothea . "<div id= 'ghichu$magc' class= 'active' onclick='load_ajax_ghichu($magc);' >$iconghichu $tieudeghichu</div>";
            } else {
                $magc = $value["maghichu"];
                $tieudeghichu = $value["tieudeghichu"];
                $iconghichu = $value["iconghichu"];
                $taothea = $taothea . "<div id= 'ghichu$magc' onclick='load_ajax_ghichu($magc);'>$iconghichu $tieudeghichu</div>";
            }
        }
        echo $taothea;
    }
    public function themtheAction()
    {
        $name = trim($_GET["name"]);
        $the = The::CheckTenThe($_SESSION[Config::SESSION_REMEMBER_USER_ID], $name);
        if ($the) {
            echo 1;
        } else {
            $newthe = The::ThemThe($_SESSION[Config::SESSION_REMEMBER_USER_ID], $name);

            echo json_encode($newthe);
        }
    }
    public function searchtheAction()
    {
        //var_dump($_POST["tkdsthe"]);
        if(sizeof($_POST["tkdsthe"])==1&&$_POST["tkdsthe"][0]==0){
            $dsghichu = GhiChu::ghichuKoThe($_SESSION[Config::SESSION_REMEMBER_USER_ID]);
        }else{
            $dsghichu = GhiChu::findByThes($_SESSION[Config::SESSION_REMEMBER_USER_ID], $_POST["tkdsthe"]);
        }
        
        $maghichu = $_POST["currentmaghichu"];
        $taothea = "";
        foreach ($dsghichu as $key => $value) {
            if ($value["maghichu"] == $maghichu) {
                $magc = $value["maghichu"];
                $tieudeghichu = $value["tieudeghichu"];
                $iconghichu = $value["iconghichu"];
                $taothea = $taothea . "<div id= 'ghichu$magc' class= 'active' onclick='load_ajax_ghichu($magc);' >$iconghichu $tieudeghichu</div>";
            } else {
                $magc = $value["maghichu"];
                $tieudeghichu = $value["tieudeghichu"];
                $iconghichu = $value["iconghichu"];
                $taothea = $taothea . "<div id= 'ghichu$magc' onclick='load_ajax_ghichu($magc);' >$iconghichu $tieudeghichu</div>";
            }
        }
        echo $taothea;
    }
    public function ghichuAction()
    {
        $maghichu = $_GET["maghichu"];
        if (GhiChu::isUserNote($_SESSION[Config::SESSION_REMEMBER_USER_ID], $maghichu)) {
            $infoghichu = GhiChu::getGhiChuById($maghichu);
            echo json_encode($infoghichu);
        } else {
            echo 1;
        }
    }

    public function theghichuAction()
    {
        $maghichu = $_GET["maghichu"];
        $theghichu = TheGhiChu::dsThecuaGhiChu($maghichu);
        $dsthe = The::findThesById($_SESSION[Config::SESSION_REMEMBER_USER_ID]);
        $theoption = "<select class='selectpicker dscuathe' multiple data-live-search= true name='dsthe[]' title='Lựa chọn thẻ cho ghi chú của bạn' id='dscuathe'>";

        foreach ($dsthe as $key => $value) {
            $mathe = $value["mathe"];
            $tenthe = $value["tenthe"];
            if ($this->checkinlist($theghichu, $value["mathe"])) {

                $theoption = $theoption . "<option value = $mathe selected>$tenthe</option>";
            } else {
                $theoption = $theoption . "<option value = $mathe>$tenthe</option>";
            }
        }
        $theoption = $theoption . "</select>";
        echo $theoption;
    }

    public function theghichutkAction()
    {
        $dsthe = The::findThesById($_SESSION[Config::SESSION_REMEMBER_USER_ID]);
        $theoption = "<select class='selectpicker dscuathetk' multiple data-live-search= true name='tkdsthe[]' title='chon the de tim kiem' id='dscuathetk'>";

        foreach ($dsthe as $key => $value) {
            $mathe = $value["mathe"];
            $tenthe = $value["tenthe"];
            $theoption = $theoption . "<option value = $mathe>$tenthe</option>";
        }
        $theoption = $theoption . "</select>";
        echo $theoption;
    }
    protected function checkinlist($theghichu, $mathe)
    {
        foreach ($theghichu as $key => $value) {
            if ($mathe == $value["mathe"]) {
                return true;
            }
        }
        return false;
    }
    public function suatheAction()
    {
        $mathe = $_GET["mathe"];
        $name = trim($_GET["name"]);
        $the = The::CheckTenThe($_SESSION[Config::SESSION_REMEMBER_USER_ID], $name);
        if ($the) {
            echo 1;
        } else {
            $suathe = The::SuaThe($mathe, $name);

            echo 2;
        }
    }
    public function xoatheAction()
    {
        $mathe = $_GET["mathe"];
        TheGhiChu::XoaGhiChuThe($mathe);
        The::XoaThe($mathe);
        echo 1;
    }
}

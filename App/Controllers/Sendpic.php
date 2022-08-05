<?php
namespace App\Controllers;

class Sendpic extends \Core\Controller{

    public function sendAction(){
        $name = $_GET['name'];
        $file = getcwd().'/img/avatar/'.$name;
        $fileData = exif_read_data($file);
 
        // (B) OUTPUT HTTP HEADERS
        header("Content-Type: " . $fileData["MimeType"]);
        header("Content-Length: " . $fileData["FileSize"]);
 
        // (C) READ FILE
        readfile($file);
    }
}
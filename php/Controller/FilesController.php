<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FilesController extends ControllerBase {

    public $MaxRes = 2;

    //put your code here
    //echo SetControllers::$Id;
    function Index_Action() {


        $res = null;

        if ($this->Id_int < 0) {
            header('Location: /');
            exit();
        }

        if (isset($_SESSION['Id'])) {

            $Files = new files();
            $res['files'] = $Files->getUserFiles();
        }

        //

        $this->View($res);
    }

    function NewFile_Action() {
        
        $this->IsLogin();
        
        $this->View();
        
        
    }

    function NewFileSet_Action() {

        $this->IsLogin();

        $arr[] = 'file_name';
        $arr[] = 'description';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsStrMin($_POST['file_name'], 4, 'file_name');
        $F->IsStrMin($_POST['description'], 5, 'description');

        if (F_Help::$E == null) {

            $Files = new files();
            $res['files'] = $Files->createNewFile($_POST['file_name'], $_POST['description']);
        }

        $res['e'] = F_Help::$E['name'] = "fdfsd";
        $res = json_encode($res);

        echo $res;
        //createNewFile
    }

    private function IsLogin() {

        if (!isset($_SESSION['Id'])) {
            header('Location: /');
            exit();
        }
    }

}

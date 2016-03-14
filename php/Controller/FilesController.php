<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FilesController extends ControllerBase {

    public $MaxRes = 5;

    //put your code here
    //echo SetControllers::$Id;
    function Index_Action() {

        $res = '';

        if ($this->UserId) {

            $this->IsPositiveId();
            $Files = new FilesT();
            $res = $Files->getUserFilesPage($this->UserId, $this->Id_int, $this->MaxRes);
            $res['url'] = '/Files/Index/';
        }

        $this->View($res);
    }

    function UserFiles_Action() {

        $this->IsUserLogin();
        $this->IsPositiveId();

        $Files = new FilesT();
        $res['files'] = $Files->getUserFilesAll($this->UserId);

        $this->View($res);
    }

    function NewFile_Action() {

        $this->IsUserLogin();
        $this->View();
    }

    function FileEdit_Action() {
        $this->IsUserLogin();
        $this->IsPositiveId();

        $Files = new FilesT();
        $res = $Files->getUserFile($this->UserId, $this->Id_int);

        if (!$res) {
            header('Location: /');
            exit();
        }

        $this->View($res);
    }

    function FileEditSet_Action() {

        $this->IsUserLogin();

        $arr[] = 'file_name';
        $arr[] = 'description';
        $arr[] = 'id';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsStrMinNax($_POST['file_name'], 5, 32, 'file_name');
        $F->IsStrMin($_POST['description'], 5, 'description');

        if (F_Help::$E == null) {
            $Files = new FilesT();
            $Is = $Files->getUserFile($this->UserId, $_POST['id']);
            if (!$Is) {
                F_Help::$E['error'] = 'No such file or the file is not yours !!!';
            } else {
                
                $Files->FileEdit($this->UserId, $_POST['id'], $_POST['file_name'], $_POST['description']);                
            }
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

    function NewFileSet_Action() {

        $this->IsUserLogin();

        $arr[] = 'file_name';
        $arr[] = 'description';
        $arr[] = 'comments';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsStrMinNax($_POST['file_name'], 5, 32, 'file_name');
        $F->IsStrMin($_POST['description'], 5, 'description');
        $F->IsStrMinNax($_POST['comments'], 3, 64, 'comments');

        if (isset($_FILES['File'])) {

            $F->IsValidFile($_FILES['File'], 'File', 0.5 * 1024 * 1024);
        } else {
            F_Help::$E['File'] = 'Set File !!!';
        }

        if (F_Help::$E == null) {

            $Files = new FilesT();
            $Files->createNewFile($this->UserId, $_POST['file_name'], $_POST['description'], $_POST['comments'], $_FILES['File']['tmp_name']);
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
        //createNewFile
    }

    function FileDelete_Action() {

        $this->IsUserLogin();

        $arr[] = 'id';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $Files = new FilesT();
        $Is = $Files->getUserFile($this->UserId, $_POST['id']);
        if (!$Is) {
            F_Help::$E['e'] = 'No such file or the file is not yours !!!';
        } else {

//delere nodell
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }
    
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RevisionController extends ControllerBase {

    public $MaxRes = 10;

    //put your code here
    //echo SetControllers::$Id;
    function Index_Action() {

        $this->IsUserLogin();
        $this->IsPositiveId();
        $this->IsPositiveId2();

        $Files = new FilesT();
        $file = $Files->getUserFile($this->UserId, $this->Id_int);

        if (!$file) {
            header('Location: /');
            exit();
        }

        $Revision = new Revision();
        $res = $Revision->getAllFileRevision($this->Id_int, $this->Id2_int, $this->MaxRes);
        $res['file'] = $file;

        $res['url'] = '/Revision/Index/' . $this->Id_int . '/';

        $this->View($res);
    }

    function NewFile_Action() {
        $this->IsUserLogin();
        $this->IsPositiveId();

        $Files = new FilesT();
        $file = $Files->getUserFile($this->UserId, $this->Id_int);

        if (!$file) {
            header('Location: /');
            exit();
        }

        $this->View($file);
    }

    function NewFileSet_Action() {
        $this->IsUserLogin();

        $arr[] = 'id';
        $arr[] = 'comments';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsStrMinNax($_POST['comments'], 3, 64, 'comments');

        if (isset($_FILES['File'])) {

            $F->IsValidFile($_FILES['File'], 'File', 0.5 * 1024 * 1024);
        } else {
            F_Help::$E['File'] = 'Set File !!!';
        }

        if (F_Help::$E == null) {

            $Files = new FilesT();
            $file = $Files->getUserFile($this->UserId, $_POST['id']);
            if (!$file) {
                F_Help::$E['error'] = 'No such file or the file is not yours !!!';
            } else {

                $Revision = new Revision();
                $Revision->setNewFileRevision($this->UserId, $_POST['id'], $_POST['comments'], $_FILES['File']['tmp_name']);
            }
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

    function GetFile_Action() {
        $this->IsUserLogin();
        $this->IsPositiveId();

        $Revision = new Revision();
        $file = $Revision->getRevisionFile($this->UserId, $this->Id_int);
        if (!$file) {
            header('Location: /');
            exit();
        }

        $FilesT = new FilesT();
        $FileData = $FilesT->getFileData($this->UserId, $file->id);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');

        echo $FileData;
    }

    function GetFileInfo_Action() {
        $this->IsUserLogin();
        $this->IsPositiveId();

        $Revision = new Revision();
        $file = $Revision->getRevisionFile($this->UserId, $this->Id_int);
        if (!$file) {
            header('Location: /');
            exit();
        }

        $FilesT = new FilesT();
        $FileData = $FilesT->getFileData($this->UserId, $file->id);


        ob_start();
        highlight_string($FileData);
        $FileData = ob_get_contents();
        htmlspecialchars($string);
        ob_end_clean();
        //echo $FileData;
        $this->View($FileData);
    }

    function FileEdit_Action() {
        $this->IsUserLogin();
        $this->IsPositiveId();

        $Revision = new Revision();
        $file = $Revision->getRevisionFile($this->UserId, $this->Id_int);
        if (!$file) {
            header('Location: /');
            exit();
        }

        $FilesT = new FilesT();
        $res['id'] = $this->Id_int;
        $res['file_id'] = $file->file_id;
        $res['comments'] = $file->comments;

        $res['FileData'] = $FilesT->getFileData($this->UserId, $file->id);

        $this->View($res);
    }

    function FileEditSet_Action() {

        $this->IsUserLogin();

        $arr[] = 'id';
        $arr[] = 'file';
        $arr[] = 'comments';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsStrMinNax($_POST['comments'], 3, 64, 'comments');

        if (F_Help::$E == null) {

            $Revision = new Revision();
            $file = $Revision->getRevisionFile($this->UserId, $_POST['id']);
            if (!$file) {
                F_Help::$E['error'] = 'No such file or the file is not yours !!!';
            } else {

                $revId = $Revision->RevisionUpdate($file->file_id, $_POST['comments']);

                $FilesT = new FilesT();
                $FilesT->writeFile($this->UserId, $revId, $_POST['file']);
            }
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

    function FileDelete_Action() {

        $this->IsUserLogin();

        $arr[] = 'id';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $Revision = new Revision();
        $file = $Revision->getRevisionFile($this->UserId, $_POST['id']);
        if (!$file) {
            F_Help::$E['e'] = 'No such file or the file is not yours !!!';
        } else {

//delere nodell
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

}

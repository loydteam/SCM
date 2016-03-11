<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RevisionController extends ControllerBase {

    public $MaxRes = 2;

    //put your code here
    //echo SetControllers::$Id;
    function Index_Action() {

        //echo 'dfgdfg';
        $this->View();
    }

    function getFileRevisions_Action() {

        if ($this->Id_int < 0) {
            header('Location: /');
            exit();
        }

        $Files = new files();
        $res['FileRevisions'] = $Files->getFileRevisions($this->Id_int);
        
        $this->View($res);
        echo 'test';
        //getFileRevisions
    }

    private function IsLogin() {

        if (!isset($_SESSION['Id'])) {
            header('Location: /');
            exit();
        }
    }

}

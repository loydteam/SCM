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

        //$this->IsLogin();
        
        if ($this->Id_int < 0) {
            header('Location: /');
            exit();
        }

        $Files = new files();
        $res['FileRevisions'] = $Files->getFileRevisions($this->Id_int);
        
        //var_dump($res);
        //echo 'test';
        
        $this->View($res);
        
        //getFileRevisions
    }

    function GetDiscName_Action() {
        
        //var_dump('echo');
         $this->View();
    }
    
    private function IsLogin() {

        if (!isset($_SESSION['Id'])) {
            header('Location: /');
            exit();
        }
    }

}

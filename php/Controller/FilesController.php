<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FilesController extends ControllerBase {

    //put your code here
    //echo SetControllers::$Id;
    function Index_Action() {
        
        
        $this->View();
    }

    function FileList_Action() {

        
        $fileList = new files;
        $res['data'] = $fileList->getUserFiles();
        
        $res['id'] = $this->Id_int;
        
        $this->TPL_Action = 'FileList';
        $this->View($res);
    }

    function Revisions_Action() {
        
        //echo $this->Id_int;
        $res['id'] = $this->Id_int;
        
        
        $this->View($res);
    }
    
    function Test_Action() {

        echo 'Test_Action';

        $this->View();
    }

}

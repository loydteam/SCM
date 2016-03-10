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
            
        $fileList = new files ;
        $res=$fileList->getUserFiles();
        
        $this->View($res);
        
    }

    function Test_Action() {
            
        echo 'Test_Action';
        
        $this->View();
        
    }

    
}

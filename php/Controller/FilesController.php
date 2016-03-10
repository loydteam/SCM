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
            
        $arr['qwe'] = 'qwe';
        $arr['433'] = 'qwe';
        $arr['232'] = 'qwe';
        
        $this->View($arr);
        
    }

    function Test_Action() {
            
        echo 'Test_Action';
        
        $this->View();
        
    }

    
}

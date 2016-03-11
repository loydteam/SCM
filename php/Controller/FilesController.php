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
                        
            //var_dump($res);
        }
        
        //

        $this->View($res);
    }

    function NewFile_Action() {

  
        $this->View();
    }
    
    function EditFile_Action() {
        
        $this->View();
    }
    
   

}

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

        $this->View();
    }
    
    function NewFileSet_Action() {
        
        if (!isset($_SESSION['Id'])) {
            header('Location: /');
            exit();
        }

        $arr[] = 'file_name';
        $arr[] = 'description';

        $F = new F_Help();
        
        if (!$F->IsOllPostSet($arr)) {
            return;
        }
        
        $F->IsStrMin($_POST['file_name'], 3, 'file_name');
        $F->IsStrMin($_POST['description'], 3, 'description');
        
        if (F_Help::$E == null) {
            
            $Files = new files();
            $res['files'] = $Files->createNewFile('fileName','asdasd asdasd asdasd');
        }
        
        $res['e'] = F_Help::$E['name'] = "fdfsd";
        $res = json_encode($res);


        echo $res;
        //createNewFile
    }

    
   

}

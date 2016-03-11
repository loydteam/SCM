<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RepositoriController extends ControllerBase {

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

            $res['UserId'] = $_SESSION['Id'];

            $Repositori = new Repositories();
            $res = $Repositori->UserGetRepositories($_SESSION['Id'], $this->Id_int, $this->MaxRes);

            $res['url'] = '/Repositori/Index/';
        }

        $this->View($res);
    }

    function NewOrEditc() {

        if (!isset($_SESSION['Id'])) {
            header('Location: /');
            exit();
        }

        if ($this->Id_int < 0) {
            header('Location: /');
            exit();
        }

        if ($this->Id_int == 0) {
            $res['Repositori'] = new Repositori();
        } else {
            $Repositories = new Repositories();
            $res = $Repositories->ReposiInfo($this->Id_int, $_SESSION['Id']);

            if (!$res['Repositori']) {
                header('Location: /');
                exit();
            }
        }

        $this->View($res);
    }
    
    function NewOrEditPost_Action() {
        
    }
    
    function ReposiFiles_Action() {
        
        
    }

}

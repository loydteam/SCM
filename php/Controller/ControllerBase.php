<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerBase
 *
 * @author Prog1
 */
class ControllerBase {

    //put your code here

    public $TPL_Base = 'index';
    public $TPL_Action = null;
    private $Controler;
    private $Action;
    public $Id;
    public $Id_int;
    public $Id2;
    public $Id2_int;
    public $AllowingGET = array('s', 'so', 'ob', 'o', 'i');
    public $GETurl;
    public $GET;
    public $UserId = 0;

    private $POSTintSet = array('id');
            
    function ControllerBase($arrParam = null) {

        if (isset($_SESSION['Id'])) {
            $this->UserId = $_SESSION['Id'];
        }

        $this->setAllowingGET();
        $this->SetGetI();
        $this->POSTintSet();
        
        if ($arrParam != null) {

            for ($i = 0; $i < 4; $i++) {
                settype($arrParam[$i], 'string');
            }

            $this->Controler = $arrParam[0];
            $this->Action = $arrParam[1];
            $this->Id = $arrParam[2];
            $this->Id2 = $arrParam[3];

            $this->TPL_Base = null;
            //----------------------
        } else {

            $this->Controler = SetControllers::$Controler;
            $this->Action = SetControllers::$Action;
            $this->Id = SetControllers::$Id;
            $this->Id2 = SetControllers::$Id2;
        }

        $this->Id_int = $this->Id;
        settype($this->Id_int, "int");

        $this->Id2_int = $this->Id2;
        settype($this->Id2_int, "int");

        $var = ucfirst($this->Action) . '_Action';
        if (method_exists($this, $var)) {

            $this->SetActionInOllOs();
            $this->$var();
        } else {

            $this->Index_Action();
        }
    }

    function View($Args = null) {


        if ($this->TPL_Action != null) {
            $Action = $this->TPL_Action;
        } else {
            $Action = $this->Action;
        }

        $controller = str_replace("Controller", "", $this->Controler);
        $url = View_DIR . $controller . '/' . $Action . '.php';

        //echo $url;
        //file_exists
        if (is_file($url)) {

            ob_start();
            require $url;
            $ob_TPL_Sub = ob_get_contents();
            ob_end_clean();
        }

        if ($this->TPL_Base != null) {

            ob_start();
            require_once View_DIR . 'Base/' . $this->TPL_Base . '.php';
            $ob_TPL_Base = ob_get_contents();
            ob_end_clean();

            echo $ob_TPL_Base;
        } elseif (isset($ob_TPL_Sub)) {

            echo $ob_TPL_Sub;
        }
    }

    function Index_Action() {
        exit();
        //echo 'Index_Action base';
    }

    function IsUserLogin() {
        if (!$this->UserId) {
            header('Location: /');
            exit();
        }
    }

    function IsPositiveId() {
        if ($this->Id_int < 0) {
            header('Location: /');
            exit();
        }
    }

    function IsPositiveId2() {
        if ($this->Id2_int < 0) {
            header('Location: /');
            exit();
        }
    }
        
    function SetGetI() {
        
        settype($_GET['i'], 'string');
        $arr = explode(',', $_GET['i']);
        
        for ($i = 0; $i < 3; $i++) {
            
            settype($arr[$i], 'int');
            $this->GET['i'][$i] = $arr[$i];
        }
                
    }
    
        
    private function SetActionInOllOs() {

        $methods = get_class_methods($this);

        $serch = array_flip($methods);
        $serch = array_change_key_case($serch, CASE_LOWER);
        $key = $this->Action . '_action';
        if (array_key_exists($key, $serch)) {

            $Action = $methods[$serch[$key]];
            $Action = str_replace("_Action", "", $Action);
            $this->Action = $Action;
        }
    }

    private function setAllowingGET() {

        $this->GETurl = "";
        foreach ($_GET as $key => $val) {
            if (!in_array($key, $this->AllowingGET) || mb_strlen($val) == 0) {
                unset($_GET[$key]);
            } else {

                $_GET[$key] = strip_tags($val);

                if ($this->GETurl == "") {

                    $this->GETurl = "?" . $key . "=" . strip_tags($val);
                } else {

                    $this->GETurl .= "&" . $key . "=" . strip_tags($val);
                }
            }
        }
    }

    private function POSTintSet() {
        
        foreach ($_POST as $key => $val) {
            if (in_array(strtolower($key), $this->POSTintSet)) {
                settype($_POST[$key], 'int');
            }
        }
    }
}

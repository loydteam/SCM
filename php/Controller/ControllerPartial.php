<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerPartial
 *
 * @author Prog1
 */
class ControllerPartial {
    //put your code here
    
    static function Get($param) {
        
        $arrParam = explode("/", $param);
        for ($i = 0; $i < 3; $i++) {
            settype($arrParam[$i], "string");            
            $arrParam[$i] = strtolower($arrParam[$i]);
        }
        
        $arrCont = SetControllers::$Arr_Controlers;
        
        if (!array_key_exists($arrParam[0], $arrCont)) {
            $arrParam[0] = SetControllers::$DefaltControler;
        } else {
            $arrParam[0] = $arrCont[$arrParam[0]];
        }
        
        $class = $arrParam[0];
        new $class($arrParam);
        
    }
    
}

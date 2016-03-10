<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SetControler
 *
 * @author Prog1
 */
class SetControllers {
    //put your code here
    
    static public $ArrUrl;
     
    static public $Key_Controler = 1;
    static public $Key_Action = 2;
    static public $Key_Id = 3;
    static public $Key_Id2 = 4;
      
    static public $Controler;
    static public $Action;
    static public $Id;
    static public $Id2;
    
    static public $Arr_Controlers;
            
    static public $ControlersAssociation;
    static public $DefaltControler;    
    
    function SetControllers(){
        
        $arr = explode("/", REQUEST_URI);
                
        for ($i = 0; $i < 5; $i++) {
            settype($arr[$i], "string");            
            $arr[$i] = strtolower($arr[$i]);
        }
        
        $arr_ass = $this->ControlersAssociation();
        self::$Arr_Controlers = $arr_ass; 
        
        if (!array_key_exists($arr[self::$Key_Controler], $arr_ass)) {
            $arr[self::$Key_Controler] = self::$DefaltControler;
        } else {
            $arr[self::$Key_Controler] = $arr_ass[$arr[self::$Key_Controler]];
        }
        
        if (3 > mb_strlen($arr[self::$Key_Action])) {
            $arr[self::$Key_Action] = 'index';
        }
              
        self::$Controler = $arr[self::$Key_Controler];
        self::$Action = $arr[self::$Key_Action];
        self::$Id = $arr[self::$Key_Id];
        self::$Id2 = $arr[self::$Key_Id2];
        
        self::$ArrUrl = $arr;
        
        $class = $arr[self::$Key_Controler];
        
        new $class();
        
        //var_dump($arr[self::$Key_Controler]);
        
    }
    
    private function ControlersAssociation(){
        
        return self::$ControlersAssociation;
    }
    
    
}

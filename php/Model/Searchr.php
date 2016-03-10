<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Searchr
 *
 * @author root
 */
class Searchr {
    //put your code here
    
    
    public function isProductsSearchrGetOk($so) {
        
        if (!isset($_GET['s']) || !isset($_GET['so'])) {            
            return false;
        }
                
        $arr = array_flip($so);
        $arr = array_change_key_case($arr, CASE_LOWER);
        
        $key = strtolower($_GET['so']);
        if (!array_key_exists($key, $arr)) {
            return false;
        }
        $_GET['so'] = $so[$arr[$key]];
        
        return true;
        
    }
    

}

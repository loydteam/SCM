<?php

function __autoload($class_name) {

    
    $dirs_array[''] = '';
    if(array_key_exists($class_name, $dirs_array)){
            $plas_dir = $dirs_array[$class_name];
    }else{
            $plas_dir = '';
    }

    if (count(explode("Controller", $class_name)) > 1) {
        
        require_once Controller_DIR.$plas_dir.$class_name.'.php';
        
    } else {
        
        require_once Model_DIR.$plas_dir.$class_name.'.php';
    }
        
}

SetControllers::$ControlersAssociation = $Controlers;
unset($Controlers);
SetControllers::$DefaltControler = $DefaltControler;
unset($DefaltControler);


session_start();

header('Content-Type: text/html; charset='.$Charset); 

//$dbConect = new SQL_Conect($DbConf['schop']);
//$dbConect = 
$dbConect = new SQL_Conect_PDO();


//$DbConf[]='';
$DbConf['host']= 'localhost';
$DbConf['db_name']= 'SCM';
$DbConf['db_user']= 'root';
$DbConf['db_password']= '';
$dbConect->Conect_Start($DbConf);

new SetControllers();


?>
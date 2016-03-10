<?php

class files {
    public $user_id = '';
    
    
    
    function __construct() {
        $this->user_id= isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
    }
    
    public function getUserFiles(){
        
        $db = new SQL_Conect_PDO();
        $sql = "SELECT * FROM `user_files` WHERE `user_id` =3";//. $this->user_id;
        $db->SetQuery($sql);    
        $res = $db->GetQueryAll_Class();
        return $res;
        
    }
    
       public function getFileRevisions($file_id=1){
        
        $db = new SQL_Conect_PDO();
        $sql = "SELECT * FROM `revision` WHERE `file_id` =". $file_id;
        $db->SetQuery($sql);    
        $res = $db->GetQueryAll_Class();
        return $res;
        
    }
    
}

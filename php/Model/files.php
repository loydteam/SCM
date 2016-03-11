<?php

class files {

    public $user_id = '';

    function __construct() {
        $this->user_id = isset($_SESSION['Id']) ? $_SESSION['Id'] : NULL;
    }

    public function getUserFiles() {

        $ArrPars['Id'] = $this->user_id;

        $db = new SQL_Conect_PDO();
        $sql = "SELECT * FROM `user_files` WHERE `user_id` = :Id";
        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryAll_Class();
        return $res;
    }

    public function getFileRevisions($file_id) {

        if (isset($file_id)) {
            $ArrPars['file_id'] = $file_id;
            $db = new SQL_Conect_PDO();
            $sql = "SELECT revision.*, user_files.file_name FROM `revision`
                LEFT JOIN `user_files` 
                ON revision.file_id=user_files.id 
                WHERE file_id=:file_id";
            $db->SetQuery($sql, $ArrPars);
            $res = $db->GetQueryAll_Class();
            
        } else {
            $error='cant obtain file id';
            $res=(object)$error;
        }
        return $res;
    }

    public function getFileDiskName($fileRevision_id) {
        
        if (isset($fileRevision_id)) {
                    
        $ArrPars['fileRevision_id'] = $fileRevision_id;
        $db = new SQL_Conect_PDO();
        $sql = "SELECT revision.*, user_files.file_name, user_files.id AS dir_id FROM `revision`
                LEFT JOIN `user_files` 
                ON revision.file_id=user_files.id 
                WHERE id=:fileRevision_id LIMIT 1";
        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOneAssoc();
        $result=PUB_DIR_FILES.$res['dir_id'].'/'.$res['id'].'.txt';        
        } else {
            $result='cant obtain file revision id';
            
        }
        
        return (object)$result;
    }
    
    
     public function createNewFile($fileName,$description) {
         $ArrPars['fileName'] = $fileName;
         $ArrPars['description'] = $description;
         $ArrPars['Id'] = $this->user_id;
        $db = new SQL_Conect_PDO();
        $sql = "INSERT INTO `scm`.`user_files` "
                . "(`user_id`, `file_name`, `description`) "
                . "VALUES ( :Id, :fileName, :description)";
        $db->SetQuery($sql, $ArrPars);
        $inserted_id=$db->getLastInsertId();
        
        unset ($ArrPars);
        $ArrPars['file_id']=$inserted_id;
        $sql = "INSERT INTO `scm`.`revision` "
                . "(`file_id`, `version`, `comments`) "
                . "VALUES ( :file_id, '1', 'creating file')";
        $db->SetQuery($sql, $ArrPars);
        $revision_id=$db->getLastInsertId();
        mkdir(PUB_DIR_FILES.$inserted_id, 0700);
        $myfile = fopen(PUB_DIR_FILES.$inserted_id.'/'.$revision_id.".txt", "w"); 
        
        
     }
    

}

<?php

class files {

    public $user_id = '';

    function __construct() {
        $this->user_id = isset($_SESSION['id']) ? $_SESSION['id'] : NULL;
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

}

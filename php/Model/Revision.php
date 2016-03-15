<?php

class Revision {
    //put your code here
    
    function getAllFileRevision($file_id, $Page, $MaxRes) {
        
        $db = new SQL_Conect_PDO();

        $ArrPars['file_id'] = $file_id;
        
        $sql = "SELECT COUNT(`id`) "
                . "FROM `revision` "
                . "WHERE `file_id` = :file_id ";

        $db->SetQuery($sql, $ArrPars);
        $res['Count'] = $db->GetQueryCount();

        if (!$res['Count']) {
            return false;
        }

        //$Page, $MaxPages, $AllRes
        $arr = $db->SqlLimit($Page, $MaxRes, $res['Count']);
        $res['Page'] = $arr['Page'];
        $res['Pages'] = $arr['Pages'];

        $sql = "SELECT * "
                . "FROM `revision` "
                . "WHERE `file_id` = :file_id "
                . "ORDER BY `version` DESC "
                . $arr["SQL"];

        $db->SetQuery($sql, $ArrPars);
        $res['revision'] = $db->GetQueryAll_Class();

        return $res;
        
    }
        
    function getLastRevisionFile($file_id) {
        
        $db = new SQL_Conect_PDO();
        
        $sql = "SELECT * FROM `revision` "
                . "WHERE `file_id` = :file_id "
                . "ORDER BY `version` DESC "
                . "LIMIT 1;";
        
        $ArrPars['file_id'] = $file_id;

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOne_Class();
        return $res;
        
    }
    
    function setNewFileRevision($UserId, $file_id, $comments, $FileUrl) {
                
        $res = $this->getLastRevisionFile($file_id);
        
        $FilesT =new FilesT();
        $revision_id = $FilesT->NevRevision($file_id, $comments, ++$res->version);
        
        if (!$revision_id) {
            return;
        }

        $File = $FilesT->getFileData(0, 0, $FileUrl);
        $FilesT->writeFile($UserId, $revision_id, $File);
        
    }
    
    function RevisionUpdate($file_id, $comments) {
        
               
        $ArrPars['file_id'] = $file_id;
        $db = new SQL_Conect_PDO();
        $sql = "SELECT MAX(version) FROM `revision` WHERE file_id=:file_id;";
        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOneAssoc();
        $ArrPars['version']=$res[0]+1;
         $ArrPars['comment']=$comments;
        
        $sql = "INSERT INTO `revision` "
                    . "(`file_id`, `version`, `comments`) "
                    . "VALUES ( :file_id, :version, :comment)";
        $db->SetQuery($sql, $ArrPars);
        
        $revision_id = $db->getLastInsertId();
        return $revision_id;

    }
    
    function getRevisionFile($UserId, $RevisionId){
        
        $db = new SQL_Conect_PDO();
        
        $sql = "SELECT r.*, f.`id` as file_id "
                . "FROM `revision` as r, `user_files` as f "
                . "WHERE r.`file_id` = f.`id` "
                . "AND r.`id` = :RevisionId "
                . "AND f.`user_id` = :UserId "
                . "LIMIT 1;";
        
        $ArrPars['UserId'] = $UserId;
        $ArrPars['RevisionId'] = $RevisionId;

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOne_Class();
        return $res;
                    
    }
    
    function deleteRevision ($userId, $revisionId ){

        $FileId = $this->getRevisionFile($userId,$revisionId)->file_id;

        $count = count((array)$this->getRevisionsOfFile($FileId));

        if ($count>1) {
        $db = new SQL_Conect_PDO();
        $sql = "DELETE FROM `revision` WHERE `revision`.`id` = :revisionId";
        
        $ArrPars['revisionId'] = $revisionId;
        $db->SetQuery($sql, $ArrPars);
        $db->GetQueryOne_Class();
         if ($db->getAffectedRowCount() > 0) {
             $dir = PUB_DIR_FILES . $userId.'/'.$revisionId.'.txt';
             unlink($dir);
         } else {
              F_Help::$E['error'] = 'Error deleting revision from DB';
         }
        
    } else {
            $file = new FilesT();
            $file -> deleteFileAndRevisions($userId, $FileId);
        }
    }
    
    function getRevisionsOfFile($FileId){
        
        $db = new SQL_Conect_PDO();
        
        $sql = "SELECT * "
                . "FROM `revision` "
                . "WHERE `file_id` = :FileId";
        
        $ArrPars['FileId'] = $FileId;

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryAll_Class();
        return $res;
                    
    }
    
}

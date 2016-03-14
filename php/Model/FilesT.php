<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FilesT
 *
 * @author root
 */
class FilesT {

    //put your code here

    function getUserFilesAll($UserId) {

        $db = new SQL_Conect_PDO();
        $sql = "SELECT * FROM `user_files` WHERE"
                . " `user_id` = :UserId "
                . "ORDER BY `file_name` ASC ";

        $ArrPars['UserId'] = $UserId;

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryAll_Class();

        return $res;
    }

    function getUserFilesPage($UserId, $Page, $MaxRes) {

        $db = new SQL_Conect_PDO();

        $ArrPars['UserId'] = $UserId;

        $sql = "SELECT COUNT(`id`) "
                . "FROM `user_files` "
                . "WHERE `user_id` = :UserId ";

        $db->SetQuery($sql, $ArrPars);
        $res['Count'] = $db->GetQueryCount();

        if (!$res['Count']) {
            return false;
        }

        //$Page, $MaxPages, $AllRes
        $arr = $db->SqlLimit($Page, $MaxRes, $res['Count']);
        $res['Page'] = $arr['Page'];
        $res['Pages'] = $arr['Pages'];

        $sql = "SELECT * FROM `user_files` WHERE "
                . " `user_id` = :UserId "
                . "ORDER BY `file_name` ASC "
                . $arr["SQL"];

        $db->SetQuery($sql, $ArrPars);
        $res['files'] = $db->GetQueryAll_Class();

        return $res;
    }

    function createNewFile($UserId, $file_name, $description, $comments, $FileUrl) {

        $db = new SQL_Conect_PDO();

        $sql = "INSERT INTO `user_files` (`id`, `user_id`, `file_name`, `description`) "
                . "VALUES (NULL, :UserId, :file_name, :description);";

        $ArrPars['UserId'] = $UserId;
        $ArrPars['file_name'] = strip_tags($file_name);
        $ArrPars['description'] = strip_tags($description);

        $db->SetQuery($sql, $ArrPars);

        $Id = $db->getLastInsertId();

        if (!$Id) {
            F_Help::$E['error'] = 'Error creating file in DB';
            return;
        }

        $revision_id = $this->NevRevision($Id, $comments);
        if (!$revision_id) {
            return;
        }

        $this->mkdirUser($UserId);
        $File = $this->getFileData(0, 0, $FileUrl);
        $this->writeFile($UserId, $revision_id, $File);
        
    }

    function NevRevision($file_id, $comments, $version = 1) {

        $db = new SQL_Conect_PDO();

        $ArrPars['file_id'] = $file_id;
        $ArrPars['comments'] = strip_tags($comments);
        $ArrPars['version'] = $version;
        
        $sql = "INSERT INTO `revision` "
                . "(`file_id`, `version`, `comments`) "
                . "VALUES ( :file_id, :version, :comments)";
        $db->SetQuery($sql, $ArrPars);
        $revision_id = $db->getLastInsertId();
        if (!$revision_id) {
            F_Help::$E['error'] = 'Error creating first revision in DB';
            return;
        }
        return $revision_id;
    }
    
    function getUserFile($UserId, $file_id) {
        
        $db = new SQL_Conect_PDO();
        
        $sql = "SELECT * FROM `user_files` "
                . "WHERE `id` = :file_id "
                . "AND `user_id` = :UserId "
                . "LIMIT 1;";
        
        $ArrPars['UserId'] = $UserId;
        $ArrPars['file_id'] = $file_id;

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOne_Class();
        return $res;
        
    }
    
    function mkdirUser($UserId) {

        $url = PUB_DIR_FILES . $UserId;

        if (!file_exists($url)) {
            mkdir(PUB_DIR_FILES . $UserId, 0700);
        }
    }

    function getFileData($UserId, $revision_id, $FileUrl = null) {
        
        if (!$FileUrl) {
            $FileUrl = PUB_DIR_FILES . $UserId.'/'.$revision_id.'.txt';
        }
        
        $data = file_get_contents($FileUrl); 
        return $data;
    }
    
    function writeFile($UserId, $revision_id, $txt) {
        
        $dir = PUB_DIR_FILES . $UserId.'/'.$revision_id.'.txt';
                
        @$bfh0 = fopen($dir, 'w+');
        @flock($bfh0, LOCK_EX);
        @ftruncate($bfh0, 0);
        @fwrite($bfh0, $txt);
        @flock($bfh0, LOCK_UN);
        @fclose($bfh0);
    }

    function FileEdit($UserId, $file_id, $file_name, $description) {
        
        $db = new SQL_Conect_PDO();

        $sql = "UPDATE `user_files` "
                . "SET `file_name` = :file_name, "
                . "`description` = :description "
                . "WHERE "
                . "`id` = :file_id "
                . "AND `user_id` = :UserId "
                . "LIMIT 1;";

        $ArrPars['UserId'] = $UserId;
        $ArrPars['file_id'] = $file_id;
        $ArrPars['file_name'] = strip_tags($file_name);
        $ArrPars['description'] = strip_tags($description);
        
        $db->SetQuery($sql, $ArrPars);
        
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Repositori
 *
 * @author root
 */
class Repositories {

    //put your code here

    function UserGetRepositories($Id, $Page, $MaxRes) {
        
        $db = new SQL_Conect_PDO();
        
        $ArrPars['Id'] = $Id;
        
        $sql = "SELECT COUNT(`Id`) "
                . "FROM `repositories` "
                . "WHERE `UserId` = :Id ";
  
        $db->SetQuery($sql, $ArrPars);                        
        $res['Count'] = $db->GetQueryCount();
        
        if (!$res['Count']) {            
            return false;
        }

        //$Page, $MaxPages, $AllRes
        $arr = $db->SqlLimit($Page, $MaxRes, $res['Count']);
        $res['Page'] = $arr['Page'];
        $res['Pages'] = $arr['Pages'];
        
        $sql = "SELECT * FROM `repositories` WHERE `UserId` = :Id "
                . $arr["SQL"];

        $db->SetQuery($sql, $ArrPars);
        $res['Repositori'] = $db->GetQueryAll_Class();

        return $res;
        
    }

    function ReposiInfo($Id, $UserId) {
        
        $db = new SQL_Conect_PDO();
        
        $sql = "SELECT * FROM `repositories` WHERE "
                . "`Id` = :Id "
                . "AND `UserId` = :UserId "
                . "LIMIT 1;";
        
        $db->SetQuery($sql, array('Id' => $Id, 'UserId' => $UserId));
        $res['Repositori'] = $db->GetQueryOne_Class('Repositori');
        
        return $res;
    }
}

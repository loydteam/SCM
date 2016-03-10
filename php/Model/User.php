<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author root
 */
class User {

    //put your code here

    static $User;
    public $Id, $Email, $Pass, $FirstName, $LastName;

    public function User() {
        
    }

    public function Login($email, $pass) {

        $F = new F_Help();

        $db = new SQL_Conect_PDO();
        $sql = "SELECT * FROM `users` WHERE `Email` = :email AND `Pass` = :pass LIMIT 1;";

        $ArrPars['email'] = strtolower($email);
        $ArrPars['pass'] = $F->GetHash($pass);

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOne_Class("User");

        if ($res) {
            self::$User = $res;
            $_SESSION['Id'] = $res->Id;

            return true;
        }

        return false;
    }

    public function Register($arr) {

        $db = new SQL_Conect_PDO();

        $sql = "INSERT INTO `users` SET "
                . "`Email` = :Email, "
                . "`Pass` = :Pass, "
                . "`FirstName` = :FirstName, "
                . "`LastName` = :LastName;";

        $F = new F_Help();

        $ArrPars['Email'] = strtolower($arr['Email']);
        $ArrPars['Pass'] = $F->GetHash($arr['Pass']);
        $ArrPars['FirstName'] = $F->strUpFirst($arr['FirstName']);
        $ArrPars['LastName'] = $F->strUpFirst($arr['LastName']);

        $db->SetQuery($sql, $ArrPars);

        $this->Login($arr['Email'], $arr['Pass']);

        //$F = new F_Help();
        //var_dump($ArrPars);
    }

    public function Edit($arr, $id, $IsAdmin = false) {

        //
        $db = new SQL_Conect_PDO();

        $IsPassNull = mb_strlen($arr['Pass']) > 0;

        $sql = "UPDATE `users` SET "
                . "`Email` = :Email, ";

        if ($IsPassNull) {
            $sql .= "`Pass` = :Pass, ";
        }

        if ($IsAdmin) {
            $sql .= "`Money` = :Money, "
                    . "`RightsAccess` = :RightsAccess, ";
        }
        
        $sql .= "`FirstName` = :FirstName, "
                . "`LastName` = :LastName "
                . "WHERE `Id` = :Id "
                . "LIMIT 1;";

        $F = new F_Help();

        $ArrPars['Id'] = $id;
        $ArrPars['Email'] = strtolower($arr['Email']);
        if ($IsPassNull) {
            $ArrPars['Pass'] = $F->GetHash($arr['Pass']);
        }
        if ($IsAdmin) {
            $ArrPars['Money'] = $arr['Money'];
            $ArrPars['RightsAccess'] = $arr['RightsAccess'];
        }
        $ArrPars['FirstName'] = $F->strUpFirst($arr['FirstName']);
        $ArrPars['LastName'] = $F->strUpFirst($arr['LastName']);

        $db->SetQuery($sql, $ArrPars);
    }

    public function IsUniqueUserEmail($email) {

        $db = new SQL_Conect_PDO();

        $sql = "SELECT `Id` FROM `users` WHERE `Email` = :email LIMIT 1;";
        $ArrPars['email'] = strtolower($email);

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOne_Class();

        if ($res) {
            return false;
        }

        return true;
    }

    public function Logout() {

        self::$User = null;
        session_unset();
    }

    public function setUserBySession() {

        if (!isset($_SESSION['Id'])) {
            return;
        }

        if (self::$User == NULL) {

            $res = $this->getUserInfoById($_SESSION['Id']);

            if ($res) {
                self::$User = $res;
                return self::$User;
            } else {
                $this->Logout();
                return null;
            }
        }
    }

    public function getUserInfoById($Id) {
        
        $db = new SQL_Conect_PDO();

        $sql = "SELECT * FROM `users` WHERE `Id` = :id LIMIT 1;";

        $ArrPars['id'] = $Id;

        $db->SetQuery($sql, $ArrPars);
        $res = $db->GetQueryOne_Class("User");
        
        return $res;
    }

    public function setUserMoney($Id, $Money) {

        $db = new SQL_Conect_PDO();
        $sql = "UPDATE `users` SET `Money` = `Money`+ :Money WHERE `Id` = :Id LIMIT 1;";

        $db->SetQuery($sql, array('Id' => $Id, 'Money' => $Money));
    }

}

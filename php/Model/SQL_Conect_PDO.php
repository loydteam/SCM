<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SQL_Conect_PDO
 *
 * @author Prog1
 */
class SQL_Conect_PDO {

    //put your code here

    public static $dbPDO;
    private $Query;

    public function Conect_Start($DbConf) {

        try {

            self::$dbPDO = new PDO("mysql:host=" . $DbConf['host'] . ";dbname=" . $DbConf['db_name'] . ";charset=" . $DbConf['db_encode'] . "", $DbConf['db_user'], $DbConf['db_password']);
        } catch (PDOException $e) {

            if (IsDebag) {
                echo "Error: " . $e;
            }
            exit();
        }
    }

    public function Conect_Stop() {
        self::$dbPDO = NULL;
        $this->Query_Stop();
    }
    
    function Query_Stop() {
        $this-> Query = NULL;
    }
    
    function SetQuery($sql, $ArrPars = null) {

        if (!$ArrPars){
            $ArrPars = array();
        }
        
        $this->Query = self::$dbPDO->prepare($sql);
        $this->Query->execute($ArrPars);
        
        //var_dump($this->Query);
    }
    
    function getLastInsertId() {
        
       return self::$dbPDO->lastInsertId();
    }
    
    function getAffectedRowCount(){

        return $this->Query->rowCount();
    }

    //PDOStatement
    function GetQueryOne_Class($Class = NULL) {

        if ($Class == NULL) {

            $res = $this->Query->fetch(PDO::FETCH_OBJ);
        } else {

            $this->Query->setFetchMode(PDO::FETCH_CLASS, $Class);
            $res = $this->Query->fetch(PDO::FETCH_CLASS);
        }

        $this->PDO_Erore($res);

        return $res;
    }

    function GetQueryAll_Class($Class = NULL) {

        if ($Class == NULL) {

            $res = $this->Query->fetchAll(PDO::FETCH_OBJ);
        } else {

            $res = $this->Query->fetchAll(PDO::FETCH_CLASS, $Class);
        }

        $this->PDO_Erore($res);

        return $res;
    }

    function GetQueryAllAssoc() {

        $res = $this->Query->fetchAll(PDO::FETCH_ASSOC);

        $this->PDO_Erore($res);

        return $res;
    }

    function GetQueryOneAssoc() {

        $res = $this->Query->fetch(PDO::FETCH_NUM);

        $this->PDO_Erore($res);

        return $res;
    }
    
    function GetQueryCount() {

        $res = $this->GetQueryOneAssoc();
        return $res[0];
    }

    function SqlLimit($Page, $MaxRes, $AllRes) {

        if ($Page == 0) {
            $Page++;
        }

        $Page--;

        settype($Page, 'int');
        settype($MaxRes, 'int');
        settype($AllRes, 'int');

        $Pages = ceil($AllRes / $MaxRes);

        if ($Page > $Pages - 1) {
            $Page = $Pages - 1;
            if ($Page <= 0) {
                $Page = 0;
            }
        }

        $arr['SQL'] = ' LIMIT ' . ($Page * $MaxRes) . ' , ' . $MaxRes . ';';
        $arr['Page'] = ++$Page;
        $arr['Pages'] = $Pages;

        return $arr;
    }

    function SqlGetInAndSetLimit($res) {
        
        $arr = array();
        foreach ($res as $val) {
            foreach ($val as $value) {
                $arr[] = $value;
            }
        }
        
        $sql = ' IN(' . implode(",", $arr) . ') ';
        $sql .= 'LIMIT ' . Count($arr) . ';';
        
        return $sql;
    }

    function getValidSqlSearchr($str, $fild_name, $arr_valid, $keys_num = null) {
        
        $arr_valid = array_flip($arr_valid);
        if (!array_key_exists($fild_name, $arr_valid)) {
            return '';
        }
        
        if ($keys_num != null) {
            
            if (array_key_exists($fild_name, $keys_num)) {
                
                if (!is_numeric($str)) {
                    return '';
                }
                
                $op = $keys_num[$fild_name];
                
                $sql_arr['s'] = "`$fild_name` $op :$fild_name ";
                $sql_arr['d'][$fild_name] = $str;
                return $sql_arr;
            }
        }
        
        $sql_arr['s'] = "`$fild_name` REGEXP(:$fild_name) ";
        $sql_arr['d'][$fild_name] = '.*'.$str.'.*';
        return $sql_arr;
    }
    
    private function PDO_Erore($res) {
        if (IsDebag) {
            
            $errorInfo = $this->Query->errorInfo();
            
            if ($errorInfo[1] != null) {

                print_r($this->Query->errorInfo());
                echo '<hr> errorCode: <br/>';
                print_r($this->Query->errorCode());

                /*
                  try {

                  throw new Exception("SQL Exception");

                  } catch (Exception $e) {

                  print_r($e);

                  } */
            }
        }
    }

}

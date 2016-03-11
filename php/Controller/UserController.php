<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Prog1
 */
class UserController extends ControllerBase {

    //put your code here

    function Index_Action() {
        //echo 'Index_Action';           
    }

    function MyProfile_Action() {

        if (!isset($_SESSION['Id'])) {

            header('Location: /');
            exit();
        }


        if (User::$User == NULL) {

            $user = new User();
            $user->setUserBySession();
        }

        $this->View();
    }

    function MyProfileEdit_Action() {

        if (!isset($_SESSION['Id'])) {

            header('Location: /');
            exit();
        }

        $arr[] = 'Email';
        $arr[] = 'Pass';
        $arr[] = 'Pass2';
        $arr[] = 'FirstName';
        $arr[] = 'LastName';
        $arr[] = 'g-recaptcha-response';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsValidEmail($_POST['Email'], 'Email');

        if (mb_strlen($_POST['Pass']) != 0 ||
                mb_strlen($_POST['Pass2']) != 0) {

            $F->IsValidPass($_POST['Pass'], 'Pass');
            $F->IsCompare($_POST['Pass'], $_POST['Pass2'], 'Pass2');
        }

        $F->IsStrMinNax($_POST['FirstName'], 3, 30, 'FirstName');
        $F->IsCtypeAlpha($_POST['FirstName'], 'FirstName');

        $F->IsStrMinNax($_POST['LastName'], 3, 30, 'LastName');
        $F->IsCtypeAlpha($_POST['LastName'], 'LastName');

        if (F_Help::$E == null) {
            $F->IsValidCaptcha($_POST['g-recaptcha-response']);
        }

        if (F_Help::$E == null) {

            $user = new User();
            if (User::$User == NULL) {
                $user = $user->setUserBySession();
            }

            if ($_POST['Email'] != $user->Email) {

                $IsUnique = $user->IsUniqueUserEmail($_POST['Email']);

                if (!$IsUnique) {

                    F_Help::$E['Email'] = "This login already exists !";
                }
            }

            if (F_Help::$E == null) {
                $user->Edit($_POST, $_SESSION['Id']);
            }
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

    function UserInfo_Action() {

        if (isset($_SESSION['Id'])) {

            if (User::$User == NULL) {

                $user = new User();
                $user->setUserBySession();
            }

            //var_dump(User::$User);

            $this->View();
                    
        } else {

            $this->TPL_Action = "Login";
            $this->View();
        }
    }

    function Login_Action() {

        $arr[] = 'Email';
        $arr[] = 'Pass';
        $arr[] = 'g-recaptcha-response';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsValidEmail($_POST['Email'], 'Email');
        $F->IsValidPass($_POST['Pass'], 'Pass');

        if (F_Help::$E == null) {
            $F->IsValidCaptcha($_POST['g-recaptcha-response']);
        }

        if (F_Help::$E == null) {
            $user = new User();
            $IsLogin = $user->Login($_POST['Email'], $_POST['Pass']);

            if (!$IsLogin) {
                F_Help::$E['Pass'] = "Incorrect login or password";
            }
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

    function Register_Action() {

        if (isset($_SESSION['Id'])) {
            header('Location: /');
            exit();
        }

        $arr[] = 'Email';
        $arr[] = 'Pass';
        $arr[] = 'Pass2';
        $arr[] = 'FirstName';
        $arr[] = 'LastName';
        $arr[] = 'g-recaptcha-response';

        $F = new F_Help();

        if (!$F->IsOllPostSet($arr)) {
            return;
        }

        $F->IsValidEmail($_POST['Email'], 'Email');
        $F->IsValidPass($_POST['Pass'], 'Pass');

        $F->IsCompare($_POST['Pass'], $_POST['Pass2'], 'Pass2');

        $F->IsStrMinNax($_POST['FirstName'], 3, 30, 'FirstName');
        $F->IsCtypeAlpha($_POST['FirstName'], 'FirstName');

        $F->IsStrMinNax($_POST['LastName'], 3, 30, 'LastName');
        $F->IsCtypeAlpha($_POST['LastName'], 'LastName');

        if (F_Help::$E == null) {
            $F->IsValidCaptcha($_POST['g-recaptcha-response']);
        }

        if (F_Help::$E == null) {

            $user = new User();

            $IsUnique = $user->IsUniqueUserEmail($_POST['Email']);

            if (!$IsUnique) {

                F_Help::$E['Email'] = "This login already exists !";
            } else {
                $user->Register($_POST);
            }
        }

        $res['e'] = F_Help::$E;
        $res = json_encode($res);

        echo $res;
    }

    function Logout_Action() {

        $user = new User();
        $user->Logout();
    }

}

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
    
    function php_ex_Action() {
        $file_d = new FilesT();
        $revision_d = new Revision();
        $files = $file_d->getUserFilesAll($_SESSION['Id']);


// Подключаем класс для работы с excel
        require_once(SYS_DIR . 'PHPExcel.php');
// Подключаем класс для вывода данных в формате excel
        require_once(SYS_DIR . 'PHPExcel/Writer/Excel5.php');

// Создаем объект класса PHPExcel
        $xls = new PHPExcel();
// Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
// Получаем активный лист
        $sheet = $xls->getActiveSheet();
// Подписываем лист
        $sheet->setTitle('File List');

// Вставляем текст в ячейку A1
        $sheet->setCellValue("A1", 'File list');
        $sheet->getStyle('A1')->getFill()->setFillType(
                PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('b5b5ff');
// Объединяем ячейки
        $sheet->mergeCells('A1:E1');

//називаємо поля
        $sheet->setCellValueByColumnAndRow(0, 3, "Filename");
        $sheet->setCellValueByColumnAndRow(1, 3, "Description");
        $sheet->setCellValueByColumnAndRow(2, 3, "Version");
        $sheet->setCellValueByColumnAndRow(3, 3, "Comment");
        $sheet->setCellValueByColumnAndRow(4, 3, "Update time");
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);


// Выравнивание текста
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(
                PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $i = 4;
        foreach ($files as $key => $value) {
            $sheet->setCellValueByColumnAndRow(0, $i, $value->file_name . ".txt");
            $sheet->setCellValueByColumnAndRow(1, $i, $value->description);
            $revisions = $revision_d->getRevisionsOfFile($value->id);
            
            foreach ($revisions as $key2 => $value2) {
                $i++;
                $sheet->setCellValueByColumnAndRow(2, $i, $value2->version);
                $sheet->setCellValueByColumnAndRow(3, $i, $value2->comments);
                $sheet->setCellValueByColumnAndRow(4, $i, $value2->update_time);
            }
            $i++;
        }

// Выводим HTTP-заголовки
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=FileList.xls");

// Выводим содержимое файла
        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');
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

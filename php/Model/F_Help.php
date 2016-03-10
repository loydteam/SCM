<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of F_Help
 *
 * @author root
 */
class F_Help {

    //put your code here

    static $E = null;

    static function IsStrMin($str, $min, $e_name) {

        if ($min > mb_strlen($str)) {
            self::$E[$e_name] = "You entered less than $min characters !";
            return false;
        }

        return true;
    }

    static function IsStrNax($str, $max, $e_name) {

        if (mb_strlen($str) > $max) {
            self::$E[$e_name] = "You entered more than $max characters !";
            return false;
        }

        return true;
    }

    static function IsStrMinNax($str, $min, $max, $e_name) {

        if (!self::IsStrMin($str, $min, $e_name)) {
            return false;
        }

        if (!self::IsStrNax($str, $max, $e_name)) {
            return false;
        }

        return true;
    }

    //Проверяет на наличие буквенно-цифровых символов      
    static function IsCtypeAlnum($str, $e_name) {

        if (!ctype_alnum($str)) {
            self::$E[$e_name] = "The field can only contain letters and numbers !";
            return false;
        }

        return true;
    }

    //Проверяет на наличие цифровых символов в строке
    //is_numeric()
    static function IsCtypeDigit($str, $e_name) {

        if (!ctype_digit($str)) {
            self::$E[$e_name] = "The field can only contain numbers !";
            return false;
        }

        return true;
    }

    //is_numeric
    static function IsNumeric($str, $e_name) {

        if (!is_numeric($str)) {
            self::$E[$e_name] = "The field can only contain numbers !";
            return false;
        }

        return true;
    }

    static function IsNumericMin($str, $min, $e_name) {

        if (isset(self::$E[$e_name])) {

            return false;
        }

        if ($min > $str) {
            self::$E[$e_name] = "You entered less than $min number !";
            return false;
        }

        return true;
    }

    static function IsNumericMax($str, $max, $e_name) {

        if (isset(self::$E[$e_name])) {

            return false;
        }

        if ($str > $max) {
            self::$E[$e_name] = "You entered more than $max numbers !";
            return false;
        }

        return true;
    }

    static function IsNumericMinNax($str, $min, $max, $e_name) {

        if (!self::IsNumericMin($str, $min, $e_name)) {
            return false;
        }

        if (!self::IsNumericMax($str, $max, $e_name)) {
            return false;
        }

        return true;
    }

    //Проверяет на наличие буквенных символов
    static function IsCtypeAlpha($str, $e_name) {

        if (!ctype_alpha($str)) {
            self::$E[$e_name] = "The field can only contain letters !";
            return false;
        }

        return true;
    }

    static function IsValidEmail($email, $e_name) {

        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($emailB, FILTER_VALIDATE_EMAIL) || ($emailB != $email)) {
            self::$E[$e_name] = "Incorrect Email !";
            return false;
        }

        return true;
    }

    static function IsValidPass($pass, $e_name, $min = 7, $max = 30) {

        if (!self::IsStrMinNax($pass, $min, $max, $e_name)) {
            return;
        }

        return true;
    }

    static function IsCompare($str, $str2, $e_name) {

        if ($str != $str2) {
            self::$E[$e_name] = "Fields do not match !";
            return false;
        }

        return true;
    }

    static function IsValidCaptcha($str, $e_name = 'g-recaptcha-response') {

        if (3 > mb_strlen($str)) {
            self::$E[$e_name] = "incorrect CAPTCHA !";
            return false;
        }

        $sekret = '6LejaxkTAAAAAGu7W-wrG5wBh99VbkEn40SY7JJ1';
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $sekret . '&response=' . $str);
        $odpowiedz = json_decode($sprawdz);

        if (!$odpowiedz->success) {
            self::$E[$e_name] = "incorrect CAPTCHA !";
            return false;
        }

        return true;
    }

    static function IsOllPostSet($array) {

        foreach ($array as $value) {
            if (!isset($_POST[$value])) {
                return false;
            }
        }
        return true;
    }

    static function GetHash($str, $salt = "654rtyf#") {

        //$hash = password_hash($str, PASSWORD_DEFAULT);
        //password_​verify

        $hash1 = md5($str . $salt);
        $hash2 = md5($hash1 . $salt);

        $arr_hash = str_split($hash1 . $hash2);
        sort($arr_hash);

        $hash = implode('', $arr_hash);

        //echo $hash;        
        //704ad3acef85decabaa361684e1614c90146eee1770daecfa7af4ca4a11f5d95
        //000111111133444444555666677778899aaaaaaaaaabcccccddddeeeeeeeffff

        return $hash;
    }

    //Только первый символ строки в верхний регистр
    static function strUpFirst($str) {

        $str = strtolower($str);
        $str = ucfirst($str);
        return $str;
    }

    static function NewPager($Page, $MaxPage, $str, $str2 = '', $Title = 'Page ', $strEnd = "") {

        //$Page++;

        $str2 = empty($str2) ? '' : '/' . $str2;

        if ($Page > $MaxPage) {
            $Page = $MaxPage;
        }

        if ($MaxPage == 1) {
            return '';
        }

        $Data = '|';
        if ($Page <= 3 || $MaxPage == 4) {
            for ($i = 0; $i < 4; $i++) {

                if ($i + 1 > $MaxPage) {
                    break;
                }

                if ($Page - 1 == $i) {
                    $Data .= $Page . '| ';
                } else {
                    $Data .= '<a href="' . $str . ($i + 1) . $strEnd . $str2 . '" title="' . $Title . ($i + 1) . '">' . ($i + 1) . '</a>| ';
                }
            }
            if ($MaxPage > 3 && $MaxPage != 4) {
                $Data .= ' ... |';
            }
        } else {
            $Data .= '<a href="' . $str . '1' . $strEnd . $str2 . '" title="' . $Title . '1">1</a>| ... |';
        }


        if ($Page > 3 && $MaxPage - $Page > 2) {
            $Data .= '<a href="' . $str . ($Page - 1) . $strEnd . $str2 . '" title="' . $Title . ($Page - 1) . '">' . ($Page - 1) . '</a>| ';
            $Data .= $Page . '| ';
            $Data .= '<a href="' . $str . ($Page + 1) . $strEnd . $str2 . '" title="' . $Title . ($Page + 1) . '">' . ($Page + 1) . '</a>| ... |';
        }

        //$this ->MaxPage
        if ($MaxPage > 4) {

            if ($MaxPage - $Page <= 2 && $MaxPage != 5) {
                for ($i = 3; $i >= 0; $i--) {
                    if ($Page == $MaxPage - $i) {
                        $Data .= $Page . '| ';
                    } else {
                        $Data .= '<a href="' . $str . ($MaxPage - $i) . $strEnd . $str2 . '" title="' . $Title . ($MaxPage - $i) . '">' . ($MaxPage - $i) . '</a>| ';
                    }
                }
            } else {
                $Data .= '<a href="' . $str . $MaxPage . $strEnd . $str2 . '" title="' . $Title . $MaxPage . '">' . $MaxPage . '</a>| ';
            }
        }

        return $Data;
    }

    static public function SafeTegs($str) {

        $str = htmlentities($str, ENT_QUOTES, "UTF-8");

        return $str;
    }

    static function IsValidFileImage($name, $maxsize) {

        if (empty($_FILES[$name]['size'])) {
            F_Help::$E[$name] = 'File size can not be zero !';
        } else if (!empty($_FILES[$name]['error'])) {
            F_Help::$E[$name] = 'Error loading file, try again !';
        } else if ($_FILES[$name]['size'] >= $maxsize) {
            F_Help::$E[$name] = 'File size exceeds allowed size - ' . ($maxsize / (1024 * 1024)) . ' Mb !';
        } else {
            $tmp = getimagesize($_FILES[$name]['tmp_name']);
            $accept = array('jpg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png');
            //$_FILES[$name]['type']
            $type = array_search($tmp['mime'], $accept);
            if (empty($type)) {
                F_Help::$E[$name] = 'Invalid file extension. Allowed only download formats jpg, gif и png.';
            }
        }
    }

    static function ImageResize($file, $load, $w = 350, $h = 0, $tip = 'jpg', $quality = '') {

        $size_img = getimagesize($file);
        if (empty($h)) {
            $h = ($size_img[1] * $w) / $size_img[0];
        }//auto визначення ширени

        $wo = $size_img[0];
        $ho = $size_img[1];
        $wr = $w;
        $hr = $h;
        if ($wo > $ho) {
            $h = ($ho * $w) / $wo; //h
        } else if ($wo < $ho) {
            $w = ($wo * $h) / $ho; //w
        } else {
            if ($w > $h) {
                $w = $h;
            } else if ($w < $h) {
                $h = $w;
            }
        }
        if ($w > $wr) {
            $w = ($wr * $h) / $hr; //w
            $h = ($ho * $w) / $wo; //h
        } else if ($h > $hr) {
            $h = ($hr * $w) / $wr; //h
            $w = ($wo * $h) / $ho; //w
        }

        $dest_img = imagecreatetruecolor($w, $h);

        if ($size_img[2] == 2) {
            $src_img = imagecreatefromjpeg($file);
        } else if ($size_img[2] == 1) {
            $src_img = imagecreatefromgif($file);
        } else if ($size_img[2] == 3) {
            $src_img = imagecreatefrompng($file);
        }

        //якість малюнку
        if (empty($quality)) {
            imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);
        } else {
            imagecopyresized($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);
        }

        if ($tip == 'jpg') {
            if (!empty($load)) {
                imagejpeg($dest_img, $load);
            } else {
                header("Content-type: image/jpeg");
                imagejpeg($dest_img);
            }
        } else if ($tip == 'gif') {
            if (!empty($load)) {
                imagegif($dest_img, $load);
            } else {
                header("Content-type: image/gif");
                imagegif($dest_img);
            }
        } else if ($tip == 'png') {
            if (!empty($load)) {
                imagepng($dest_img, $load);
            } else {
                header("Content-type: image/png");
                imagepng($dest_img);
            }
        }

        imagedestroy($dest_img);
        imagedestroy($src_img);
    }

}

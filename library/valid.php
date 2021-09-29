<?php


class valid
{
    public static function setValidate($array=[])
    {
        if(isset($array)) {
            foreach ($array as $arrays => $arrayss) {
                valid::checkValidate($arrays,$arrayss);
            }
        }
    }

    public static function getValidate($param_name)
    {
//        $param_name = $param_name."_".rand(1,100);
        $array = $_SESSION['validate']['type'][$param_name];
        foreach($array as $arrays){
            if(isset($_SESSION['validate']['msg'][$arrays][$param_name])) {
                echo '<div class="invalid-form mt-2">' . $_SESSION['validate']['msg'][$arrays][$param_name] . '</div>';
            }
        }
    }

    public static function checkValidate($param,$type=[])
    {
        global $var;
        admin::setFILES();
        $lineCenter = explode("|",$type);
        $_SESSION['validate']['type'][$param] = $lineCenter;
        foreach($lineCenter as $_type){
            if($_type == 'url' AND !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$_POST[$param])){
                $_SESSION['validate'][$param] = true;
                $_SESSION['error'] = 1;
                $_SESSION['validate']['msg'][$_type][$param] = 'Format URL is invalid';
            }
            if((empty($_POST[$param]) AND empty($_FILES[$param]['name'])) AND $_type == "required") {
                $_SESSION['validate'][$param] = true;
                $_SESSION['error'] = 1;
                $_SESSION['validate']['msg'][$_type][$param] = 'Please enter some value';
            }
            if($_type == "not_same") {
                $_SESSION['validate'][$param] = true;
                $_SESSION['error'] = 1;
                $_SESSION['validate']['msg'][$_type][$param] = 'Password not Match';
            }
            if($_type == 'size'){
                $tmp_name   = $_FILES[$param]['tmp_name'];
                $filename   = $_FILES[$param]['name'];
                $size       = round($_FILES[$param]['size']/1048576,2);
                $maxsize    = 2;
                $ext        = pathinfo($filename, PATHINFO_EXTENSION);
                if($size > $maxsize AND $ext == 'png')
                {
                    $_SESSION['validate'][$param] = true;
                    $_SESSION['error'] = 1;
                    $_SESSION['validate']['msg'][$_type][$param] = 'Image does not exceed 2mb';
                }
            }
        }
    }

    public static function delimeter($lineCenter)
    {
        
    }
    
    public static function checkError()
    {
        if (isset($_SESSION['error']) AND $_SESSION['error']) {
            return true;
        }else{
            return false;
        }
    }

    public static function unsetValidate()
    {
        unset($_SESSION['error']);
        unset($_SESSION['validate']);
    }

    public static function setData()
    {
        global $var;
        $_SESSION['valid_data'] = ($_SERVER['REQUEST_METHOD'] == "get") ? base64_encode(serialize($_GET)) : base64_encode(serialize($_POST));
    }

    public static function getData(&$data)
    {
        global $var;
        if(valid::checkError()){
            $validData =  unserialize(base64_decode($_SESSION['valid_data']));

            // while (list($a,$b) = each($validData)){
            //     $val = $a;
            //     $data[$val] = $b;
            // }
            foreach($validData as $a => $b)
            {
                $val = $a;
                $data[$val] = $b;
            }
        }
    }


}
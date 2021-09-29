<?php
    
class route
{
    protected $controller = 'dashboard';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        admin::getSession();
        if(isset($_GET['url'])){
            if($_GET['url'] == '_json'){
                include  $var['core_path'] . '/json.php';
                exit;
            }
        }
        $url = route::parseURL();
        if(!isset($url) OR $url[0] == 'dashboard'){
            $this->controller = $url;
            $url[0] = 'default';
            $url[1] = 'dashboard';
        }

        $default = '';

        if($url[0] == 'default'){
            $default = 'default/'; //jika default
            $url[0] = $url[1];
            if(isset($url[2])){
                $url[1] = $url[2];
                array_splice($url, 1, 1);
            }
            else{
                array_splice($url, 0, 1);
            }
        }


        // Controller
        if(file_exists('../app/controllers/'. $default. $url[0] . '.php'))
        {
            $this->controller = $url[0];
            unset($url[0]);
        }else{
            include $var['v_template_path'] . '/dsp_not_found.php';
            exit;
        }

        require_once '../app/controllers/' . $default . $this->controller . '.php';
        $this->controller = new $this->controller;
        // Method
        if(isset($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }  
            else{
                include $var['v_template_path'] . '/dsp_not_found.php';
                exit;
            }
        }

        // Params
        if(!empty($url))
        {
            $this->params = array_values($url);
        }
        // jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public static function parseURL()
    {
        if(isset($_GET['url']))
        {
             $url = rtrim($_GET['url'],'/');
             $url = filter_var($url, FILTER_SANITIZE_URL);
             $url = explode('/', $url);
             return $url;
        }
    }
    public static function controller()
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        // $dev = (isset($dev)) ? ".dev" : '';
        $url = route::parseURL();
        $url[0] = ($url[0] == 'default') ? $url[1] : $url[0];
        $module = $url[0];
        return $module;
    }
    public static function method()
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        $url    = route::parseURL();
        $method = (isset($url[1])) ? $url[1] : '';
        return $method;
    }
    public static function urlHtaccess()
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        $urlHtaccess = $var['app_url'] . '/' . $url_2;
        return $urlHtaccess;
    }
    public static function title()
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        $url = route::parseURL();
        $url[0] = ($url[0] == 'default') ? $url[1] : $url[0];
        $module = $url[0];
        return $module;
    }
}
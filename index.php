<?php
    include 'global.php';
    db::connect();
    global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
    $page = isset($page) ? $page : 'home';
    $lang_def = 'id';
    $jsonSet = true;
    if(isset($page))
    {
        if($page == 'statis')
        {
            $status = ( isset($side) == 'header' OR isset($st) == 'footer' ) ? 'main' : 'page';
            include $var['public_path'] ."/statis/". $status ."/". $st .".html";
        }
        else if($page == 'dinamis')
        {
            if($jsonSet) {
                $jsonFile = $var['json_path'] . '/' . $dn . '.json';
                if (!file_exists($jsonFile)) {
                    echo "File Json tidak ada";
                } else {
                    $data = file::getJson($jsonFile);
                    include $var['public_path'] . "/dinamis/" . $type . "/" . $dn . ".html";
                }
            }else{
                include $var['public_path'] . "/dinamis/" . $type . "/" . $dn . ".html";
            }
        }
        else {
            if(isset($page1) == "detail") $page = $page1 . "-" . $page;
            $page_file = $var['public_path'] . '/statis/page/'.$page.'.html';
            if (file_exists($page_file)) {
                $parsing = file_get_contents($page_file);
                $parsing = split::callHTML($parsing);
                echo $parsing;
            }else{
                $_public = true;
                include $var['v_template_path'] . '/dsp_not_found.php';
            }
        }
    }

?>
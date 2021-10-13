<?php
class split {

    public static function parse_src($value){
        global $var;
        $value 	= str_ireplace('assets/video/', $var['video'] .'/', $value);
        $value 	= str_ireplace('assets/css/', $var['styles'] .'/', $value);
        $value 	= str_ireplace('assets/js/', $var['scripts'] .'/', $value);
        $value 	= str_ireplace('assets/vendor/', $var['vendor'] .'/', $value);
        $value 	= str_ireplace('assets/images/', $var['images'] .'/', $value);
        return $value;
    }
    
    // *********** PARSING HTML STATIS *********** //
    public static function parsingStatis($files,$fileName)
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        $files = file_get_contents($files);
        $files = htmlentities($files);
        preg_match_all("'&lt;!--!!ST-(.*?)!!--&gt;(.*?)&lt;!--/!!ST-(.*?)!!--&gt;'si",$files,$content);
        if(count($content[0]) > 0)
        {
            foreach($content[0] as $key => $value)
            {
                $parseKey		= $content[1][$key];
                $parseName 	    = strtolower($parseKey);
                if($parseName != 'content'){
                    $parseFile		= $var['public_path'] ."/statis/main/". $parseName .".html";
                    $val1 = ''; $val2 = '';
                }else{
                    $fileName = str_replace(".html","",$fileName);
                    $parseFile		= $var['public_path'] ."/statis/page/". $fileName .".html";
                    $val1 = '&lt;!--!!ST-HEADER!!--&gt;';
                    $val2 = '&lt;!--!!ST-FOOTER!!--&gt;';
                }
                if(!file_exists($parseFile))
                {
                    $parse   = self::parse_src($value);
                    $parse   = str_replace('&lt;!--!!ST-'.$parseKey.'!!--&gt;', $val1, $parse);
                    $parse   = str_replace('&lt;!--/!!ST-'.$parseKey.'!!--&gt;', $val2, $parse);
                    $parse   = html_entity_decode($parse);
                    $fopen      = fopen($parseFile, 'w') or die("can't open file");
                    fwrite($fopen, $parse);
                    fclose($fopen);
                }
            }
        }
    }

    // *********** PARSING HTML DINAMIS *********** //
    public static function parsingDinamis($files,$fileName,$type)
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        $files = file_get_contents($files);
        $files = htmlentities($files);
        $type = strtoupper($type);

        preg_match_all("'&lt;!--!!DN-".$type."-(.*?)!!--&gt;(.*?)&lt;!--/!!DN-".$type."-(.*?)!!--&gt;'si",$files,$content);

        if(count($content[0]) > 0)
        {
            foreach($content[0] as $key => $value)
            {
                $parseKey		= $content[1][$key];
                $parseName 	    = strtolower($parseKey);
                $parseFile		= $var['public_path'] ."/dinamis/".$type."/". $parseName .".html";
                if(!file_exists($parseFile))
                {
                    $parse   = self::parse_src($value);
                    $parse   = str_replace('&lt;!--!!DN-'.$type.'-'.$parseKey.'!!--&gt;', '', $parse);
                    $parse   = str_replace('&lt;!--/!!DN-'.$type.'-'.$parseKey.'!!--&gt;', '', $parse);
                    $parse   = html_entity_decode($parse);
                    $fopen      = fopen($parseFile, 'w') or die("can't open file");
                    fwrite($fopen, $parse);
                    fclose($fopen);
                }
            }
        }
    }

    // *********** CALL STATIS CONTENT  *********** //
    public static function callStatisContent($files)
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        preg_match_all("'&lt;!--!!ST-(.*?)!!--&gt;'si",$files,$basis);
        if(count($basis[0]) > 0)
        {
            foreach($basis[0] as $key => $value)
            {
                $op = array( 'http'=>array( 'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                        "Cookie: ".session_name()."=".session_id()."\r\n" ) );
                session_write_close();
                $ctx = stream_context_create($op);
                $parseKey		= $basis[1][$key];
                $parseName 	    = strtolower($parseKey);
                if(isset($page1)){
                    $page = explode("-",$page);
                    if(isset($page[1])){$page = $page[1];}
                }
                $pages = isset($_GET['page']) ? $_GET['page'] : $page;
                $parseSource    = file_get_contents($var['public_path'] .'/statis/main/'. strtolower($parseName) .'.html');
                $parseSource    = file_get_contents($var['http'] . "/statis&st=".$parseName."&pg=".$pages, false, $ctx);
                $parseContent   = htmlentities($parseSource);
                $files           = str_replace($value, $parseContent, $files);
            }
        }
        return $files;
    }

    // *********** CALL DINAMIS CONTENT  *********** //
    public static function callDinamisContent($files,$type='')
    {
        global $var;foreach($GLOBALS as $k=> $v) $$k=$v;
        $tipe = strtolower($type);
        preg_match_all("'&lt;!--!!DN-".$type."-(.*?)!!--&gt;(.*?)&lt;!--/!!DN-".$type."-(.*?)!!--&gt;'si",$files,$basis);
        if(count($basis[0]) > 0)
        {
            foreach($basis[0] as $key => $value)
            {
                $op = array( 'http'=>array( 'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                        "Cookie: ".session_name()."=".session_id()."\r\n" ) );
                session_write_close();
                $ctx = stream_context_create($op);
                $parseKey		= $basis[1][$key];
                $parseName 	    = strtolower($parseKey);
                if(isset($page1)){
                    $page = explode("-",$page);
                    if(isset($page[1])){$page = $page[1];}
                }
                $pages = isset($_GET['page']) ? $_GET['page'] : $page;
                $parseSource    = file_get_contents($var['http'] . "/dinamis&dn=".$parseName."&type=".$tipe.(isset($pages) ? '&pg='.$pages : '').(isset($page2) ? '&detail='.$page2 : ''),false,$ctx);
                $parseContent   = htmlentities($parseSource);
                $files          = str_replace($value, $parseContent, $files);
            }
        }
        return $files;
    }
    
    // *********** CALL HTML *********** //
    public static function callHTML($base)
    {
        global $var;
        $base       = htmlentities($base);
        $base       = self::callStatisContent($base);
        $base       = self::callDinamisContent($base,'NAV');
        // $base       = self::callDinamisContent($base,'CODE');
        $base       = self::callDinamisContent($base,'LOOP');
        $base       = html_entity_decode($base);
        $base 	    = str_replace(array("\r\n", "\r"), "\n", $base);
        $lines 		= explode("\n", $base);
        $_source 	= array();
        foreach ($lines as $i => $line) {
            if(!empty($line))
                $_source[] = trim($line);
        }
//        $base = implode($_source);
        $base 	    = str_replace(array("\r\n", "\r"), "\n", $base);
        $base 	    = str_replace("assets/img", "_frontend/images", $base);
        // $base       = str_replace($var['http']."/assets/", "_frontend/", $base);
        $base 	    = str_replace("_frontend", $var['http'] . "/_frontend", $base);
        $base       = str_replace("../..", $var['http'] . "/control", $base);

                        
        return $base;
    }

}
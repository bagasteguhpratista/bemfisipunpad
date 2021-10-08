<?php

$var['path']           = $_SERVER["DOCUMENT_ROOT"] .'/'. $var['htdocs'];
$var['httpbase']       = "http://". $_SERVER["HTTP_HOST"];
$var['http']           = $var['httpbase'] .'/'. $var['htdocs'];
$var['library']        = $var['path'] . '/library';
$var['library_url']    = $var['http'] . '/library';


$var['app_assets']     = $var['http'] . '/assets';
// to url
$var['app_url']        = $var['http'] . '/' . $var['admin_name'];
$var['core_url']       = $var['app_url'] . '/core';
$var['model_url']      = $var['app_url'] . '/models';
$var['view_url']       = $var['app_url'] . '/views';
$var['json_url']       = $var['app_url'] . '/json';
$var['v_assets_url']   = $var['view_url'] . '/assets';
$var['v_template_url'] = $var['view_url'] . '/template';
$var['v_display_url']  = $var['view_url'] . '/display';
$var['v_public_url']   = $var['http'] . '/public';

$var['v_images_url']   = $var['v_assets_url'] . '/images';
$var['v_pdf_url']   = $var['v_assets_url'] . '/pdf';


// to app [Path]
$var['app_path']       = $var['path'] . '/app';
$var['core_path']      = $var['app_path'] . '/core';
$var['model_path']     = $var['app_path'] . '/models';
$var['controller_path'] = $var['app_path'] . '/controllers';
$var['view_path']      = $var['app_path'] . '/views';
$var['json_path']      = $var['app_path'] . '/json';
$var['v_assets_path']   = $var['view_path'] . '/assets';
$var['v_template_path'] = $var['view_path'] . '/template';
$var['v_display_path']  = $var['view_path'] . '/display';
$var['v_images_path']   = $var['v_assets_path'] . '/images';
$var['v_pdf_path']   	= $var['v_assets_path'] . '/pdf';
$var['html_path']       = $var['path'] . '/backup/html';
$var['public_path']     = $var['path'] . '/public';

// assets
$var['img_static']      = $var['v_assets_url'] . '/images/template';
$var['data_assets']     = $var['http']."/assets";
$var['data_lib']        = $var['httpbase'];
$var['_vendors']        = $var['http'];

$var['assets']        = $var['http']."/_frontend/assets";
$var['static']        = $var['http']."/_frontend/static";
$var['styles']        = $var['http']."/_frontend/styles";
$var['scripts']       = $var['http']."/_frontend/scripts";
$var['images']        = $var['http']."/_frontend/images";
$var['files']         = $var['http']."/_frontend/files";
$var['http_images']   = $var['http']."/_frontend/images";
$var['video']      	  = $var['http']."/_frontend/video";
$var['vendor']        = $var['http']."/_frontend/vendor";
$var['lib']      	  = $var['http']."/lib";

//$var['get_session']   = "dummy_session";

//filemanager
$var['filemanager_url']     = $var['app_url'].'/_filemanager';
$var['filemanager_url_']    = $var['htdocs'].'/'.$var['admin_name'].'/_filemanager';
$var['filemanager_path']    = $var['v_images_path'] . '/filemanager';

// CkEditor

$var['ckeditor_path']     	= $var['http'].'/_import/ckeditor5';
$var['ckfinder_path']     	= $var['http'].'/_import/ckfinder';
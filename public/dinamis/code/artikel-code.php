<?php 
	include '../../../global.php';
	global $var;foreach($GLOBALS as $k=> $v) $$k=$v; //harus ada di fungsi apapun
	$alias = $_GET['alias'];
    if($alias != 'all'){
        $category       = db::data_where("id","kategori_artikel","alias",$alias);
        $rs['data']     = db::data_record_select("*","artikel","category=".$category." ORDER BY reorder DESC");
    }else{
        $rs['data']     = db::data_record_select("*","artikel","1=1 ORDER BY reorder DESC");
    }
    // $items = '';
    while($row=db::fetch($rs['data'])){
        $row['url'] = $var['http'].'/artikel/detail/'.$row['alias'];
        $row['image'] = $row['image_cover'];
        $row['image_cover'] = $var['v_images_url']."/artikel/". $row['image_cover'];
        // $row['publish_date'] = admin::format_date($item['publish_date'],'id','A');
        $row['category_alias'] = db::data_where("alias","kategori_artikel","id",$row['category']);
        $row['category_name'] = db::data_where("name","kategori_artikel","id",$row['category']);
        $items[] = $row;
    }
    $html = '';
    if(isset($items)){
        foreach($items as $item){
            // list($width, $height) = getimagesize($item['image_cover']);
            // $height = ($height <= '300') ? 'zoom' : 'no-zoom';
            $item['image'] = ($item['image']) ? $item["image_cover"] : "_frontend/images/no-image.jpg";
            $html .= '<div class="mix card col-lg-4 col-md-4 col-sm-8 '. $item['category_alias'] .'" id="box-'.$item['category_alias'].'" data-i="'.$item['category_alias'].'">';
            $html .= '<a href="'. $item['url'].'">';
            $html .= '<div class="artikel-img-box"><img class="card-img-top" src="'.$item['image'].'" alt="Card image cap"></div>';
            $html .= '<div class="card-body">';
            $html .= '<div class="cat-det">';
            $html .= '<p class="publish_date">'.admin::format_date($item['publish_date'],"id","A").'</p>';
            $html .= '<p class="read-article">Dibaca Normal '. $item['min_read'].' menit</p>';
            $html .= '</div>';
            $html .= '<h5 class="card-title judul">'. admin::limit_text($item['title'],10).'</h5>';
            $html .= '</div></a></div>';
        }
    }
    echo $html;
    exit;
 ?>
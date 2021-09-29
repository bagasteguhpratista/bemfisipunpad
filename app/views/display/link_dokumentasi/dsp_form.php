<?php 
view::get_views_template("dsp_header");
    view::get_component("form_up");
    	view::get_component('inputtext',
            array(
                "name"=>"link_dokumentasi",
                "value"=>isset($data['link_dokumentasi']) ? $data['link_dokumentasi'] : '',
                "validate"=>"required",
                "detail"=>"harap untuk memasukan link lengkapnya dengan <b>https://www</b>. </br>[contoh: https://www.google.com]"
			)
        );
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:"",
                "update"=>true
            )
        );
    view::get_component("form_down");
    view::get_views_template("dsp_footer");
?>


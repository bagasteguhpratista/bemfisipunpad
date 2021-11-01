<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component("select2lib");

        view::get_component('inputtext',
            array(
                "name"=>"name",
                "value"=>isset($data['nama']) ? $data['nama'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('select2',
            array(
                "name"=>"metode_bayar",
                "value"=>isset($data['metode_bayar']) ? $data['metode_bayar'] : '',
                "validate"=>"required",
                "items"=>$rs['metode_bayar'],
            )
        );

        view::get_component('inputtext',
            array(
                "name"=>"jumlah",
                "value"=>isset($data['jumlah']) ? $data['jumlah'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('textarea',
            array(
                "name"=>"catatan",
                "value"=>isset($data['catatan']) ? $data['catatan'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('radiobutton',
            array(
                "name"=>"privasi",
                "value"=>isset($data['is_private']) ? $data['is_private'] : '',
                "validate"=>"required",
                "choice" => array("yes","no")
            )
        );
  view::get_component('radiobutton',
            array(
                "name"=>"status_pembayaran",
                "value"=>isset($data['status']) ? $data['status'] : '',
                "validate"=>"required",
                "choice" => array("Sukses","Pending")
            )
        );
        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");

<?php 
    view::get_views_template("dsp_header");
        view::get_component("form_up");

        view::get_component('inputtext',
            array(
                "name"=>"title_website",
                "value"=>isset($data['title_website']) ? $data['title_website'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('textarea',
            array(
                "name"=>"title_cms",
                "value"=>isset($data['title_cms']) ? $data['title_cms'] : '',
                "validate"=>"required"
            )
        );
        ?>
    </br><p style="font-size: 14px; font-weight: 700; text-align: center;">Jumlah Data</p>
        <?php
        view::get_component('inputtext',
            array(
                "name"=>"jumlah_departementbiro",
                "value"=>isset($data['jumlah_departementbiro']) ? $data['jumlah_departementbiro'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"jumlah_staff",
                "value"=>isset($data['jumlah_staff']) ? $data['jumlah_staff'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"jumlah_programkerja",
                "value"=>isset($data['jumlah_programkerja']) ? $data['jumlah_programkerja'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"jumlah_aksi",
                "value"=>isset($data['jumlah_aksi']) ? $data['jumlah_aksi'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"jumlah_kajian",
                "value"=>isset($data['jumlah_kajian']) ? $data['jumlah_kajian'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"jumlah_postinstagram",
                "value"=>isset($data['jumlah_postinstagram']) ? $data['jumlah_postinstagram'] : '',
                "validate"=>"required"
            )
        );
        ?>
    </br><p style="font-size: 14px; font-weight: 700; text-align: center;">Link Media Sosial</p>
        <?php
        view::get_component('inputtext',
            array(
                "name"=>"link_instagram",
                "value"=>isset($data['link_instagram']) ? $data['link_instagram'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"link_line",
                "value"=>isset($data['link_line']) ? $data['link_line'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"link_twitter",
                "value"=>isset($data['link_twitter']) ? $data['link_twitter'] : '',
                "validate"=>"required"
            )
        );
        view::get_component('inputtext',
            array(
                "name"=>"link_youtube",
                "value"=>isset($data['link_youtube']) ? $data['link_youtube'] : '',
                "validate"=>"required"
            )
        );

        view::get_component('submit',
            array(
                "id"=>(isset($id))?$id:""
            )
        );
        view::get_component("form_down");
    view::get_views_template("dsp_footer");

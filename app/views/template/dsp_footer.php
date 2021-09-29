                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <h6>&copy; Checkidot Web</h6>
                            </div>
                        </div>
                    </div>    
                </div>
                    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
            </div>
        </div>
        <script type="text/javascript" src="<?= $var['app_assets']?>/_js/main.js"></script>
       
        <link rel="stylesheet" type="text/css" href="<?php echo $var['app_assets'] ?>/_vendors/tablesorted/theme.default.min.css">
        <script type="text/javascript" src="<?= $var['app_assets'] ?>/_vendors/tablesorted/jquery.tablesorter.min.js"></script>
        <script src="<?=  $var['app_assets'] ?>/_vendors/jqui/jquery-ui.js"></script>
        <script type="text/javascript">
            $('document').ready(function(){
                var url = '<?= $url ?>';
                function fetch_data(query = ''){
                    var show_all = $('.showAll').attr("data-show");
                    $.ajax({
                        url:"<?= $url ?>&search="+query+"&show_all="+show_all,
                        method:'POST',
                        dataType:'html',
                        success:function(data)
                        {
                            // console.log(data);
                            $('#listForm').html($(data).find('#tableList'));
                            $('#setPagination').html($(data).find('#setPagination'));
                            getTableSort();
                            checkbox_setting();
                            // return false;
                        }
                    });
                }
                $(document).on('keyup','#search',function(){
                    var query = $(this).val();
                    // console.log(query);
                    fetch_data(query);
                });
            <?php //if(isset($sorted)){ ?>
                $( "#sortable" ).sortable({
                    update: function() {
                        $.ajax({
                            url:"<?= $url ?>/reorder&"+$(this).sortable("serialize"),
                            method:'POST',
                            dataType:'html',
                            success:function(data)
                            {
                                var notif_msg = '<div class="alert alert-success alert-dismissible fade in"                             role="alert">';
                                notif_msg += '<button type="button" class="close" data-dismiss="alert"                          aria-label="Close">';
                                notif_msg += '<span aria-hidden="true">×</span>';
                                notif_msg += '</button><strong>urutan berhasil diubah</strong>';
                                notif_msg += '</div>';

                            if(data) $('#refresh').trigger('click');
                            if(data) $(".notif-msg").html(notif_msg);
                            
                            setTimeout(function(){ location.reload();}, 1000);
                            }
                        });
                    }
                });
            <?php //} ?>
                function load_data(page){
                    $.ajax({
                        url:"<?= $url ?>&halamanaktif="+page,
                        method:"POST",
                        dataType:'html',
                        success:function(data){
                            $('#listForm').html($(data).find('#listForm'));
                            $('#setPagination').html($(data).find('#setPagination'));
                            getTableSort();
                            checkbox_setting();
                        }
                   })
                }
                function show_all(){
                    $.ajax({
                        url: "<?= $url ?>&show_all=1",
                        method:"POST",
                        dataType:'html',
                        success:function(data){
                            $('#listForm').html($(data).find('#listForm'));
                            $('#setPagination').html($(data).find('#setPagination'));
                            getTableSort();
                            checkbox_setting();
                        }
                    });
                }
                $(document).on('click', '#show_all', function(){
                    show_all();
                });
                $(document).on('click', '.halaman', function(){
                    var page = $(this).attr("id");
                    load_data(page);
                });
                function getTableSort(){
                    $("#tableList").tablesorter({
                        widgets        : ['columns'],
                        usNumberFormat : false,
                        sortReset      : true,
                        sortRestart    : true
                    });
                    checkbox_setting();
                }
                function checkbox_setting(){
                    var lang = $("select[name=p_lang]").val();
                    var checkItem = function(){
                        var chkall      = $('#checkall');
                        var checkitem   = $('.checkitem');
                        chkall.change(function(){
                            if(this.checked)
                            {
                                checkitem.prop('checked', true);
                            }
                            else
                            {
                                checkitem.prop('checked', false);
                            }
                        });
                    },checkDel = function(){
                        $('#delete').click(function(){
                            if($('.checkitem:checked').length <= 0)
                            {
                                var notif_msg = '<div class="alert alert-warning alert-dismissible fade in"                             role="alert">';
                                    notif_msg += '<button type="button" class="close" data-dismiss="alert"                          aria-label="Close">';
                                    notif_msg += '<span aria-hidden="true">×</span>';
                                    notif_msg += '</button><strong>Please checked option(s) first</strong>';
                                    notif_msg += '</div>';
                                $(".notif-msg").html(notif_msg);
                                return false;
                            }
                            else
                            {
                                var lsform = $('#listForm');
                                lsform.attr('action', $(this).attr('action')).submit();
                                return true;
                            }
                        });

                    };
                    checkDel();
                    checkItem();
                }
                checkbox_setting();
                getTableSort();
            });
            
        </script>
    </body>
    </html>
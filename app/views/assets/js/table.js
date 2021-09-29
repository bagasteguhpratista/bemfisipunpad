$('document').ready(function(){
    var lang = $("select[name=p_lang]").val();
    var checkItem = function(){
        var chkall      = $('#checkall');
        var checkitem 	= $('.checkitem');
        chkall.bind('change',function(){
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
});
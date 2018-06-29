jQuery(document).ready(function($){
    $(document).on('click', '.add-email-var', function () {
        var variable = $(this).data('variable');
        window.send_to_editor('[' + variable + ']');
    });
    $('#jh_email_notification').change(function(){
        if($(this).attr('checked')){
             $(this).val('1');
        }else{
             $(this).val('0');
        }
   });
});
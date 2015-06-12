/**
 * Created by tomekdrazewski on 11/06/15.
 */
$(document).ready(function () {
    $('#kat').change(function(){
        $(this).closest('form').trigger('submit');
    })
    $('#grp').change(function(){
        $(this).closest('form').trigger('submit');
    })
});
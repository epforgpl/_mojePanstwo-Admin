/**
 * Created by tomekdrazewski on 29/05/15.
 */

$(document).ready(function () {

    var url      = window.location.href;
    url = url+'.json';


        $.getJSON( url , function( data ) {

        });

    setTimeout(function(){
            location.reload();
        }
        ,60*1000);
});
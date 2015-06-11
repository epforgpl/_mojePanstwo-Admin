$(document).ready(function () {
    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

    $('#savebtn').click(function () {
        var form_data = {
            id : $('#id').text(),
            opis : $('#editor').html()
        };

        console.log(form_data);

        $.ajax({
            url: "../update",
            method: "post",
            data: form_data,
            success: function(res){
                $('#info').html('Opis dodany do bazy');
                $('#info').removeClass('hidden');
            },
            error: function(xhr){
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    });


});

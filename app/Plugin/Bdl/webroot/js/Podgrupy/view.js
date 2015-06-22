$(document).ready(function () {
    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

    $('#savebtn').click(function () {
        var form_data = {
            id: $('#id').text(),
            nazwa: $('#nazwa').val(),
            opis: $('#editor').html()
        }
        $.ajax({
            url: "../update",
            method: "post",
            data: form_data,
            success: function (res) {
                if (res == false) {
                    alert("Wystąpił błąd");
                } else if (res.Podgrupy.id = id) {
                    $('#info').html('Opis dodany do bazy');
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    });


});

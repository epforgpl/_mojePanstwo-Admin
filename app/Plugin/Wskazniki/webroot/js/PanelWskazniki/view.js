$(document).ready(function () {
    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

    $('#savebtn').click(function () {
        console.log();
        var form_data = {
            id: $('#id').text(),
            nazwa: $('#nazwa').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            fax: $('#fax').val(),
            www: $('#www').val(),
            adres_str: $('#adres_str').val(),
            opis_html: $('#editor').html(),
            gender: $("input[type='radio']").serialize(),
            tagi: $("input[type='checkbox']").serialize()
        }
        $.ajax({
            url: "./../update",
            method: "post",
            data: form_data,
            success: function (res) {
                if (res == false) {
                    alert("Wystąpił błąd");
                } else if (res == true) {
                    $('#info').html('Instytucja została zmieniona');
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    });
    $('#addbtn').click(function () {
        console.log();
        var form_data = {
            nazwa: $('#nazwa').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            fax: $('#fax').val(),
            www: $('#www').val(),
            adres_str: $('#adres_str').val(),
            opis_html: $('#editor').html(),
            gender: $("input[type='radio']").serialize(),
            tagi: $("input[type='checkbox']").serialize()
        }
        $.ajax({
            url: "./addnew",
            method: "post",
            data: form_data,
            success: function (res) {
                if (res == false) {
                    alert("Wystąpił błąd");
                } else if (res == form_data.id) {
                    $('#info').html('Instytucja została dodana');
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    });



});

/**
 * Created by tomaszdrazewski on 24/06/15.
 */
$(document).ready(function () {
    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

});

function saveData(dane) {
    $.ajax({
        url: "/wskazniki/panel_wskazniki/saveimport",
        method: 'post',
        data: dane,
        success: function (res) {
            if (res === false) {
                alert("Błąd zapisu");
            } else {
                if (res === '1') {
                    $("#info").html('Dodano nowy wskaźnik do bazy.');
                    $("#mainid").html(res);
                    $('#info').addClass('alert-success');
                } else {
                    $("#info").html(res);
                    $('#info').addClass('alert-danger');
                }
                $('#info').removeClass('hidden');
            }
        },
        error: function (xhr) {
            alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
        }

    });
}

$("#addbtn").click(function () {
    dane = {
        id: $('#mainid').text(),
        tytul: $("#nazwa").val(),
        tytul_skr: $("#nazwa_skr").val(),
        opis: $("#editor").html(),
        url: $("#url").val()
    };
    saveData(dane);
});
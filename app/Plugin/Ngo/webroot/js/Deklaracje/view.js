/**
 * Created by tomekdrazewski on 18/06/15.
 */
$(document).ready(function () {
    $('button').click(function () {
        console.log();
        var form_data = {
            id: $('#id').text(),
            status: $(this).val()
        }
        $.ajax({
            url: "/ngo/deklaracje/save",
            method: "post",
            data: form_data,
            success: function (res) {
                if (res == false) {
                    alert("Wystąpił błąd");
                } else if (res == 1) {
                    $('#info').html('Podanie zostało zaakceptowane');
                    $('#info').addClass('alert alert-success');
                    $('#info').removeClass('hidden');
                } else if (res == 2) {
                    $('#info').html('Podanie zostało odrzucone');
                    $('#info').addClass('alert alert-danger');
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    });
});
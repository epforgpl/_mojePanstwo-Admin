/**
 * Created by tomekdrazewski on 19/06/15.
 */
$(document).ready(function () {
    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });

    function saveData(dane) {
        $.ajax({
            url: "/wskazniki/panel_wskazniki/savedata",
            method: 'post',
            data: dane,
            success: function (res) {
                if (res == false) {
                    alert("Błąd zapisu");
                } else {
                    if (res != null) {
                        $("#info").html('Dodano nowy wskaźnik do bazy.');
                        $("#mainid").html(res);
                    }else{
                        $("#info").html('Zmodifkowano wskaźnik w bazie.');
                    }
                    $('#info').removeClass('hidden');
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }

        });
    }

    function pullData(typ) {
        $.ajax({
            url: "/wskazniki/panel_wskazniki/getdata",
            method: 'post',
            data: {search: $('#search').val()},
            success: function (res) {
                if (res == false) {
                    alert("Brak Wyników");
                } else {
                    list = '';
                    index = 0;
                    $.each(res, function (index, value) {
                        list += '<li class="list-group-item"><a id="dodajwskaznik' + typ + '" value="' + value.BdlPodgrupy.id + '">' + value.BdlPodgrupy.tytul + '</a></li>';
                    });
                    $('#lista').html(list);
                }
            },
            error: function (xhr) {
                alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
            }
        });
    };

    $("#search-btn").click(function () {
        pullData();
    });

    $("#licznik").click(function () {
        pullData('licznik');
        $("#Modal").modal('show');
    });

    $("#mianownik").click(function () {
        pullData('mianownik');
        $("#Modal").modal('show');
    });

    $(document).on('click', '[id^="dodajwskazniklicznik"]', function () {
        $("#listalicznik").append('<li class="list-group-item" id="' + $(this).attr('value') + '"><div class="row">' + $(this).text() + '<br></div><div class="row"><div class="col-sm-6"><form><label class="radio-inline"><input name="znak" type="radio" value="1" checked> +</label><label class="radio-inline"><input name="znak" type="radio" value="-1"> - </label></form></div><div class="col-sm-6"><button class="pull-right btn-sm btn-danger" id="remove">x</button></div></div></li>');
    });

    $(document).on('click', '[id^="dodajwskaznikmianownik"]', function () {
        $("#listamianownik").append('<li class="list-group-item" id="' + $(this).attr('value') + '"><div class="row">' + $(this).text() + '<br></div><div class="row"><div class="col-sm-6"><form><label class="radio-inline"><input name="znak" type="radio" value="1" checked> +</label><label class="radio-inline"><input name="znak" type="radio" value="-1"> - </label></form></div><div class="col-sm-6"><button class="pull-right btn-sm btn-danger" id="remove">x</button></div></div></li>');
    });

    $(document).on('click', '[id^="remove"]', function () {
        $(this).parent('div').parent('div').parent('li').remove();
    });


    $("#addbtn").click(function () {

        var licznik = {};
        $("#listalicznik").children().each(function () {
            licznik['' + $(this).attr('id') + ''] = $(this).find('input').serialize();
        });

        var mianownik = {};
        $("#listamianownik").children().each(function () {
            mianownik['' + $(this).attr('id') + ''] = $(this).find('input').serialize();
        });

        dane = {
            id: $('#mainid').text(),
            tytul: $("#nazwa").val(),
            opis: $("#editor").html(),
            licznik: licznik,
            mianownik: mianownik

        };
        saveData(dane);
    });

});
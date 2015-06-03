$(document).ready(function() {

    var datepicker = $('#date');
    var posiedzenie = $('#posiedzenie_input');
    var komisja = $('#form_group_komisja');
    var dzielnica = $('#form_group_dzielnica');

    datepicker.datepicker({
        format: 'yyyy-mm-dd',
        language: 'pl'
    });

    var date = datepicker.datepicker('getFormattedDate');

    datepicker.on('changeDate', function(evt) {
        date = datepicker.datepicker('getFormattedDate');
    });

    posiedzenie
        .find('input')
        .first()
        .prop('checked', true);

    posiedzenie.find('input').each(function() {
        $(this).change(function() {
            var value = $(this).attr('value');
            komisja.addClass('hidden');
            dzielnica.addClass('hidden');
            switch(value) {
                case '2':
                    komisja
                        .removeClass('hidden')
                        .find('input')
                        .first()
                        .prop('checked', true);
                break;

                case '3':
                    dzielnica
                        .removeClass('hidden')
                        .find('input')
                        .first()
                        .prop('checked', true);
                break;
            }
        });
    });

    $('#create').click(function() {
        var type = $('input[name=typ_id]:checked').val();
        var data = {
            typ_id: type,
            date: date,
            komisja_id: type == '2' ? $('input[name=komisja_id]:checked').val() : 0,
            dzielnica_id: type == '3' ? $('input[name=dzielnica_id]:checked').val() : 0
        };

        $(this).html('Tworzenie sesji...');
        $(this).removeClass('btn-default');
        $(this).addClass('btn-info');

        $.post('/krakow/upload_sessions/addForm/', { data: data })
            .done(function(res) {
                var id = res.id;
                $(location).attr('href', '/krakow/upload_sessions/view/' + id);
            });
    });

});
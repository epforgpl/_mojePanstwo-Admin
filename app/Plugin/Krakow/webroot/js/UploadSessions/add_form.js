$(document).ready(function() {

    $('#posiedzenie_input input').change(function() {

        $('#form_group_komisja').hide();
        $('#form_group_dzielnica').hide();
        switch($(this).val()) {
            case '2':
                $('#form_group_komisja').show();
                $("#form_group_komisja input").first().prop("checked", true);
                $("#form_group_komisja input").first().change();
                break;

            case '3':
                $('#form_group_dzielnica').show();
                $("#form_group_dzielnica input").first().prop("checked", true);
                $("#form_group_dzielnica input").first().change();
                break;
        }
    });

    $.datepicker.regional['pl'] = {
        closeText: 'Zamknij',
        prevText: '&#x3c;Poprzedni',
        nextText: 'Następny&#x3e;',
        currentText: 'Dzi?',
        monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec',
            'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
        monthNamesShort: ['Sty','Lu','Mar','Kw','Maj','Cze',
            'Lip','Sie','Wrz','Pa','Lis','Gru'],
        dayNames: ['Niedziela','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
        dayNamesShort: ['Nie','Pn','Wt','Śr','Czw','Pt','So'],
        dayNamesMin: ['N','Pn','Wt','Śr','Cz','Pt','So'],
        weekHeader: 'Tydz',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['pl']);

    if(window.innerWidth > 1024) {
        $("#date").datepicker({
            showOptions: { direction: "down" },
            showOn: "both"
        }).datepicker("show");

        $('#ui-datepicker-div').css('display', 'block !important');
        $('#ui-datepicker-div').css('width', ($('#date').width() + 50) + 'px');

    } else {
        $("#date").datepicker({
            showOptions: { direction: "down" },
            showOn: "both"
        });
    }

    $("#posiedzenie_input input").first().prop("checked", true);
    $("#posiedzenie_input input").first().change();
});

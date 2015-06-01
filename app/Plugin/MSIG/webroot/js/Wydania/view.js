(function ($) {

    var d = $('#data');
    var parts = $.parseJSON(
        $('#data-json').attr('data-value')
    );

    if (parts.length == 0) {
        d.html('<p>Brak danych</p>');
        return true;
    }


    var h = ['<ul class="list-group">'];

    for (var i = 0; i < parts.length; i++) {
        if (parts.hasOwnProperty(i.toString())) {
            var part = parts[i];

            if(part['strona_od']==0 || part['strona_do']==0){
                h.push([
                    '<li class="list-group-item" style="background-color: #ffd3c2" >'
                ].join(''));
            }else{
                h.push([
                    '<li class="list-group-item">'
                ].join(''));
            }

            h.push([

                '<h4 class="list-group-item-heading">'+ part['nazwa'] + '</h4>'
            ].join(''));

            h.push([
                '<span class="pull-right">',
                'Strona OD: <input name="strona_od" value="' + part['strona_od'] + '"> ',
                'Liczba stron: <input name="liczba_stron" value="' + part['liczba_stron'] + '"> ',
                'Strona DO: <input name="strona_do" value="' + part['strona_do'] + '"> ',
                '</span><br>',
            ].join(''));

            h.push([
                '</li>'
            ].join(''));
        }
    }

    h.push([
        '</ul>'
    ].join(''));

    d.html(
        h.join('')
    );

}($));
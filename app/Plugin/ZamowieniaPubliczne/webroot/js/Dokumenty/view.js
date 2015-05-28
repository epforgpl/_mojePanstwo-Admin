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

            if(part['cena']<part['cena_min'] || part['cena']>part['cena_max']){
                h.push([
                    '<li class="list-group-item" style="background-color: #ffd3c2" >'
                ].join(''));
            }else{
                h.push([
                    '<li class="list-group-item">'
                ].join(''));
            }

            h.push([

                '<h4 class="list-group-item-heading">Nr. ' + part['numer'] + ', ' + part['nazwa'] + '</h4>',
                '<p class="list-group-item-text">' + part['data_zam'] + '</p>'
            ].join(''));

            h.push([
                '<span class="pull-right">',
                'Cena MIN: <input name="cena_min" value="' + part['cena_min'] + '"> ',
                'Cena: <input name="cena" value="' + part['cena'] + '"> ',
                'Cena MAX: <input name="cena_max" value="' + part['cena_max'] + '"> ',
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
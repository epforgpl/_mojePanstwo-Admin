
(function($) {

    var d = $('#data');
    var points = $.parseJSON(
        $('#data-json').attr('data-value')
    );

    if(points.length == 0) {
        d.html('<p>Brak danych</p>');
        return true;
    }

    var h = ['<ul class="list-group">'];

    for(var i = 0; i < points.length; i++) {
        if(points.hasOwnProperty(i.toString())) {
            var point = points[i];
            h.push([
                '<li class="list-group-item">',
                '<h4 class="list-group-item-heading">Nr. ' + point['nr'] + ', ' + point['czas'] + '</h4>',
                '<p class="list-group-item-text">' + point['tytul'] + '</p>'
            ].join(''));

            if(point.hasOwnProperty('osoby') && point['osoby'].length > 0) {
                h.push(['<b>Wystąpienia</b>', '<ol class="margin-top-5">'].join(''));
                for(var o = 0; o < point['osoby'].length; o++) {
                    if(point['osoby'].hasOwnProperty(o.toString())) {
                        var osoba = point['osoby'][o];
                        h.push([
                            '<li>',
                            osoba.nazwa,
                            ', ',
                            osoba.stanowisko,
                            ', ',
                            osoba.czas_str,
                            '</li>'
                        ].join(''));
                    }
                }
                h.push(['</ol>'].join(''));
            }

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
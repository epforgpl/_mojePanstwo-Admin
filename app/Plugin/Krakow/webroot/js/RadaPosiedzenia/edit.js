
String.prototype.toHHMMSS=function(){var sec_num=parseInt(this,10);var hours=Math.floor(sec_num/3600);var minutes=Math.floor((sec_num-(hours*3600))/60);var seconds=sec_num-(hours*3600)-(minutes*60);if(hours<10){hours="0"+hours}if(minutes<10){minutes="0"+minutes}if(seconds<10){seconds="0"+seconds}var time=hours+':'+minutes+':'+seconds;return time};

$.fn.StopWatch = function() {

    var _this = this;

    _this.time = 0;
    _this.on = false;

    var interval;

    var update = function() {
        var time = String(_this.time).toHHMMSS();
        _this.find('input').attr('data-time', _this.time);
        _this.find('input').val(time);
    };

    var start = function() {
        if(_this.on)
            return true;

        interval = setInterval(function() {
            _this.time++;
            update();
        }, 1000);

        _this.on = true;
    };

    var stop = function() {
        if(!_this.on)
            return true;

        clearInterval(interval);
        _this.on = false;
    };

    var reset = function() {
        _this.time = 0;
        update();
    };

    $(this).html([
        '<div class="input-group">',
            '<span class="input-group-addon">Stoper</span>',
            '<input type="text" data-time="0" class="form-control" value="00:00:00" disabled>',
            '<span class="input-group-btn">',
                '<button data-action="start" class="btn btn-default" type="button">Start</button>',
                '<button data-action="stop" class="btn btn-default" type="button">Stop</button>',
                '<button data-action="reset" class="btn btn-default" type="button">Reset</button>',
            '</span>',
        '</div>'
    ].join(''));

    /* $(this).find('input')
        .css('border-width', 0)
        .css('box-shadow', 'none'); */

    $(this).find('button').bind('click', function() {
        var action = $(this).attr('data-action');
        switch(action) {
            case 'start':
                start();
            break;

            case 'stop':
                stop();
            break;

            case 'reset':
                reset();
            break;

            default: break;
        }
    });

    return _this;
};

var Posiedzenie = {

    id: 0,
    date: null,
    points: [],

    init: function() {
        this.id = $('#data-posiedzenie-id').attr('data-value');
        this.date = $('#data-posiedzenie-date').attr('data-value');
        var _this = this;

        _this.points = $.parseJSON(
            $('#data-json').attr('data-value')
        );

        _this.updatePointsDOM();

        $('#import').click(function() {
            _this.import();
        });

        $('#add').click(function() {
            _this.addPoint();
        });

        $('#save').click(function() {
            _this.save();
        });
    },

    save: function() {
        var points = this.fetchPointsDOM();
        $.post('/krakow/rada_posiedzenia/edit/' + this.id, { points: points })
            .done(function(res) {
                alert('Zmiany zostały zapisane.');
            });
    },

    updatePointsDOM: function() {
        var list = $('#points');
        var _h = [];

        for(i in this.points) {
            if(this.points.hasOwnProperty(i)) {
                var point = this.points[i];
                _h.push(
                    this.getPointTemplate(i, point)
                );
            }
        }

        list.html(
            _h.join('')
        );

        list.sortable({
            handle: '.handle'
        }).bind('sortupdate', function() {

        });

        $('textarea').keyup(function(e) {
            while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
                $(this).height($(this).height()+1);
            };
        });

        var _this = this;

        $('.osoba-delete').click(function() {
            var group = $(this).closest('.list-group-item').first();
            var row = $(this).closest('.row').first();
            var index = group.attr('data-index');
            var osoba_index = $(this).attr('data-index');

            _this.points = _this.fetchPointsDOM();
            if(_this.points.hasOwnProperty(index)) {
                if(_this.points[index].osoby.hasOwnProperty(osoba_index)) {
                    _this.points[index].osoby.splice(osoba_index, 1);
                    row.hide(400, function() {
                        $(this).remove();
                        _this.updatePointsDOM();
                    });
                }
            }
        });

        $('.osoba-stoper').click(function() {
            var group = $(this).closest('.list-group-item').first();
            var row = $(this).closest('.row').first();
            var input = row.find('input[name=czas]').first();
            var time = $('#stopwatch input').attr('data-time');
            input.val(
                String(time).toHHMMSS()
            );
        });

        $('.stoper-ctrl span.item-stoper').click(function() {
            var p = $(this).closest('.stoper-ctrl').first();
            var input = p.find('input').first();
            var time = $('#stopwatch input').attr('data-time');
            input.val(
                String(time).toHHMMSS()
            );
        });

        list.find('.remove').click(function() {
            var group = $(this).parent('.list-group-item');
            var index = group.attr('data-index');
            _this.points.splice(index, 1);
            group.hide(400, function() {
                $(this).remove();
            });
        });

        list.find('.add').click(function() {
            var group = $(this).parent('.list-group-item');
            var index = group.attr('data-index');
            _this.points = _this.fetchPointsDOM();

            if(!_this.points[index].osoby)
                _this.points[index].osoby = [];

            _this.points[index].osoby.push({
                id: 0,
                nazwa: '',
                stanowisko: '',
                czas: '00:00:00'
            });
            _this.updatePointsDOM();
        });

        $('textarea').each(function(e) {
            while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
                $(this).height($(this).height()+1);
            };
        });
    },

    getPointTemplate: function(i, point) {

        var _html = [
            '<li class="list-group-item" data-index="' + i + '" data-id="' + point.id +'">',
            '<span class="glyphicon glyphicon-move handle" aria-hidden="true"></span>',
            '<div class="form-group-pr sm">',
            '<input class="form-control input-sm" type="text" value="' + point.nr + '" name="nr" placeholder="Numer"/>',
            '</div>',
            '<div class="form-group-pr sm ext stoper-ctrl">',
            '<input class="form-control input-sm" type="text" value="' + ((point.czas) ? point.czas : '') + '" name="czas" placeholder="HH:MM:SS"/>',
            '<span class="glyphicon glyphicon-screenshot item-stoper" aria-hidden="true"></span>',
            '</div>',
            '<div class="form-group-pr">',
            '<textarea class="form-control input-sm" type="text" name="tytul" placeholder="Tytuł">',
            point.tytul,
            '</textarea>'
        ];

        if(point.osoby && point.osoby.length) {
            for(var i = 0; i < point.osoby.length; i++) {
                if(point.osoby.hasOwnProperty(i)) {
                    var osoba = point.osoby[i];
                    osoba.czas = osoba.czas_str;
                    _html.push('<div class="row" data-id="' + osoba.id + '">');
                    _html.push('<div class="col-sm-4">');
                    _html.push('<input type="text" class="form-control input-sm" name="nazwa" placeholder="Imię Nazwisko" value="' + osoba.nazwa + '"/>');
                    _html.push('</div>');
                    _html.push('<div class="col-sm-4">');
                    _html.push('<input type="text" class="form-control input-sm" name="stanowisko" placeholder="Stanowisko" value="' + osoba.stanowisko + '"/>');
                    _html.push('</div>');
                    _html.push('<div class="col-sm-2">');
                    _html.push('<input type="text" class="form-control input-sm" name="czas" placeholder="HH:MM:SS" value="' + osoba.czas + '"/>');
                    _html.push('</div>');
                    _html.push('<div class="col-sm-2">');
                    _html.push('<span data-index="' + i + '" class="glyphicon glyphicon-trash osoba-delete" aria-hidden="true"></span>');
                    _html.push('<span data-index="' + i + '" class="glyphicon glyphicon-screenshot osoba-stoper" aria-hidden="true"></span>');
                    _html.push('</div>');
                    _html.push('</div>');
                }
            }
        }

        _html.push('</div>');

        if( Number(point.start_time) || Number(point.stop_time) )
            _html.push('<div class="timers"><span>' + point.start_time.toHHMMSS() + ' - ' + point.stop_time.toHHMMSS() + '</span></div>');

        _html.push('<a href="/krakow/rada_posiedzenia_punkty_sesja/' + point.id +'"><span class="glyphicon glyphicon-arrow-right move-to-debata" aria-hidden="true"></span></a>');
        _html.push('<span class="glyphicon glyphicon-trash remove" aria-hidden="true"></span>');
        _html.push('<span class="glyphicon glyphicon-plus-sign add" aria-hidden="true"></span>');
        _html.push('</li>');

        return _html.join('');
    },

    fetchPointsDOM: function() {
        var points = [];

        $('#points li.list-group-item').each(function() {
            var id = $(this).attr('data-id');
            var nr = $(this).find('input[name="nr"]').val();
            var tytul = $(this).find('textarea[name="tytul"]').val();
            var czas = $(this).find('input[name="czas"]').val();
            var osoby = [];

            $(this).find('.row').each(function() {
                var id = $(this).attr('data-id');
                var nazwa = $(this).find('input[name="nazwa"]').val();
                var czas = $(this).find('input[name="czas"]').val();
                var stanowisko = $(this).find('input[name="stanowisko"]').val();
                osoby.push({
                    id: id,
                    nazwa: nazwa,
                    stanowisko: stanowisko,
                    czas: czas
                });
            });

            points.push({
                id: id,
                nr: nr,
                czas: czas,
                tytul: tytul,
                osoby: osoby
            });

        });

        return points;
    },

    addPoint: function() {
        this.points = this.fetchPointsDOM();
        this.points.push({
            id: 0,
            tytul: '',
            nr: '',
            czas: '00:00:00',
            osoby: []
        });
        this.updatePointsDOM();
    },

    import: function() {
        if(this.points.length > 0) {
            alert('Punkty zostały już wpisane.');
            return false;
        }

        var _this = this;

        $.post('/krakow/rada_posiedzenia/importData', { date: _this.date })
            .done(function(res) {
                var points = [];
                for(var i = 0; i < res.length; i++) {
                    if(res.hasOwnProperty(i)) {
                        var _data = res[i][0];
                        points.push({
                            id: 0,
                            czas: '00:00:00',
                            tytul: _data.tytul,
                            nr: _data.nr,
                            osoby: []
                        });
                    }
                }

                _this.points = points;
                _this.updatePointsDOM();
            });
    }

};

$('#stopwatch').StopWatch();
Posiedzenie.init();
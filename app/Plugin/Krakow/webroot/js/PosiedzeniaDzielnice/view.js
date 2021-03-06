
String.prototype.toHHMMSS = function() {
    var sec_num = parseInt(this, 10);
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);
    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    var time = hours + ':' + minutes + ':' + seconds;
    return time;
};

var strToTime = function(i) {
    var res = i.split(':');
    if(res.length == 3) {
        var s = res[0] + res[1] + res[2];
    }

    var v = [36000, 3600, 600, 60, 10 , 1];
    var t = 0;
    var str = s ? s : String(i);
    var l = 6 - str.length + 1;
    var m = l > 0 ? new Array(l).join('0') : '';
    str = m + str;
    for(var i = 0; i < str.length; i++) {
        t += v[i] * parseInt(str[i]);
    }

    return t;
};

var Posiedzenie = function(id, data, el) {
    this.id = id;
    this.data = data;
    this.el = el;
    this.video = null;
    this.active = null;
    this.i = 0;
    this.init();

    console.log(data);
};

Posiedzenie.prototype.init = function() {
    var t = this;
    var e = t.el;

    e.html(
        this.getDOM()
    );

    var f = e.find('.list-group.debaty a').first();
    this.setActive(f);
    this.createVideo();

    $('.list-group.debaty a').click(function() {
        t.setActive(
            $(this)
        );

        return false;
    });

};

Posiedzenie.prototype.createVideo = function() {
    var t = this;
    var ev = t.el.find('.posiedzenie-video').first();

    ev.html([
        '<div class="panel panel-default">',
            '<div class="panel-heading">',
                '<div class="loader pull-right hidden"></div>',
                '<code id="video-time" class="pull-right hidden">00:00:00</code>',
                '<h3 class="panel-title">Posiedzenie</h3>',
            '</div>',
            '<div class="panel-body">',
                '<video id="video" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto">',
                    'Twoja przeglądarka nie obsługuje video',
                '</video>',
            '</div>',
            '<div class="panel-footer">',
                '<div class="btn-group btn-group-justified" role="group">',
                    '<div class="btn-group" role="group">',
                        '<button id="set-time" type="button" class="btn btn-default">',
                        '<span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span>&nbsp;',
                            'Przejdź do czasu..',
                        '</button>',
                    '</div>',
                '</div>',
            '</div>'
    ].join(''));

    this.getVideoSrc(function(src) {
        t.video = videojs('video', {
            controls: true,
            autoplay: false,
            preload: 'none',
            width: 524,
            height: 300
        }).ready(function() {
            ev.find('.loader').first().removeClass('hidden');
            this.src({
                type: "video/mp4",
                src: src
            });
            this.load();
        });

        t.video.on('loadeddata', function(e) {
            ev.find('.loader').first().addClass('hidden');
            ev.find('#video-time').first().removeClass('hidden');

            if(t.active) {
                t.video.currentTime(
                    parseInt(t.active.video_start)
                );
            }
        });

        t.video.on('loadeddata', function(evt) {
            t.updateVideoTimer();
        }.bind(this));

        t.video.on('loadedalldata', function(evt) {
            t.updateVideoTimer();
        }.bind(this));

        t.video.on('timeupdate', function(evt) {
            t.updateVideoTimer();
        }.bind(this));

        t.video.on('pause', function(evt) {
            t.updateVideoTimer();
        }.bind(this));

        t.video.on('play', function(evt) {
            t.updateVideoTimer();
        }.bind(this));

    });

    $('#set-time').click(function() {
        var time = String((t.video != null) ? t.video.currentTime() : 0).toHHMMSS();
        var newTime = strToTime(
            prompt('Przejdź do: ', time)
        );

        if(t.video) {
            t.video.currentTime(
                parseInt(newTime)
            );
        }
    });

};

Posiedzenie.prototype.getVideoSrc = function(onSuccess) {
    $.post('/s3/getAuthenticatedURL', {
        bucket: 'stanczyk',
        uri: 'rady/komisje/' + this.id + '.mp4'
    })
        .done(function(res) {
            onSuccess(res.url);
        });
};

Posiedzenie.prototype.setActive = function(el) {
    var t = this;
    var e = t.el;

    if(el === undefined) {
        var a = e.find('.list-group.debaty a').first();
        if(a)
            el = a;
    }

    e.find('.list-group.debaty a').each(function() {
        $(this).removeClass('active');
    });

    el.addClass('active');
    var debata_id = el.attr('data-id');
    t.showEditPanel(debata_id);

    $('.list-group.mowcy li button').click(function() {
        var li = $(this).parent('li').first();
        var mowca_id = li.attr('data-id');
        t.removeMowca(li, mowca_id, debata_id);
    });

    $('#add_mowca').click(function() {
        var input = $('#autocomplete');
        var nazwa = String(input.val()).replace(/<\/?[^>]+(>|$)/g, '');
        if(nazwa == '')
            return false;
        t.addMowca(nazwa, 0, debata_id);
        input.val(null);
    });
};

Posiedzenie.prototype.removeMowca = function(li, mowca_id, debata_id) {
    if(!confirm('Czy na pewno chcesz usunąć tego mówce?'))
        return false;

    for(var d = 0; d < this.data.length; d++) {
        if(this.data.hasOwnProperty(d)) {
            if(this.data[d].id == debata_id) {
                for(var m = 0; m < this.data[d].mowcy.length; m++) {
                    if(this.data[d].mowcy.hasOwnProperty(m)) {
                        if(this.data[d].mowcy[m].id == mowca_id) {
                            this.data[d].mowcy.splice(m, 1);
                            li.hide(200, function() {
                                $(this).remove();
                            });
                        }
                    }
                }
            }
        }
    }
};

Posiedzenie.prototype.addMowca = function(nazwa, id, debata_id) {
    for(var d = 0; d < this.data.length; d++) {
        if (this.data.hasOwnProperty(d)) {
            if(this.data[d].id == debata_id) {
                if(this.data[d].mowcy.length > 0) {
                    var debata = this.data[d];
                    var ord = parseInt(debata.mowcy[
                        debata.mowcy.length - 1
                            ].ord) + 1;
                } else var ord = 0;

                this.data[d].mowcy.push({
                    id: id,
                    ord: ord,
                    nazwa: nazwa
                });

                var el = $('.list-group.debaty a[data-id="' + debata_id + '"]').first();
                this.setActive(el);
            }
        }
    }
};

Posiedzenie.prototype.showEditPanel = function(id) {
    var t = this;
    var e = t.el;
    var ep = e.find('.posiedzenie-edit').first();
    var ob = null;
    for(var i = 0; i < this.data.length; i++) {
        if(this.data.hasOwnProperty(i)) {
            var o = this.data[i];
            if(o.id == id) {
                ob = o;
                break;
            }
        }
    }

    if(ob) {
        t.active = ob;

        if(t.video) {
            t.video.currentTime(
                parseInt(t.active.video_start)
            );
        }

        ep.html(
            t.getEditPanelDOM(ob)
        );

        $('#autocomplete').autocomplete({
            serviceUrl: '/krakow/posiedzenia_komisje/getAutocompleteMowcy',
            onSelect: function(suggestion) {
                t.addMowca(suggestion.value, suggestion.id, id);
            }
        });

        $('#save_active_time').click(function() {
            if(t.active && t.video) {

                t.active.video_start = t.video.currentTime();
                var e = $('.list-group.debaty a[data-id="' + t.active.id + '"] code.time').first();
                e.html(
                    String(t.active.video_start).toHHMMSS()
                );

                for(var i = 0; i < t.data.length; i++) {
                    if(t.data.hasOwnProperty(i)) {
                        t.data[i].video_start = t.active.video_start;
                        break;
                    }
                }
            }
        });

        $('#save_title').click(function() {
            var title = String($('#title').val()).replace(/<\/?[^>]+(>|$)/g, '');
            if(t.active && title != '') {
                for(var i = 0; i < t.data.length; i++) {
                    if (t.data.hasOwnProperty(i)) {
                        if (t.data[i].id == t.active.id) {
                            t.data[i].tytul = title;
                            var span = $('.list-group.debaty a[data-id="' + t.active.id + '"] .title').first();
                            span.html(
                                title
                            );
                        }
                    }
                }
            }
        });

        $('#delete').click(function() {
            if(!confirm('Czy na pewno chcesz usunac ten punkt?'))
                return false;

            for(var i = 0; i < t.data.length; i++) {
                if(t.data.hasOwnProperty(i)) {
                    if(t.data[i].id == t.active.id) {
                        t.data.splice(i, 1);
                        var a = $('.list-group.debaty a[data-id="' + t.active.id + '"]').first();
                        a.hide(200, function() {
                            $(this).remove();
                            t.setActive();
                        });

                        if(t.data.length == 0) {
                            var l = t.el.find('.posiedzenie-list').first();
                            l.html(t.getListDOM());
                        }

                        break;
                    }
                }
            }
        });
    }
};

Posiedzenie.prototype.getEditPanelDOM = function(ob) {
    var h = [
        '<div class="panel panel-default">',
            '<div class="panel-body">',
                '<textarea class="form-control" id="title" rows="5">' + ob.tytul + '</textarea>',
                '<ul class="list-group mowcy margin-top-10">'
    ];

    for(var i = 0; i < ob.mowcy.length; i++) {
        if(ob.mowcy.hasOwnProperty(i)) {
            var m = ob.mowcy[i];
            h.push('<li class="list-group-item" data-id="' + m.id + '"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="nazwa">' + m.nazwa + '</span></li>');
        }
    }

    h.push([
                '</ul>',
                '<div class="input-group margin-top-10">',
                    '<input type="text" id="autocomplete" class="form-control" placeholder="Nowy mówca..">',
                    '<span class="input-group-btn">',
                        '<button id="add_mowca" class="btn btn-default" type="button">',
                            '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                        '</button>',
                    '</span>',
                '</div>',
            '</div>',
            '<div class="panel-footer">',
                '<div class="btn-group btn-group-sm btn-group-justified" role="group">',
                    '<div class="btn-group" role="group">',
                        '<button id="delete" type="button" class="btn btn-default">',
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;',
                            'Usuń',
                        '</button>',
                    '</div>',
                    '<div class="btn-group" role="group">',
                        '<button id="save_active_time" type="button" class="btn btn-default">',
                            '<span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;',
                            'Zapisz czas',
                        '</button>',
                    '</div>',
                    '<div class="btn-group" role="group">',
                        '<button id="save_title" type="button" class="btn btn-default">',
                            '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp;',
                            'Zapisz',
                        '</button>',
                    '</div>',
                '</div>',
            '</div>',
        '</div>'
    ].join(''));

    return h.join('');
};

Posiedzenie.prototype.getDOM = function() {
    var h = [
        '<div class="row margin-top-20">',
            '<div class="col-sm-6">',
                '<div class="posiedzenie-video"></div>',
                '<div class="posiedzenie-edit"></div>',
            '</div>',
            '<div class="col-sm-6">',
                '<div class="posiedzenie-list">',
                    this.getListDOM(),
                '</div>',
            '</div>',
        '</div>'
    ];

    return h.join('');
};

Posiedzenie.prototype.updateVideoTimer = function() {
    if(this.video) {
        $('#video-time').html(
            String(this.video.currentTime()).toHHMMSS()
        );
    }
};

Posiedzenie.prototype.getListDOM = function() {
    if(this.data.length == 0) {
        return '<div class="alert alert-info" role="alert">Brak punktów</div>';
    }

    var h = ['<div class="list-group debaty">'];

    for(var i = 0; i < this.data.length; i++) {
        if(this.data.hasOwnProperty(i)) {
            var o = this.data[i];
            h.push([
                '<a class="list-group-item" data-id="' + o.id + '">',
                    '<code class="time">',
                        String(o.video_start).toHHMMSS(),
                    '</code>',
                    '<span class="title">',
                        o.tytul,
                    '</span>',
                '</a>'
            ].join(''));
        }
    }

    h.push('</div>');
    return h.join('');
};

Posiedzenie.prototype.createNewElemenet = function() {
    var t = this;

    var ord = (t.data.length > 0) ? parseInt(t.data[t.data.length - 1].ord) + 1: 0;
    var id = '_' + t.i;

    t.data.push({
        id: id,
        mowcy: [],
        ord: ord,
        tytul: 'Tytuł',
        video_start: '0'
    });

    var l = t.el.find('.posiedzenie-list').first();
    l.html(t.getListDOM());

    var el = $('.list-group.debaty a[data-id="' + id + '"]').first();
    t.setActive(el);

    $('.list-group.debaty a').click(function() {
        t.setActive(
            $(this)
        );

        return false;
    });

    t.i++;
};

Posiedzenie.prototype.getData = function() {
    var d = this.data;
    return d;
};

$(document).ready(function() {
    var data = JSON.parse(
        $('#data-json').attr('data-value')
    );

    var id = $('#data-posiedzenie-id').attr('data-value');

    var p = new Posiedzenie(
        id,
        data,
        $('#posiedzenie')
    );

    $('#add').click(function() {
        p.createNewElemenet();
    });

    $('#save').click(function() {
        var data = p.getData();
        if(data.length == 0) {
            alert('Brak danych do zapisania');
            return false;
        }

        var btn = $(this);

        btn.html('Trwa zapisywanie...')
            .removeClass('btn-default')
            .addClass('btn-info');

        $.post('/krakow/posiedzenia_dzielnice/view/' + p.id, { data: data })
            .done(function(res) {
                console.log(res);

                btn.html('Zapisano poprawnie')
                    .removeClass('btn-info')
                    .addClass('btn-success');

                setTimeout(function() {
                    btn.html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp; Zapisz')
                        .removeClass('btn-success')
                        .addClass('btn-default');
                }, 2000);
            });

        console.log(data);
    });

});
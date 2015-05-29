
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

function Player(options) {

    this.type = options.type;
    this.files = options.files;
    this.data = options.data;
    this.active = options.active;
    this.toggleActiveCallback = function() {};
    this.video = false;
    this.config = false;
    this.time = 0;

    this.initialize();
}

Player.prototype.initialize = function() {
    this.getElement()
        .html(this.getDOM());

    this.updateConfig();
    this.createVideo();

    var _this = this;
    this.getElement().find('button').first().click(function(e) {
        _this.setConfig();
    });

    this.getElement().find('select').first().change(function(e) {
        _this.setConfig();
    });

    this.getElement().find('.panel-heading').first().click(function(e) {
        if(!_this.active)
            _this.setActive(true);
    });
};

Player.prototype.updateConfig = function() {
    this.getConfigElement()
        .html(this.getConfigDOM());

    var _this = this;
    this.getConfigElement().find('button').first().click(function(e) {
        if(_this.video)
            _this.video.dispose();
        _this.initialize();
    });
};

Player.prototype.setConfig = function() {
    if(!this.video)
        return;

    var time = String(this.video.currentTime());
    var file_id = this.getElement().find('select').first().val();

    this.config = {
        time: time,
        file_id: file_id
    };

    this.updateConfig();
};

Player.prototype.getFile = function(id) {
    var file = false;
    for(var i = 0; i < this.files.length; i++) {
        if(this.files.hasOwnProperty(i)) {
            if(this.files[i].id == id) {
                file = this.files[i];
                break;
            }
        }
    }
    return file;
};

Player.prototype.getElement = function() {
    return $('div[data-name="video"][data-type="' + this.type + '"]');
};

Player.prototype.getConfigElement = function() {
    return $('div[data-name="config"][data-type="' + this.type + '"]');
};

Player.prototype.getConfigDOM = function() {

    var file = this.getFile(
        this.getConfig().file_id
    );

    return [
        'Czas ' + this.type,
        '<code class="pull-right">' + (file ? file.filename : 'brak') + '</code>',
        '<div class="input-group input-group-sm margin-top-5">',
            '<input type="text" class="form-control" value="' + this.getConfig().time.toHHMMSS() + '" disabled>',
            '<span class="input-group-btn">',
                '<button class="btn btn-default" type="button">Pokaż</button>',
            '</span>',
        '</div>'
    ].join('');
};

Player.prototype.getFormSelectDOM = function() {
    if(!this.files || !this.files.length)
        return [
            '<p>',
                'Brak plików',
            '</p>'
        ].join('');

    var config = this.getConfig();
    var h = ['<select class="form-control">'];

    for(var i = 0; i < this.files.length; i++) {
        if(this.files.hasOwnProperty(i)) {
            var file = this.files[i];
            var selected = (config.file_id && config.file_id == file.id);
            h.push([
                '<option value="' + file.id + '"' + (selected ? ' selected' : '') + '>',
                    file.filename,
                '</option>'
            ].join(''));
        }
    }

    h.push('</select>');
    return h.join('');
};

Player.prototype.onActive = function() {};

Player.prototype.setActive = function(active) {
    this.active = active;
    var panel = this.getElement().find('.panel').first();
    if(this.active) {
        panel.removeClass('panel-default');
        panel.addClass('panel-info');
        this.onActive();
    } else {
        panel.removeClass('panel-info');
        panel.addClass('panel-default');
    }
};

Player.prototype.getDOM = function() {
    return [
        '<div class="panel ' + (this.active ? 'panel-info' : 'panel-default') + '">',
            '<div class="panel-heading">',
                '<div class="loader pull-right hidden"></div>',
                '<h3 class="panel-title">' + (this.type.charAt(0).toUpperCase() + this.type.substring(1)) + '</h3>',
            '</div>',
            '<div class="panel-body">',
                '<div class="row">',
                    '<div class="col-sm-6">',
                        this.getFormSelectDOM(),
                    '</div>',
                    '<div class="col-sm-3">',
                        '<input type="text" size="20" value="' + this.getConfig().time.toHHMMSS() +'" class="form-control" placeholder="00:00:00" disabled>',
                    '</div>',
                    '<div class="col-sm-3">',
                        '<button type="submit" class="btn btn-primary pull-right">Ustaw ' + this.type + '</button>',
                    '</div>',
                '</div>',
                '<video id="video_' + this.type + '" class="video-js vjs-default-skin vjs-big-play-centered margin-top-10" controls preload="auto">',
                    'Twoja przeglądarka nie obsługuje video',
                '</video>',
            '</div>',
        '</div>'
    ].join('');
};

Player.prototype.translateTime = function(t) {
    var time = Number(t);
    var file = false;
    for(var i = 1; i < this.files.length; i++) {
        var start_time = Number(this.files[i]['posiedzenie_czas_start']);
        if(time < start_time) {
            file = this.files[i - 1];
            break;
        }
    }

    if(!file)
        file = this.files[this.files.length - 1];

    if(!file)
        return false;

    var file_time = time - Number(file['posiedzenie_czas_start']);

    return {
        file: file['id'],
        time: time
    };
};

Player.prototype.getConfig = function() {

    if(this.config)
        return this.config;

    var start_filetime = this.translateTime(this.data.czas);

    if(this.type == 'start') {

        var start_player_init_file_id = false;
        if(this.data.czas)
            start_player_init_file_id = start_filetime['file'];
        if(this.data.prev && Number(this.data.prev.stop_file_id))
            start_player_init_file_id = this.data.prev.stop_file_id;
        if( /*data.czas_akcept=='1' &&*/ Number(this.data.start_file_id) ) {
            start_player_init_file_id = this.data.start_file_id;
        }
        var start_player_init_time = false;
        if( this.data.czas )
            start_player_init_time = start_filetime['time'];
        if( this.data.prev && Number(this.data.prev.stop_time) )
            start_player_init_time = this.data.prev.stop_time;
        if( /*data.czas_akcept=='1' &&*/  Number(this.data.start_time) ) {
            start_player_init_time = this.data.start_time;
        }

        this.config = {
            time: String(start_player_init_time),
            file_id: start_player_init_file_id
        }

    } else {

        var stop_player_init_file_id = false;
        if( this.data.czas )
            stop_player_init_file_id = start_filetime['file'];
        if( this.data.prev && Number(this.data.prev.stop_file_id) )
            stop_player_init_file_id = this.data.prev.stop_file_id;
        if( /*data.czas_akcept=='1' &&*/ Number(this.data.stop_file_id) ) {
            stop_player_init_file_id = this.data.stop_file_id;
        }
        var stop_player_init_time = false;
        if( this.data.czas ) {
            stop_player_init_time = start_filetime['time'];
            if( this.data.next && Number(this.data.next.czas) ) {
                var stop_filetime = this.translateTime( this.data.next.czas);
                stop_player_init_file_id = stop_filetime['file'];
                stop_player_init_time = stop_filetime['time'];
            }
        }
        if( this.data.prev && Number(this.data.prev.stop_time) )
            stop_player_init_time = Number(this.data.prev.stop_time) + Number(this.data.next.czas) - Number(this.data.czas);
        if( /*data.czas_akcept=='1' &&*/ Number(this.data.stop_time) )
            stop_player_init_time = this.data.stop_time;

        this.config = {
            time: String(stop_player_init_time),
            file_id: stop_player_init_file_id
        }

    }

    return this.config;
};

Player.prototype.createVideo = function() {

    var config = this.getConfig();
    var _this = this;

    this.video = videojs('video_' + this.type, {
        controls: true,
        autoplay: false,
        preload: 'none',
        width: 524,
        height: 300
    }).ready(function() {
        _this.getElement().find('.loader').first().removeClass('hidden');
        this.src({
            type: "video/mp4",
            src: 'http://stanczyk.sds.tiktalik.com/rady/input/' + config.file_id + '.mp4'});
        this.load();
    });

    var video = this.video;

    this.video.on('loadeddata', function(e) {
        if(config.time) {
            video.currentTime(config.time);
        }

        _this.getElement().find('.loader').first().addClass('hidden');
    });

    this.video.on('timeupdate', function(e) {
        _this.updateCurrentTime();
    }.bind(this));

    this.video.on('pause', function(e) {
        _this.updateCurrentTime();
    }.bind(this));

    this.video.on('play', function(e) {
        _this.updateCurrentTime();
    }.bind(this));

};

Player.prototype.updateCurrentTime = function() {
    if(!this.video)
        return;

    this.getElement().find('input').first()
        .val(String(this.video.currentTime()).toHHMMSS());
};

Player.prototype.playToggle = function() {
    if(!this.video || !this.active)
        return;

    if(this.video.paused)
        this.video.play();
    else
        this.video.pause();

    this.updateCurrentTime();
};

Player.prototype.rewind = function() {
    if(!this.video || !this.active)
        return;

    this.video.currentTime(
        this.video.currentTime() - 3
    );

    this.updateCurrentTime();
};

Player.prototype.rewindLong = function() {
    if(!this.video || !this.active)
        return;

    this.video.currentTime(
        this.video.currentTime() - 30
    );

    this.updateCurrentTime();
};

Player.prototype.forward = function() {
    if(!this.video || !this.active)
        return;

    this.video.currentTime(
        this.video.currentTime() + 3
    );

    this.updateCurrentTime();
};

Player.prototype.forwardLong = function() {
    if(!this.video || !this.active)
        return;

    this.video.currentTime(
        this.video.currentTime() + 30
    );

    this.updateCurrentTime();
};

Player.prototype.reset = function() {
    if(!this.video || !this.active)
        return;

    var video = this.video;

    video.dispose();
    video.createVideo();
    video.pause();
};

$(document).ready(function() {

    var data = JSON.parse(
        $('#data-item').attr('data-json')
    );

    var files = JSON.parse(
        $('#data-files').attr('data-json')
    );

    if(!files || !files.length)
        return;

    var start = new Player({
        type: 'start',
        files: files,
        data: data,
        active: true
    });

    var stop = new Player({
        type: 'stop',
        files: files,
        data: data,
        active: false
    });

    start.onActive = function() {
        stop.setActive(false);
    };

    stop.onActive = function() {
        start.setActive(false);
    };

    var save = function() {
        var id = $('#data-id').attr('data-value');
        var title = $('#inputTitle').val();
        var desc = $('#inputDesc').val();
        var saveBtn = $('#save');

        $.post('/krakow/rada_posiedzenia_punkty_sesja/' + id, {
            id: id,
            title: title,
            desc: desc,
            start: start.config,
            stop: stop.config
        })
            .done(function(res) {
                if(res.success.Punkty) {
                    saveBtn.html('Zapisano poprawnie');
                } else {
                    saveBtn.html('Wystąpił błąd');
                }

                setTimeout(function() {
                    saveBtn.html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&nbsp; Zapisz');
                    saveBtn.removeClass('btn-success');
                    saveBtn.addClass('btn-default');
                }, 2000);
            });

        saveBtn.html('Trwa zapisywanie...');
        saveBtn.removeClass('btn-default');
        saveBtn.addClass('btn-success');
    };

    $(this).keyup(function(event) {
        var s = (event.ctrlKey || event.altKey);
        if(s && event.keyCode == 83) { save(); return false; } // s
        else if(s && event.keyCode == 75) { stop.playToggle(); start.playToggle(); return false; } // k
        else if(s && event.keyCode == 72) { stop.rewindLong(); start.rewindLong(); return false; } // h
        else if(s && event.keyCode == 74) { stop.rewind(); start.rewind(); return false; } // j
        else if(s && event.keyCode == 76) { stop.forward(); start.forward(); return false; } // l
        else if(s && event.keyCode == 82) { start.reset(); return false; } // r
        else if(s && event.keyCode == 84) { stop.reset(); return false; } // t
        else if(s && (event.keyCode == 59 || event.keyCode == 186)) { stop.forwardLong(); start.forwardLong(); return false; } // semi-colon
    });

    $('#save').click(function() {
        save();
    });

});
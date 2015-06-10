
var Posiedzenie = function(data, el) {
    this.data = data;
    this.el = el;
    this.init();
};

Posiedzenie.prototype.init = function() {
    var t = this;
    var e = t.el;

    e.html(
        this.getDOM()
    );

    var f = e.find('.list-group.debaty a').first();
    this.setActive(f);

    $('.list-group.debaty a').click(function() {
        t.setActive(
            $(this)
        );

        return false;
    });
};

Posiedzenie.prototype.setActive = function(el) {
    var t = this;
    var e = t.el;
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
                var debata = this.data[d];
                var ord = parseInt(debata.mowcy[
                    debata.mowcy.length - 1
                    ].ord) + 1;

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
        ep.html(
            t.getEditPanelDOM(ob)
        );

        $('#autocomplete').autocomplete({
            serviceUrl: '/krakow/posiedzenia_komisje/getAutocompleteMowcy',
            onSelect: function(suggestion) {
                t.addMowca(suggestion.value, suggestion.id, id);
            }
        });
    }
};

Posiedzenie.prototype.getEditPanelDOM = function(ob) {
    var h = [
        '<div class="panel panel-default">',
            '<div class="panel-body">',
                '<textarea class="form-control" rows="5">' + ob.tytul + '</textarea>',
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
                '<div class="btn-group btn-group-justified" role="group">',
                    '<div class="btn-group" role="group">',
                        '<button id="close" type="button" class="btn btn-default">',
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;',
                            'Usuń',
                        '</button>',
                    '</div>',
                    '<div class="btn-group" role="group">',
                        '<button id="save" type="button" class="btn btn-default">',
                            '<span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;',
                            'Zapisz czas',
                        '</button>',
                    '</div>',
                    '<div class="btn-group" role="group">',
                        '<button id="save" type="button" class="btn btn-default">',
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

Posiedzenie.prototype.getListDOM = function() {
    var h = ['<div class="list-group debaty">'];

    for(var i = 0; i < this.data.length; i++) {
        if(this.data.hasOwnProperty(i)) {
            var o = this.data[i];
            h.push([
                '<a class="list-group-item" data-id="' + o.id + '">',
                    o.tytul,
                '</a>'
            ].join(''));
        }
    }

    h.push('</div>');
    return h.join('');
};

$(document).ready(function() {
    var data = JSON.parse(
        $('#data-json').attr('data-value')
    );

    var p = new Posiedzenie(
        data,
        $('#posiedzenie')
    );

});
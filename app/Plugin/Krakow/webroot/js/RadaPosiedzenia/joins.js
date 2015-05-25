$(document).ready(function() {

    var oldContainer;
    $('ul.sortable').sortable({
        handle: '.handle',
        group: 'nested',
        afterMove: function (placeholder, container) {
            if(oldContainer != container){
                if(oldContainer)
                    oldContainer.el.removeClass("active");
                container.el.addClass("active");

                oldContainer = container
            }
        },
        isValidTarget: function($item, container) {
            if($(container.el).closest('li').first().attr('data-source') == $item.attr('data-source'))
                return false;

            // jeżeli element bip + panel chce być wrzucony jako element podrzędny
            if(!container.el.hasClass('sortable') && $item.find('ul').length == 0)
                return false;

            // jeżeli $item posiada już jakieś elementy i chce być wrzucony do podrzędnego container
            if(!container.el.hasClass('sortable') && $item.find('ul li').length > 0)
                return false;

            // jeżeli podrzędny container posiada już jakieś elementy
            return !(!container.el.hasClass('sortable') && container.items.length > 0);
        },
        onDrop: function (item, container, _super) {
            container.el.removeClass("active");
            _super(item)
        }
    });

    $('.remove').bind('click', function() {
        var li = $(this).closest('li');
        li.hide(400, function() {
            $(this).remove();
        });
    });

    $('#save').click(function() {

        var DataController = {

            data: [],
            ord: 0,
            id: 0,

            push: function(el) {
                el.ord = this.ord;
                this.data.push(el);
                this.ord++;
            },

            save: function() {
                $.post('/krakow/rada_posiedzenia/joins/' + this.id, { data: this.data })
                    .done(function(res) {
                        console.log(res);
                    });
            }

        };

        DataController.id = $('#posiedzenie_id').attr('data-id');

        var i = 0;
        $('ul.sortable li').each(function() {
            if(!$(this).closest('ul').first().hasClass('sortable'))
                return;

            var source = $(this).attr('data-source');
            var id = $(this).attr('data-id');
            var punkt_id = $(this).attr('data-punkt-id');

            if($(this).find('li').length) {
                var _id = 0;
                var _punkt_id = 0;
                var child = $(this).find('li').first();
                var child_id = child.attr('data-id');
                if(source == 'bip') {
                    _id = id;
                    _punkt_id = child_id;
                } else {
                    _id = child_id;
                    _punkt_id = id;
                }

                DataController.push({
                    source: 'panel_bip',
                    id: _id,
                    punkt_id: _punkt_id
                });

            } else {
                DataController.push({
                    source: source,
                    id: id,
                    punkt_id: punkt_id
                });
            }
        });

        DataController.save();
    });

});
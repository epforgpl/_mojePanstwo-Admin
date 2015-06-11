$(document).ready(function () {
    $('#editor').wysihtml5({
        'locale': 'pl-PL',
        parser: function (html) {
            return html;
        }
    });
});

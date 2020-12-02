$(function ()
{
    $("body").append("<div id='notify-container'></div>");
    $("body").append("<audio id='notify-sound-info' src='/sounds/info.mp3'></audio>");
    $("body").append("<audio id='notify-sound-danger' src='/sounds/danger.mp3'></audio>");
});

/**
 * Global Success Helper
 * @param title
 * @param content
 * @param level
 */
function notify(title, content, level)
{
    $.notify({
        title: title,
        content: content,
        level: level ? level : 'success',
        icon: "far fa-fw fa-thumbs-up bounce animated"
    });
}

/**
 * Global Error Helper
 * @param title
 * @param content
 */
function notifyError(title, content)
{
    $.notify({
        title: title,
        content: content,
        level: 'danger',
        icon: "far fa-fw fa-thumbs-down shake animated"
    });
}

var notifyCount = 0;

$.notify = function (settings)
{
    settings = $.extend({
        title: "",
        content: "",
        icon: undefined,
        level: 'info',
        timeout: 5000
    }, settings);

    // vars
    notifyCount = notifyCount + 1;
    var notifyId = "notify" + notifyCount;

    // sound
    var soundFile = settings.level;
    if (settings.level == 'success') {
        soundFile = 'info';
    }
    if (settings.level == 'warning') {
        soundFile = 'danger';
    }

    // play sound
    document.getElementById('notify-sound-' + soundFile).play();

    //--------------------------------------------------------------
    var delay = '';
    if (settings.timeout != undefined) {
        delay += 'data-delay="' + settings.timeout + '"';
    }

    var html = '';
    html += '<div id="' + notifyId + '" class="toast" role="alert" aria-live="assertive" aria-atomic="true" ' + delay + '>\n' +
                '<div class="toast-header bg-' + settings.level + '">\n';

                    if (settings.icon !== undefined) {
                        html += '<i class="mr-2 ' + settings.icon + '"></i>\n';
                    }

            html += '<strong class="mr-auto">' + settings.title + '</strong>\n' +
                    '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
                        '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                '</div>\n' +
                '<div class="toast-body">\n' + settings.content + '  </div>\n' +
            '</div>';
    //--------------------------------------------------------------

    // append html markup to container
    $("#notify-container").append(html);
    $('.toast').toast('show');

    $('.toast').on('hidden.bs.toast', function () {
        $(this).remove();
    });
}

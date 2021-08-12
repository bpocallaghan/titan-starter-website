$(document).ajaxStart(function () { Pace.restart(); });

$(function () {
    initTitan();
});

var FORM;
var UTILS;
var BUTTON;
function initTitan() {
    FORM = new FormClass();
    UTILS = new UtilsClass();
    BUTTON = new ButtonClass();

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
        }
    });

    // set defaults (for when we init select2 after page load)
    $.fn.select2.defaults.set("theme", "bootstrap4");

    // $(".select2").select2();
    // init vendor selections on page load
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    $(".select2").select2({
        theme: "bootstrap4"
    });

    // scroll to item / area
    $("body").find('.scroll-to-btn').on('click',function() {
        $item = $(this).parents().find(".scroll-to-item");
        $('html, body').animate({
            scrollTop: $item.offset().top - 25
        }, 2000);
    });

    // if collapse opens, scroll it to the top
    $('.scroll-collapse').on('shown.bs.collapse', function (e) {
        $('html,body').animate({
            scrollTop: $('.scroll-collapse').offset().top - 25
        }, 500);
    });

    $('.input-generate-slug').on('change',function () {
        var v = convertStringToSlug($(this).val());
        $("form input[name='slug']").val(v);
    });

    function convertStringToSlug(text) {
        return text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/&/g, '-and-')         // Replace & with 'and'
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '')             // Trim - from end of text
            .replace(/-$/, '');             // Remove last floating dash if exists
    }
}

function doAjax(url, data, callback) {
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: "json",
        timeout: 30000,
        error: function (x, t, m) {
        },
        success: function (response) {
            if (typeof callback == 'function') {
                callback(response);
            }
        }
    });
}

/**
 * In Header of Box, the toolbox daterange icon
 * Dropdown with the selected dates to select from
 * @param selector
 * @param callback
 */
function initToolbarDateRange(selector, callback) {
    $(selector).daterangepicker({
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last 3 Months': [moment().subtract(2, 'month').startOf('month'), moment().endOf('month')],
            'Last 6 Months': [moment().subtract(5, 'month').startOf('month'), moment().endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        //window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        if (typeof callback === 'function') {
            callback(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }
    });
}

/**
 * In Header of Box, the toolbox daterange icon
 * Dropdown with the selected dates to select from
 * @param selector
 * @param callback
 */
function initDateRangeLatest(selector, callback) {
    $(selector).daterangepicker({
        ranges: {
            'Last to Next Week': [moment().subtract(1, 'weeks').startOf('isoWeek').startOf('day'), moment().add(1, 'weeks').endOf('isoWeek').endOf('day')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Prev Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
            'Prev Prev Month': [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')]
        },
        startDate: moment().subtract(1, 'weeks').startOf('isoWeek').startOf('day'),
        endDate: moment().add(1, 'weeks').endOf('isoWeek').endOf('day')
    }, function (start, end) {
        //window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        if (typeof callback === 'function') {
            callback(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }
    });
}

/**
 * Give from and to datetimepicker inputs,
 * This will automatically set min / max date on the fields
 */
function setDateTimePickerRange(from, to) {
    $(from).datetimepicker({icons: {time: "fas fa-clock"}});
    $(to).datetimepicker({ useCurrent: false, icons: {time: "fas fa-clock" }});

    $(from).on("dp.change", function (e) {
        $(to).data("DateTimePicker").minDate(e.date);
    });
    $(to).on("dp.change", function (e) {
        $(from).data("DateTimePicker").maxDate(e.date);
    });
}

function initSummerNote(selector) {
    $(selector).summernote({
        height: 120,
        focus: false,
        tabsize: 2,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['color', ['color']],
            ['layout', ['ul', 'ol', 'paragraph']],
            ['insert', ['table','link', /* 'picture', 'video',*/ 'hr']],
            ['misc', ['fullscreen', 'codeview', 'undo']]
        ],
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    });
}

function isFunction(variable) {
    var getType = {};
    return variable && getType.toString.call(variable) === '[object Function]';
}

// declare Variables
var BTN;

$windowWidth = $(window).width();
$windowHeight = $(window).height();

// functions that need doc.ready
$(document).ready(function () {

    // load BTN class
    BTN = new ButtonClass();

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
        }
    });

    // other website functions
    $('.navbar-toggler').on('click', function(e) {
        if ($(this).hasClass('collapsed')) {
            $('.navbar').addClass('scroller');
        }else{
            $('.navbar').removeClass('scroller');
        }
    });

    //ICON APPENDER
    $('*[data-icon]').each(function(){
        var thisIcon = $(this).attr('data-icon');
        if (''+thisIcon+':contains("fa-")') {
            $(this).prepend('<i class="fa '+thisIcon+'"></i> ');
        }else{
            $(this).prepend('<i class="icons '+thisIcon+'"></i> ');
        }

    });

    // SHOW BACK TO TOP BUTTON
    $(window).scroll(function ()
    {
        var y = $(window).scrollTop();
        var c = $(window).height();
        if (y > c){
            $('.back-to-top').css({"bottom":"10px"});
        } else{
            $('.back-to-top').css({"bottom":"-45px"});
        }
    });

    //CLOSE PRELOAD
    $('#pre_load').click(function() {
        $(this).fadeOut();
    });

    //EMAIL
    $('a.email').each(function() {
        var text = $(this).text();
        var address = text.replace(" at ", "@");
        $(this).attr('href', 'mailto:' + address);
        $(this).text(address);
    });

    //JUMPER
    $("a.jumper,.jumper a").click(function(event){

        var navHeight = $(".navbar").height();

        var link = $(this).attr('href');
        setTimeout(function() {
            $(link).trigger('click');
        }, 500);
        event.preventDefault();
        var full_url = this.href;
        var parts = full_url.split("#");
        var trgt = parts[1];
        var target_offset = $("#"+trgt).offset();
        var target_top = target_offset.top-navHeight-60;
        $('html, body').animate({scrollTop:target_top}, 500);
    });

});// end doc.ready


//DEBOUNCE FUNC
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};
//APPLY DEBOUNCE
var myEfficientFn = debounce(function() {
    headerSizing();
}, 50);

//CALC PADDING
function headerSizing(){
    var scrolledY = $(window).scrollTop();

    if(scrolledY >= 20){
        $('.navbar').addClass('minify');
    }else{
        $('.navbar').removeClass('minify');
    }
};

$(window).bind('scroll',myEfficientFn);
myEfficientFn();


function showSpinner()
{
    $('.spinner-content').fadeIn(300);
}

function hideSpinner()
{
    $('.spinner-content').stop().fadeOut(300);
    setTimeout(function ()
    {
        $('.spinner-content').stop().fadeOut(300);
    }, 300);
}

function log(value)
{
    console.log(value);
}

function doAjax(url, data, callback, loader)
{
    if (loader == undefined || loader == true) {
        showSpinner();
    }

    var urlFull = url; // BASE_URL.replace(/\/$/, '') + '/' +
    if (url.search('http://') >= 0 || url.search('https://') >= 0) {
        urlFull = url;
    }

    if (data == undefined) {
        data = {};
    }
    // data['api_token'] = API_TOKEN;

    $.ajax({
        type: 'POST',
        url: urlFull,
        data: data,
        dataType: "json",
        timeout: 60000,
        error: function (x, t, m)
        {
            console.log('AJAX ERROR');
            console.log(x);
            console.log(t);
            console.log(m);
            notifyError('Sorry', 'A system error occurred. Please try again or contact our Call centre.');
        },
        success: function (response)
        {
            if (typeof callback == 'function') {
                callback(response);
            }
        }
    });
}

/**
 * Is the ajax response valid
 * @param response
 * @returns {boolean}
 */
function isAjaxResponseValid(response)
{
    if (!(response.success || response.data)) {
        notifyError('Sorry', 'Something went wrong, please try again.');
        return false;
    }

    return true;
}

var roundValue = function (value)
{
    return Math.round(parseFloat(value) * 100) / 100;
}

var formatNumber2Decimal = function (value)
{
    value = parseFloat(value).toFixed(2);
    //value = (value).replace(/.00+$/, "");
    return value;
}
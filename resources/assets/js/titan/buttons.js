/*
 * Button Class
 */
var ButtonClass = function ()
{
    var root = this;

    /*
     * Constructor
     */
    this.construct = function ()
    {
        root.activate();
    };

    /**
     * Set button into loading status
     * @param btn
     */
    this.loading = function (btn)
    {
        $(btn).attr('data-reset', $(btn).html());

        var attr = $(btn).attr('data-loading');

        // For some browsers, `attr` is undefined; for others, `attr` is false.  Check for both.
        if (typeof attr === typeof undefined || attr === false) {
            $(btn).attr('data-loading', "<i class='fas fa-spin fa-sync-alt fa-fw'></i>");
        }

        $(btn).each(function ()
        {
            buttonDisable($(this));
        });
    };

    /**
     * Reset the status of the button
     * @param btn
     */
    this.reset = function (btn)
    {
        $(btn).each(function ()
        {
            buttonEnable(btn);
        })
    };

    // enable all buttons
    this.activate = function ()
    {
        $('.btn-ajax-submit').each(function ()
        {
            buttonEnable($(this));
        });

        var attr = $('.btn-submit').attr('data-loading-text');

        // For some browsers, `attr` is undefined; for others, `attr` is false.  Check for both.
        if (typeof attr === typeof undefined || attr === false) {
            $('.btn-submit').attr('data-loading-text', "<i class='fas fa-spin fa-sync-alt fa-fw'></i>");
        }

        $('.btn-submit').on('click', function ()
        {
            root.loading(this);
        });

    };

    // enable a specific button
    var buttonEnable = function (btn)
    {
        btn.each(function ()
        {

            $(this).prop('disabled', false);
            $(this).html($(this).attr('data-reset'));

            $(this).attr('data-is-loading', false);
        })
    };

    // disable and show loading button
    var buttonDisable = function (btn)
    {
        btn.each(function ()
        {

            $(this).attr('data-is-loading', true);
            $(this).html($(this).attr('data-loading'));
        })
    };

    /*
     * Pass options when class instantiated
     */
    this.construct();
};

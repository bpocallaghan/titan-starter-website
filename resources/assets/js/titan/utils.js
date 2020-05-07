//-------------------------------------------------
// UTILS
//-------------------------------------------------
var UtilsClass = function () {
    var root = this;

    this.construct = function () {
        String.prototype.trim = function () {
            return this.replace(/^\s+|\s+$/g, "");
        };
        String.prototype.ucFirst = function () {
            return this.charAt(0).toUpperCase() + this.slice(1);
        }
    };

    this.findItemInArray = function (id, arr, key) {
        key = key ? key : 'id';

        for (var i = 0; i < arr.length; i++) {
            if (id == arr[i][key]) {
                return arr[i];
            }
        }

        return false;
    };

    this.isString = function (n) {
        return (typeof n == "string" ? true : false);
    };

    this.isNumber = function (n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    this.isFunction = function (functionToCheck) {
        return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
    };

    this.doAjax = function (url, data, callback) {
        if (data === undefined || data == null) {
            data = {};
        }

        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            timeout: 90000,
            dataType: "json",
            error: function (xhr) {
                console.log('error');
                console.log(xhr);
                console.log(xhr.responseText);
                console.log(xhr.responseJSON);
            },
            success: callback
        });
    }

    this.doAjaxHtml = function (url, data, callback) {
        if (data === undefined || data == null) {
            data = {};
        }

        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            timeout: 90000,
            dataType: "html",
            error: function (xhr) {
                console.log('error');
                console.log(xhr);
                console.log(xhr.responseText);
                console.log(xhr.responseJSON);
            },
            success: callback
        });
    };

    /**
     * Returns an array with arrays of the given size.
     *
     * @param myArray {Array} array to split
     * @param chunk_size {Integer} Size of every group
     */
    this.chunkArray = function (myArray, chunk_size) {
        var index = 0;
        var arrayLength = myArray.length;
        var tempArray = [];

        for (index = 0; index < arrayLength; index += chunk_size) {
            myChunk = myArray.slice(index, index + chunk_size);
            // Do something if you want with the group
            tempArray.push(myChunk);
        }

        return tempArray;
    };

    function isMobileDevice()
    {
        return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
    }

    this.generateSelectOptions = function (formId, selectId, placeholder, items, selectedIndex, label) {

        if (selectedIndex === undefined || selectedIndex == null) {
            selectedIndex = 1;
        }

        if (label === undefined || label == null) {
            label = 'name';
        }

        var select = $(formId + ' select[name="' + selectId + '"]');
        select.find('option:selected').removeAttr("selected");

        var $options = $('<option>').attr('value', 0).html(placeholder);
        $.each(items, function (key, value) {
            $options = $options.add($('<option>').attr('value', value['id']).html(value[label]));
        });

        // set options and trigger change
        select.html($options).trigger('change');

        // set the first instructor selected
        select.val(select.find('option:eq(' + selectedIndex + ')').val()).trigger('change');
        hideFormSpinner(formId);
    };

    this.construct();
};
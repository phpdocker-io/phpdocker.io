//

$(doMainFormMagic);
function doMainFormMagic() {
    /**
     * @type {*|jQuery|HTMLElement}
     */

    var mysqlOptionsDiv    = $('#mysql-options')
    var mysqlOptionsFields = mysqlOptionsDiv.find('input');
    var mysqlSwitch        = $('#project_mysqlOptions_hasMysql');
    var fields             = $('#generator input[type=text], input[type=number]');

    // Disable mysql options
    var disableMysqlOptions = function () {
        mysqlOptionsDiv.addClass('disabled').fadeIn();
        mysqlOptionsFields.prop('disabled', true);
    };

    disableMysqlOptions();

    var enableMysqlOptions = function () {
        mysqlOptionsDiv.removeClass('disabled').fadeIn(1000);
        mysqlOptionsFields.prop('disabled', false);
    };

    // Enable mysql options when clicking the switch
    mysqlSwitch.change(function () {
        if (mysqlSwitch.prop('checked') == true) {
            enableMysqlOptions();
        } else {
            disableMysqlOptions();
        }
    });

    // PHP extension multiselect
    $('#project_phpOptions_phpExtensions').multiselect({
        enableCaseInsensitiveFiltering: true,
        maxHeight: 200,
        buttonWidth: "100%",
        dropUp: true,
        onDropdownHide: function (event) {
            event.preventDefault();
        }

    });

    // Open multiselect and return focus to first field
    $('button.multiselect').click();
    fields.first().focus();

    // Analytics
    $('#generator').submit(function (event) {
        $('input[type=checkbox]').each(function () {
            ga('send', 'event', 'builder-form', 'builder-choices', $(this).attr('name'), $(this).is(':checked'));
        });

        ga('send', 'event', 'builder-form', 'form-submission');
    });

    // Select PHP extensions based on service choices
    var checkboxPrefix                         = 'project_';
    var extensionServices                      = [];
    extensionServices['hasRedis']              = 'Redis';
    extensionServices['hasMemcached']          = 'Memcached';
    extensionServices['mysqlOptions_hasMysql'] = 'MySQL';

    for (var key in extensionServices) {
        var value      = extensionServices[key];
        var checkboxId = '#' + checkboxPrefix + key;

        $(checkboxId).data('value', value).change(function () {
            var extCheckbox = $('.multiselect-container :checkbox[value=' + $(this).data('value') + ']');
            extCheckbox.click();
        });
    }
};


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
        if (mysqlSwitch.prop('checked') == false) {
            mysqlOptionsDiv.addClass('disabled');
            mysqlOptionsFields.prop('disabled', true);
        }
    };

    disableMysqlOptions();

    var enableMysqlOptions = function () {
        mysqlOptionsDiv.removeClass('disabled');
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

    // Select PHP extensions based on service choices
    var checkboxPrefix                         = 'project_';
    var extensionServices                      = [];
    var extensionMultiSelects                  = $('[id^=project_phpOptions_phpExtensions]');
    extensionServices['hasRedis']              = 'Redis';
    extensionServices['hasMemcached']          = 'Memcached';
    extensionServices['mysqlOptions_hasMysql'] = 'MySQL';

    for (var key in extensionServices) {
        var value      = extensionServices[key];
        var checkboxId = '#' + checkboxPrefix + key;

        $(checkboxId)
            .data('multiselect', extensionMultiSelects)
            .data('value', value)
            .change(function () {
                $(this).data('multiselect').multiselect('select', $(this).data('value'));
            });
    }

    // PHP extension multiselect
    extensionMultiSelects.each(function (index, element) {
        $(this).multiselect({
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            buttonWidth: "100%",
            dropUp: true,
            onDropdownHide: function (event) {
                event.preventDefault();
            }
        });

        // Hide all but the first one
        if (index != 0) {
            $(this).parents('.form-group').hide();
        }
    });

    // Open multiselect and return focus to first field
    $('button.multiselect').click();
    fields.first().focus();

    // Change multiselect based on php version chosen
    var phpVersionSelector = $('#project_phpOptions_version');
    phpVersionSelector.change(function() {
        extensionMultiSelects.parents('.form-group').hide();

        switch ($(this).val()) {
            case '7.0.x':
                extensionMultiSelects.filter('[id$=70]').parents('.form-group').show();
                break;

            default:
                extensionMultiSelects.filter('[id$=56]').parents('.form-group').show();
                break;
        }
    });

    // Analytics
    $('#generator').submit(function (event) {
        $('input[type=checkbox]').each(function () {
            ga('send', 'event', 'builder-form', 'builder-choices', $(this).attr('name'), $(this).is(':checked'));
        });

        ga('send', 'event', 'builder-form', 'form-submission');
    });
};

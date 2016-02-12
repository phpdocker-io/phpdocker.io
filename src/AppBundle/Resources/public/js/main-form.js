//

$(doMainFormMagic);
function doMainFormMagic() {
    /**
     * @type {*|jQuery|HTMLElement}
     */

    var mysqlOptionsDiv    = $('#mysql-options')
    var mysqlOptionsFields = mysqlOptionsDiv.find('input');
    var mysqlSwitch        = $('#project_mysqlOptions_hasMysql');

    // Disable mysql options
    var disableMysqlOptions = function () {
        mysqlOptionsDiv.addClass('disabled').fadeIn();
        mysqlOptionsFields.prop('disabled', true);
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

    $('#project_phpOptions_phpExtensions').multiselect({
        enableCaseInsensitiveFiltering: true,
        maxHeight: 250,
        buttonWidth: 300,
        dropUp: true
    });

};


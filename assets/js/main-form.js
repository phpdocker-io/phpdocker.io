const $ = require('jquery');
require('bootstrap');
require('bootstrap-multiselect/dist/js/bootstrap-multiselect.js');
require('bootstrap-toggle');
// require('bootstrap/dist/js/bootstrap.min');
// require('bootstrap-multiselect/dist/js/bootstrap-multiselect.js');
// require('bootstrap-toggle/js/bootstrap-toggle.js');

/**
 * Equivalent to php ucfirst
 *
 * @param value
 * @returns {string}
 */
function ucfirst(value) {
    value += '';
    const f = value.charAt(0).toUpperCase();
    return f + value.substr(1);
}

$(document).ready(function() {
    /**
     * Enable/disable form elements based on checkboxes
     */
    // [
    //     'postgres',
    //     'mysql',
    //     'mariadb',
    //     'elasticsearch'
    // ].forEach(function (value) {
    //     const optionsDiv    = $('#' + value + '-options');
    //     const optionsFields = optionsDiv.find('input');
    //     const switchNode    = $('#project_' + value + 'Options_has' + ucfirst(value));
    //
    //     const disableOptions = function () {
    //         if (switchNode.prop('checked') === false) {
    //             optionsDiv.addClass('disabled');
    //             optionsFields.prop('disabled', true);
    //         }
    //     };
    //
    //     // Disable on page load
    //     disableOptions();
    //
    //     const enableOptions = function () {
    //         optionsDiv.removeClass('disabled');
    //         optionsFields.prop('disabled', false);
    //     };
    //
    //     // Toggle on checkbox changes
    //     switchNode.change(function () {
    //         if (switchNode.prop('checked') === true) {
    //             enableOptions();
    //         } else {
    //             disableOptions();
    //         }
    //     });
    // });

    // Select PHP extensions based on service choices
    // const checkboxPrefix                             = 'project_';
    // const extensionServices                          = [];
    // const extensionMultiSelects                      = $('[id^=project_phpOptions_phpExtensions]');
    // extensionServices['hasRedis']                    = 'Redis';
    // extensionServices['hasMemcached']                = 'Memcached';
    // extensionServices['mysqlOptions_hasMysql']       = 'MySQL';
    // extensionServices['mariadbOptions_hasMariadb']   = 'MySQL';
    // extensionServices['postgresOptions_hasPostgres'] = 'PostgreSQL';

    // for (let key in extensionServices) {
    //     let value      = extensionServices[key];
    //     let checkboxId = '#' + checkboxPrefix + key;
    //
    //     $(checkboxId)
    //         .data('multiselect', extensionMultiSelects)
    //         .data('value', value)
    //         .change(function () {
    //             $(this).data('multiselect').multiselect('select', $(this).data('value'));
    //         });
    // }


    // PHP extension multiselect
    // extensionMultiSelects.each(function (index) {
    //     $(this).multiselect({
    //         enableCaseInsensitiveFiltering: true,
    //         maxHeight: 600,
    //         buttonWidth: "100%",
    //         dropUp: true,
    //         onDropdownHide: function (event) {
    //             console.log(event);
    //             event.preventDefault();
    //         }
    //     })
    //
    //     // $(this).click();
    //
    //     // Hide all but the first one
    //     if (index !== 0) {
    //         $(this).parents('.form-group').hide();
    //     }
    // });



    /**
     * Change multiselect based on php version chosen
     */
    // const phpVersionSelector = $('#project_phpOptions_version');
    // phpVersionSelector.change(function () {
    //     extensionMultiSelects.parents('.form-group').hide();
    //
    //     switch ($(this).val()) {
    //         case '7.0.x':
    //             extensionMultiSelects.filter('[id$=70]').parents('.form-group').show();
    //             break;
    //
    //         case '7.1.x':
    //             extensionMultiSelects.filter('[id$=71]').parents('.form-group').show();
    //             break;
    //
    //         case '7.2.x':
    //             extensionMultiSelects.filter('[id$=72]').parents('.form-group').show();
    //             break;
    //
    //         default:
    //             extensionMultiSelects.filter('[id$=56]').parents('.form-group').show();
    //             break;
    //     }
    // });

    // const hiddenFieldId = 'hidden-phpversion';
    // const form          = $('#generator');
    //
    // phpVersionSelector.change(function () {
    //     const hiddenField = $('#' + hiddenFieldId);
    //     if (hiddenField.length) {
    //         hiddenField.val(phpVersionSelector.val());
    //     }
    // });
    //
    // phpVersionSelector.change(function () {
    //     const hiddenField = $('#' + hiddenFieldId);
    //     if (hiddenField.length) {
    //         hiddenField.val(phpVersionSelector.val());
    //     }
    // });

    // Analytics
    // form.submit(function (event) {
    //     $('input[type=checkbox]').each(function () {
    //         ga('send', 'event', 'builder-form', 'builder-choices', $(this).attr('name'), $(this).is(':checked'));
    //     });
    //
    //     ga('send', 'event', 'builder-form', 'form-submission');
    // });

    // Bootstrap toggles
    const checkboxes = $('input[type=checkbox]');


    checkboxes.bootstrapToggle({
        on: "Yes",
        off: "No",
        size: "small",
    });

    /*** UGLY HACK ***/
    // Open multiselects
    // PHP extension multiselect
    // $('button.multiselect').each(function (index) {
    //     $(this).click();
    // });
    // $('button.multiselect').click();

    // Unfortunately, the previous "click" on the multiselects makes the page scroll on load
    // Negate
    $(window).scrollTop(0);

    /*** END OF UGLY HACK ***/
});

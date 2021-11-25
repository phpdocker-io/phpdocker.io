$(doMainFormMagic)

/**
 * Generator form JS handles
 */
function doMainFormMagic () {
    /**
     * Enable/disable form elements based on checkboxes
     */
    [
        'postgres',
        'mysql',
        'mariadb',
        'elasticsearch'
    ].forEach(function (value) {
        var optionsDiv    = $('#' + value + '-options')
        var optionsFields = optionsDiv.find('input')
        var switchNode    = $('#project_' + value + 'Options_has' + ucfirst(value))

        var disableOptions = function () {
            if (switchNode.prop('checked') == false) {
                optionsDiv.addClass('disabled')
                optionsFields.prop('disabled', true)
            }
        }

        // Disable on page load
        disableOptions()

        var enableOptions = function () {
            optionsDiv.removeClass('disabled')
            optionsFields.prop('disabled', false)
        }

        // Toggle on checkbox changes
        switchNode.change(function () {
            if (switchNode.prop('checked') == true) {
                enableOptions()
            } else {
                disableOptions()
            }
        })
    })

    // Select PHP extensions based on service choices
    let checkboxPrefix                               = 'project_'
    let extensionServices                            = []
    let extensionMultiSelects                        = $('[id^=project_phpOptions_phpExtensions]')
    extensionServices['hasRedis']                    = 'Redis'
    extensionServices['hasMemcached']                = 'Memcached'
    extensionServices['mysqlOptions_hasMysql']       = 'MySQL'
    extensionServices['mariadbOptions_hasMariadb']   = 'MySQL'
    extensionServices['postgresOptions_hasPostgres'] = 'PostgreSQL'

    for (var key in extensionServices) {
        var value      = extensionServices[key]
        var checkboxId = '#' + checkboxPrefix + key

        $(checkboxId)
            .data('multiselect', extensionMultiSelects)
            .data('value', value)
            .change(function () {
                $(this).data('multiselect').multiselect('select', $(this).data('value'))
            })
    }

    // PHP extension multiselect
    extensionMultiSelects.each(function (index) {
        $(this).multiselect({
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            buttonWidth: '100%',
            dropUp: true,
            onDropdownHide: function (event) {
                event.preventDefault()
            }
        })

        // Hide all but the first one
        if (index !== 0) {
            $(this).parents('.form-group').hide()
        }
    })

    /*** UGLY HACK ***/
    // Open multiselects
    $('button.multiselect').click()

    // Unfortunately, the previous "click" on the multiselects makes the page scroll on load
    // Negate
    $(window).scrollTop(0)

    /*** END OF UGLY HACK ***/

    // Focus on the first form field
    $('form:not(.filter) :input:visible:enabled:first').focus()

    /**
     * Change multiselect based on php version chosen
     */
    let phpVersionSelector = $('#project_phpOptions_version')
    phpVersionSelector.change(function () {
        extensionMultiSelects.parents('.form-group').hide()

        let chosenVersion = '81'
        switch ($(this).val()) {
            case '7.4':
                chosenVersion = '74'
                break

            case '8.0':
                chosenVersion = '80'
                break
        }

        extensionMultiSelects.filter('[id$=' + chosenVersion + ']').parents('.form-group').show()
    })

    const form          = $('#generator')
    const hiddenFieldId = 'hidden-phpversion'

    phpVersionSelector.change(function () {
        let hiddenField = $('#' + hiddenFieldId)
        if (hiddenField.length) {
            hiddenField.val(phpVersionSelector.val())
        }
    })

    // Analytics
    form.submit(function (event) {
        $('input[type=checkbox]').each(function () {
            ga('send', 'event', 'builder-form', 'builder-choices', $(this).attr('name'), $(this).is(':checked'))
        })

        ga('send', 'event', 'builder-form', 'form-submission')
    })

    // Bootstrap toggles
    $('#generator div.checkbox input[type=checkbox]').bootstrapToggle({
        size: 'small'
    })
}

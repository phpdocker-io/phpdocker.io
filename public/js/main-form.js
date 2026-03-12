document.addEventListener('DOMContentLoaded', doMainFormMagic)

function doMainFormMagic () {
    // Enable/disable form elements based on checkboxes
    const toggleServices = [
        { optionsDiv: '#postgres-options',      switchId: '#project_postgresOptions_hasPostgres' },
        { optionsDiv: '#mysql-options',         switchId: '#project_mysqlOptions_hasMysql' },
        { optionsDiv: '#mariadb-options',       switchId: '#project_mariadbOptions_hasMariadb' },
        { optionsDiv: '#elasticsearch-options', switchId: '#project_elasticsearchOptions_hasElasticsearch' },
    ]

    toggleServices.forEach(({ optionsDiv: divId, switchId }) => {
        const optionsDiv    = document.querySelector(divId)
        const optionsFields = optionsDiv.querySelectorAll('input')
        const switchNode    = document.querySelector(switchId)

        const toggle = () => {
            const on = switchNode.checked
            optionsDiv.classList.toggle('disabled', !on)
            optionsFields.forEach(el => el.disabled = !on)
        }

        toggle()
        switchNode.addEventListener('change', toggle)
    })

    // Select PHP extensions based on service choices
    const extensionServices = {
        hasRedis:                    'Redis',
        hasMemcached:                'Memcached',
        mysqlOptions_hasMysql:       'MySQL',
        mariadbOptions_hasMariadb:   'MySQL',
        postgresOptions_hasPostgres: 'PostgreSQL',
    }

    const phpExtensionsData = JSON.parse(
        document.getElementById('php-extensions-data').textContent
    )
    const msEl = document.querySelector('[id^=project_phpOptions_phpExtensions]')
    const ms   = new PHPDockerMultiSelect(msEl)

    Object.entries(extensionServices).forEach(([key, value]) => {
        document.querySelector('#project_' + key).addEventListener('change', function () {
            if (this.checked) {
                ms.selectByText(value)
            }
        })
    })

    // Change multiselect based on php version chosen
    document.querySelector('#project_phpOptions_version').addEventListener('change', function () {
        ms.setOptions(phpExtensionsData[this.value] ?? [])
    })

    // Analytics
    document.querySelector('#generator').addEventListener('submit', function () {
        document.querySelectorAll('input[type=checkbox]').forEach(function (el) {
            gtag('send', 'event', 'builder-form', 'builder-choices', el.name, el.checked)
        })

        gtag('send', 'event', 'builder-form', 'form-submission')
    })
}

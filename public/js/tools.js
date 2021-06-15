/**
 * Equivalent to php ucfirst
 *
 * @param value
 * @returns {string}
 */
function ucfirst (value) {
    value += ''
    var f = value.charAt(0).toUpperCase()
    return f + value.substr(1)
}

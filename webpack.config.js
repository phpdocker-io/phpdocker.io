const Encore = require('@symfony/webpack-encore');

const deploymentPrefix = 'deployment/next/';
let outputPath         = 'public/assets/';

if (Encore.isProduction() === true) {
    outputPath = deploymentPrefix + outputPath;
}

Encore
    .setOutputPath(outputPath)
    .setPublicPath('/assets')

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .autoProvidejQuery()

    // Own assets
    .addEntry('js/contact-form', './assets/js/contact-form.js')
    .addEntry('js/main-form', './assets/js/main-form.js')
    .addStyleEntry('css/base', './assets/css/base.css')
    .addStyleEntry('css/media-queries', './assets/css/media-queries.css')

    // jQuery
    .addEntry('vendor/js/jquery', './node_modules/jquery/dist/jquery.min.js')
    .addEntry('vendor/js/jquery-ui', './node_modules/jquery-ui-bundle/jquery-ui.js')
    .addStyleEntry('vendor/css/jquery-ui', './node_modules/jquery-ui-bundle/jquery-ui.css')

    // Bootstrap
    .addEntry('vendor/js/bootstrap', './node_modules/bootstrap/dist/js/bootstrap.js')
    .addStyleEntry('vendor/css/bootstrap', './node_modules/bootstrap/dist/css/bootstrap.css')

    // Bootstrap multi select
    .addEntry('vendor/js/bootstrap-multiselect', './node_modules/bootstrap-multiselect/dist/js/bootstrap-multiselect.js')
    .addStyleEntry('vendor/css/bootstrap-multiselect', './node_modules/bootstrap-multiselect/dist/css/bootstrap-multiselect.css')

    // Bootstrap toggle
    .addEntry('vendor/js/bootstrap-toggle', './node_modules/bootstrap-toggle/js/bootstrap-toggle.js')
    .addStyleEntry('vendor/css/bootstrap-toggle', './node_modules/bootstrap-toggle/css/bootstrap-toggle.css')

    // Font awesome
    .addStyleEntry('vendor/css/font-awesome', './node_modules/font-awesome/css/font-awesome.css')

    .enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();

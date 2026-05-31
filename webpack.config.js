const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addEntry('home', './assets/js/home-menus.js')
    .addEntry('stats', './assets/js/stats-chart.js')
    .addEntry('menu-filters', './assets/js/menu-filters.js')
    .addEntry('order-filters', './assets/js/order-filters.js')
    .enableSassLoader()
    .disableSingleRuntimeChunk()
    
;

module.exports = Encore.getWebpackConfig();

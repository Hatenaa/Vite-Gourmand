const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addEntry('add-employee', './assets/js/add-employee.js')
    .addEntry('home', './assets/js/home-menus.js')
    .addEntry('stats', './assets/js/stats-chart.js')
    .addEntry('menu-filters', './assets/js/menu-filters.js')
    .addEntry('menu-images', './assets/js/menu-images.js')
    .addEntry('order-filters', './assets/js/order-filters.js')
    .addEntry('signup', './assets/js/signup.js')
    .addEntry('signin', './assets/js/signin.js')
    .addEntry('order-map', './assets/js/order-map.js')
    .addEntry('order-form', './assets/js/order-form.js')
    .addEntry('edit-profile', './assets/js/edit-profile.js')
    .addEntry('edit-order', './assets/js/edit-order.js')
    .addEntry('edit-employee', './assets/js/edit-employee.js')
    .addEntry('manage-menu', './assets/js/menu-form.js')
    .addEntry('manage-dish', './assets/js/dish-form.js')
    .addEntry('update-order', './assets/js/update-order.js')
    .addEntry('opening-hours-form', '/assets/js/opening-hours-form.js')
    .enableSassLoader()
    .disableSingleRuntimeChunk()
;

module.exports = Encore.getWebpackConfig();

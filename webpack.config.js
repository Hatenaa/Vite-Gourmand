const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    
    // Auth
    .addEntry('signin', './assets/js/auth/signin.js')
    .addEntry('signup', './assets/js/auth/signup.js')
    
    // Employee
    .addEntry('add-employee', './assets/js/employee/add.js')
    .addEntry('edit-employee', './assets/js/employee/edit.js')
    
    // Menu
    .addEntry('manage-menu', './assets/js/menu/form.js')
    .addEntry('menu-images', './assets/js/menu/images.js')
    .addEntry('menu-filters', './assets/js/menu/filters.js')
    .addEntry('home', './assets/js/menu/home.js')
    
    // Order
    .addEntry('order-form', './assets/js/order/form.js')
    .addEntry('order-map', './assets/js/order/map.js')
    .addEntry('order-filters', './assets/js/order/filters.js')
    .addEntry('edit-order', './assets/js/order/edit.js')
    .addEntry('cancel-order', './assets/js/order/cancel.js')
    .addEntry('update-order', './assets/js/order/update.js')
    
    // Forms (misc)
    .addEntry('contact', './assets/js/forms/contact.js')
    .addEntry('edit-profile', './assets/js/forms/profile.js')
    .addEntry('manage-dish', './assets/js/forms/dish.js')
    .addEntry('opening-hours-form', './assets/js/forms/opening-hours.js')
    .addEntry('reset-password', './assets/js/forms/reset-password.js')
    
    // Utils
    .addEntry('stats', './assets/js/stats/chart.js')
    
    .enableSassLoader()
    .disableSingleRuntimeChunk()
;

module.exports = Encore.getWebpackConfig();

/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/*!**********************************!*\
  !*** ./assets/js/stats-chart.js ***!
  \**********************************/


document.addEventListener('DOMContentLoaded', function () {
  var chartInstance = null;
  var currentMode = 'orders';
  var CHART_LABELS = {
    orders: 'Nombre de commandes',
    revenue: 'Chiffre d\'affaires (€)'
  };
  function buildUrl(mode) {
    var params = new URLSearchParams();
    document.querySelectorAll('.menuCheckbox:checked').forEach(function (cb) {
      params.append('menus[]', cb.value);
    });
    var from = document.getElementById('fromFilter').value;
    var to = document.getElementById('toFilter').value;
    if (from) params.set('from', from);
    if (to) params.set('to', to);
    params.set('mode', mode);
    return '/api/stats?' + params.toString();
  }
  function renderChart(data, mode) {
    var _CHART_LABELS$mode;
    if (chartInstance) {
      chartInstance.destroy();
    }
    var ctx = document.getElementById('statsChart').getContext('2d');
    chartInstance = new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.labels,
        datasets: data.datasets.map(function (ds) {
          return {
            label: ds.label,
            data: ds.data,
            tension: 0.3,
            fill: false
          };
        })
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          title: {
            display: true,
            text: (_CHART_LABELS$mode = CHART_LABELS[mode]) !== null && _CHART_LABELS$mode !== void 0 ? _CHART_LABELS$mode : 'Statistiques'
          }
        }
      }
    });
  }
  function loadStats(mode) {
    currentMode = mode;
    fetch(buildUrl(mode)).then(function (res) {
      return res.json();
    }).then(function (data) {
      return renderChart(data, mode);
    })["catch"](function (err) {
      return console.error('Erreur chargement stats: ', err);
    });
  }
  document.getElementById('applyFilters').addEventListener('click', function () {
    return loadStats(currentMode);
  });
  document.getElementById('showOrders').addEventListener('click', function () {
    return loadStats('orders');
  });
  document.getElementById('showRevenue').addEventListener('click', function () {
    return loadStats('revenue');
  });
  loadStats('orders');
});
/******/ })()
;
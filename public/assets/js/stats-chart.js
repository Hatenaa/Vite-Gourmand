'use strict';

document.addEventListener('DOMContentLoaded', () => {

let chartInstance = null;
let currentMode = 'orders';
const CHART_LABELS = {
    orders: 'Nombre de commandes',
    revenue: 'Chiffre d\'affaires (€)'
}

function buildUrl(mode) {
    const params = new URLSearchParams();

    document.querySelectorAll('.menuCheckbox:checked').forEach(cb => {
        params.append('menus[]', cb.value);
    })

    const from = document.getElementById('fromFilter').value;
    const to = document.getElementById('toFilter').value;

    if (from) params.set('from', from);
    if (to) params.set('to', to);

    params.set('mode', mode);

    return '/api/stats?' + params.toString();
}

function renderChart (data, mode) {
    if (chartInstance) {
        chartInstance.destroy();
    }

    const ctx = document.getElementById('statsChart').getContext('2d');

    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: data.datasets.map(ds => ({
                label: ds.label,
                data: ds.data,
                tension: 0.3,
                fill: false,
            }))
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top'},
                title: {
                    display: true,
                    text: CHART_LABELS[mode] ?? 'Statistiques'
                }
            }
        }
    })
}

function loadStats(mode){
    currentMode = mode;

    fetch(buildUrl(mode))
        .then(res => res.json())
        .then(data => renderChart(data, mode))
        .catch(err => console.error('Erreur chargement stats: ', err));
}

document.getElementById('applyFilters').addEventListener('click', () => loadStats(currentMode));
document.getElementById('showOrders').addEventListener('click', () => loadStats('orders'));
document.getElementById('showRevenue').addEventListener('click', () => loadStats('revenue'));

loadStats('orders');

});
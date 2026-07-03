'use strict';

import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {

let chartOrders = null;
let chartRevenue = null;

const CHART_LABELS = {
    orders: 'Nombre de commandes',
    revenue: 'Chiffre d\'affaires (€)'
};

function buildUrl(mode) {
    const params = new URLSearchParams();

    const menuA = document.getElementById('menu-a').value;
    const menuB = document.getElementById('menu-b').value;

    if (menuA) params.append('menus[]', menuA);
    if (menuB) params.append('menus[]', menuB);

    const from = document.getElementById('date-from').value;
    const to = document.getElementById('date-to').value;

    if (from) params.set('from', from);
    if (to) params.set('to', to);

    params.set('mode', mode);

    return '/api/stats?' + params.toString();
}

function renderChart(data, mode, canvasId, instance) {
    if (instance) {
        instance.destroy();
    }

    const ctx = document.getElementById(canvasId).getContext('2d');

    return new Chart(ctx, {
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
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: CHART_LABELS[mode] ?? 'Statistiques'
                }
            }
        }
    });
}


function syncSelects() {
    const menuA = document.getElementById('menu-a');
    const menuB = document.getElementById('menu-b');

    const valA = menuA.value;
    const valB = menuB.value;

    [...menuA.options].forEach(opt => opt.disabled = false);
    [...menuB.options].forEach(opt => opt.disabled = false);

    if (valA) {
        const optInB = [...menuB.options].find(opt => opt.value === valA);
        if (optInB) {
            optInB.disabled = true;
            if (menuB.value === valA) menuB.value = '';
        }
    }

    if (valB) {
        const optInA = [...menuA.options].find(opt => opt.value === valB);
        if (optInA) {
            optInA.disabled = true;
            if (menuA.value === valB) menuA.value = '';
        }
    }
}


function loadStats() {
    const menuA = document.getElementById('menu-a').value;
    const menuB = document.getElementById('menu-b').value;
    const alert = document.getElementById('stats-alert');

    if (!menuA && !menuB) {
        alert.classList.remove('d-none');
        return;
    }

    alert.classList.add('d-none');

    Promise.all([
        fetch(buildUrl('orders')).then(res => res.json()),
        fetch(buildUrl('revenue')).then(res => res.json())
    ])
    .then(([ordersData, revenueData]) => {
        chartOrders = renderChart(ordersData, 'orders', 'chart-orders', chartOrders);
        chartRevenue = renderChart(revenueData, 'revenue', 'chart-revenue', chartRevenue);
    })
    .catch(err => console.error('Erreur chargement stats: ', err));
}

document.getElementById('menu-a').addEventListener('change', () => { syncSelects(); loadStats(); });
document.getElementById('menu-b').addEventListener('change', () => { syncSelects(); loadStats(); });
document.getElementById('date-from').addEventListener('change', loadStats);
document.getElementById('date-to').addEventListener('change', loadStats);

const now = new Date();
const from = new Date(now.getFullYear(), now.getMonth() - 6, 1);

function toMonthString(date) {
    const y= date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    return `${y}-${m}`;
}

document.getElementById('date-to').value = toMonthString(now);
document.getElementById('date-from').value = toMonthString(from);

syncSelects();
loadStats();

});
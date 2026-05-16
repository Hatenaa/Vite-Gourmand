const statusLabels = {
    'PENDING': 'En attente', 
    'ACCEPTED': 'Acceptée', 
    'IN_PREPARATION': 'En préparation',
    'IN_DELIVERY': 'En livraison',
    'DELIVERED': 'Livrée',
    'WAITING_MATERIAL': 'En attente retour matériel',
    'COMPLETED': 'Terminée',
    'CANCELLED': 'Annulée'
}

document.getElementById('filter-form').addEventListener('submit', function (e) {

    e.preventDefault();

    const status = document.getElementById('filter-status').value;
    const email = document.getElementById('filter-email').value;

    const params = new URLSearchParams();
    if (status) params.set('status', status);
    if (email) params.set('email', email);

    fetch('/api/orders?' + params.toString())
        .then(r => r.json())
        .then(orders => {
            const container = document.getElementById('orders-list');

            if (orders.length === 0) {
                container.innerHTML = '<p>Aucune commande trouvée.</p>';
                return;
            }

            container.innerHTML = orders.map(order => `
                <div>
                    <p>${order.firstName} ${order.lastName} — ${order.menuTitle}</p>
                    <p>Livraison: ${order.deliveryDate}</p>
                    <p>Statut: ${statusLabels[order.status] ?? order.status}</p>
                    <a href="${order.manageUrl}">Gérer</a>
                </div>
            `).join('');
        });

});
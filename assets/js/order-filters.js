const statusLabels = {
    'PENDING': 'En attente',
    'ACCEPTED': 'Acceptée',
    'IN_PREPARATION': 'En préparation',
    'IN_DELIVERY': 'En cours de livraison',
    'DELIVERED': 'Livrée',
    'WAITING_MATERIAL': 'En attente retour matériel',
    'COMPLETED': 'Terminée',
    'CANCELLED': 'Annulée'
};

const statusColors = {
    'PENDING': 'dark',
    'ACCEPTED': 'primary',
    'IN_PREPARATION': 'primary',
    'IN_DELIVERY': 'primary',
    'DELIVERED': 'success',
    'WAITING_MATERIAL': 'secondary',
    'COMPLETED': 'success',
    'CANCELLED': 'danger'
};

document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('filter-form');
    const filterStatus = document.getElementById('filter-status');
    const filterEmail = document.getElementById('filter-email');
    const ordersList = document.getElementById('orders-list');
    

    if (!filterForm || !ordersList) return;

    async function loadAvailableEmails() {
        try {
            const response = await fetch('/api/orders');
            const orders = await response.json();

            const emailsWithActiveOrders = new Set();
            orders.forEach(order => {
                if (order.status !== 'COMPLETED') {
                    emailsWithActiveOrders.add(order.email);
                }
            });

            const uniqueEmails = Array.from(emailsWithActiveOrders);
            uniqueEmails.sort();

            uniqueEmails.forEach(email => {
                const option = document.createElement('option');
                option.value = email;
                option.textContent = email;
                filterEmail.appendChild(option);
            });

        } catch (error) {
            console.error('Erreur lors du chargement des emails:', error)
        }
    }

    async function fetchOrders() {
        const status = filterStatus.value;
        const email = filterEmail.value;

        const params = new URLSearchParams();
        if (status) params.append('status', status);
        if (email) params.append('email', email);

        try {
            const response = await fetch(`/api/orders?${params.toString()}`);
            const orders = await response.json();

            ordersList.innerHTML = '';

            if (orders.length === 0) {
                ordersList.innerHTML = '<p class="col text-muted">Aucune commande trouvée.</p>';
                return;
            }

            orders.forEach((order) => {
                ordersList.innerHTML += createOrderCard(order);
            });

        } catch(error) {
            console.error('Erreur lors du filtrage des commandes:', error);
        }
    }

    async function updateAvailableStatues() {
        const selectedEmail = filterEmail.value;

        try {
            const params = new URLSearchParams();
            if (selectedEmail) params.append('email', selectedEmail);

            const response = await fetch(`/api/orders?${params.toString()}`);
            const orders = await response.json();

            const availableStatuses = [...new Set(orders.map(order => order.status))];

            filterStatus.innerHTML = '<option value="">Tous les statuts</option>';

            availableStatuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = statusLabels[status] ?? status;
                filterStatus.appendChild(option);
            });

            filterStatus.value = '';
            fetchOrders();
        } catch (error) {
            console.error('Erreur lors de la mise à jour des statuts:', error);
        }
    }

    function createOrderCard(order) {
        const imageHtml = order.menuImages && order.menuImages.length > 0
            ? `<img src="${order.menuImages[0].path}" alt="${order.menuImages[0].alt}" class="rounded flex-shrink-0 object-fit-cover" style="width: 55px; height: 55px;">`
            : '';

        const statusBadge = statusLabels[order.status] ?? order.status;
        const statusColor = statusColors[order.status] ?? 'secondary';
        const price = parseFloat(order.totalPrice).toFixed(2).replace('.', ',');

        return `
            <div class="card shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center gap-3">
                        ${imageHtml}
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="mb-1 fw-bold text-truncate">${order.menuTitle}</h6>
                            <small class="text-muted">
                                <i class="bi bi-person me-1"></i>
                                ${order.firstName} ${order.lastName}
                                &nbsp;·&nbsp;
                                <i class="bi bi-calendar me-1"></i>
                                ${order.deliveryDate}
                                &nbsp;·&nbsp;
                                <i class="bi bi-people me-1"></i>
                                ${order.peopleCount} pers.
                            </small>
                        </div>

                        <div class="d-none d-lg-flex align-items-center gap-3 flex-shrink-0">
                            <span class="badge bg-${statusColor}">
                                ${statusBadge}
                            </span>
                            <strong>${price} €</strong>
                            <a href="${order.manageUrl}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i>Gérer
                            </a>
                        </div>
                    </div>

                    <div class="d-flex d-lg-none flex-column gap-2 mt-2 pt-2 border-top">
                        <div class="d-flex align-items-center justify-content-between py-3">
                            <span class="badge bg-${statusColor}">
                                ${statusBadge}
                            </span>
                            <strong>${price} €</strong>
                        </div>
                        <a href="${order.manageUrl}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-pencil me-1"></i>Gérer cette commande
                        </a>
                    </div>
                </div>
            </div>
        `;
    }

    function resetFilters() {
        filterStatus.value = '';
        filterEmail.value = '';
        fetchOrders();
    }

    loadAvailableEmails();

    filterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchOrders();
    });

    document.getElementById('reset-filters').addEventListener('click', resetFilters);

    filterStatus.addEventListener('change', fetchOrders);
    filterEmail.addEventListener('change', updateAvailableStatues);
})
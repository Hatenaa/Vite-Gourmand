/******/ (() => { // webpackBootstrap
/*!************************************!*\
  !*** ./assets/js/order-filters.js ***!
  \************************************/
var statusLabels = {
  'PENDING': 'En attente',
  'ACCEPTED': 'Acceptée',
  'IN_PREPARATION': 'En préparation',
  'IN_DELIVERY': 'En livraison',
  'DELIVERED': 'Livrée',
  'WAITING_MATERIAL': 'En attente retour matériel',
  'COMPLETED': 'Terminée',
  'CANCELLED': 'Annulée'
};
document.getElementById('filter-form').addEventListener('submit', function (e) {
  e.preventDefault();
  var status = document.getElementById('filter-status').value;
  var email = document.getElementById('filter-email').value;
  var params = new URLSearchParams();
  if (status) params.set('status', status);
  if (email) params.set('email', email);
  fetch('/api/orders?' + params.toString()).then(function (r) {
    return r.json();
  }).then(function (orders) {
    var container = document.getElementById('orders-list');
    if (orders.length === 0) {
      container.innerHTML = '<p>Aucune commande trouvée.</p>';
      return;
    }
    container.innerHTML = orders.map(function (order) {
      var _statusLabels$order$s;
      return "\n                <div>\n                    <p>".concat(order.firstName, " ").concat(order.lastName, " \u2014 ").concat(order.menuTitle, "</p>\n                    <p>Livraison: ").concat(order.deliveryDate, "</p>\n                    <p>Statut: ").concat((_statusLabels$order$s = statusLabels[order.status]) !== null && _statusLabels$order$s !== void 0 ? _statusLabels$order$s : order.status, "</p>\n                    <a href=\"").concat(order.manageUrl, "\">G\xE9rer</a>\n                </div>\n            ");
    }).join('');
  });
});
/******/ })()
;
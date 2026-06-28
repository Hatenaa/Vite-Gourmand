/******/ (() => { // webpackBootstrap
/*!************************************!*\
  !*** ./assets/js/order-filters.js ***!
  \************************************/
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
var statusLabels = {
  'PENDING': 'En attente',
  'ACCEPTED': 'Acceptée',
  'IN_PREPARATION': 'En préparation',
  'IN_DELIVERY': 'En cours de livraison',
  'DELIVERED': 'Livrée',
  'WAITING_MATERIAL': 'En attente retour matériel',
  'COMPLETED': 'Terminée',
  'CANCELLED': 'Annulée'
};
var statusColors = {
  'PENDING': 'dark',
  'ACCEPTED': 'primary',
  'IN_PREPARATION': 'primary',
  'IN_DELIVERY': 'primary',
  'DELIVERED': 'success',
  'WAITING_MATERIAL': 'secondary',
  'COMPLETED': 'success',
  'CANCELLED': 'danger'
};
document.addEventListener('DOMContentLoaded', function () {
  var filterForm = document.getElementById('filter-form');
  var filterStatus = document.getElementById('filter-status');
  var filterEmail = document.getElementById('filter-email');
  var ordersList = document.getElementById('orders-list');
  if (!filterForm || !ordersList) return;
  function loadAvailableEmails() {
    return _loadAvailableEmails.apply(this, arguments);
  }
  function _loadAvailableEmails() {
    _loadAvailableEmails = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
      var response, orders, emailsWithActiveOrders, uniqueEmails, _t;
      return _regenerator().w(function (_context) {
        while (1) switch (_context.p = _context.n) {
          case 0:
            _context.p = 0;
            _context.n = 1;
            return fetch('/api/orders');
          case 1:
            response = _context.v;
            _context.n = 2;
            return response.json();
          case 2:
            orders = _context.v;
            emailsWithActiveOrders = new Set();
            orders.forEach(function (order) {
              if (order.status !== 'COMPLETED') {
                emailsWithActiveOrders.add(order.email);
              }
            });
            uniqueEmails = Array.from(emailsWithActiveOrders);
            uniqueEmails.sort();
            uniqueEmails.forEach(function (email) {
              var option = document.createElement('option');
              option.value = email;
              option.textContent = email;
              filterEmail.appendChild(option);
            });
            _context.n = 4;
            break;
          case 3:
            _context.p = 3;
            _t = _context.v;
            console.error('Erreur lors du chargement des emails:', _t);
          case 4:
            return _context.a(2);
        }
      }, _callee, null, [[0, 3]]);
    }));
    return _loadAvailableEmails.apply(this, arguments);
  }
  function fetchOrders() {
    return _fetchOrders.apply(this, arguments);
  }
  function _fetchOrders() {
    _fetchOrders = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2() {
      var status, email, params, response, orders, _t2;
      return _regenerator().w(function (_context2) {
        while (1) switch (_context2.p = _context2.n) {
          case 0:
            status = filterStatus.value;
            email = filterEmail.value;
            params = new URLSearchParams();
            if (status) params.append('status', status);
            if (email) params.append('email', email);
            _context2.p = 1;
            _context2.n = 2;
            return fetch("/api/orders?".concat(params.toString()));
          case 2:
            response = _context2.v;
            _context2.n = 3;
            return response.json();
          case 3:
            orders = _context2.v;
            ordersList.innerHTML = '';
            if (!(orders.length === 0)) {
              _context2.n = 4;
              break;
            }
            ordersList.innerHTML = '<p class="col text-muted">Aucune commande trouvée.</p>';
            return _context2.a(2);
          case 4:
            orders.forEach(function (order) {
              ordersList.innerHTML += createOrderCard(order);
            });
            _context2.n = 6;
            break;
          case 5:
            _context2.p = 5;
            _t2 = _context2.v;
            console.error('Erreur lors du filtrage des commandes:', _t2);
          case 6:
            return _context2.a(2);
        }
      }, _callee2, null, [[1, 5]]);
    }));
    return _fetchOrders.apply(this, arguments);
  }
  function updateAvailableStatues() {
    return _updateAvailableStatues.apply(this, arguments);
  }
  function _updateAvailableStatues() {
    _updateAvailableStatues = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee3() {
      var selectedEmail, params, response, orders, availableStatuses, _t3;
      return _regenerator().w(function (_context3) {
        while (1) switch (_context3.p = _context3.n) {
          case 0:
            selectedEmail = filterEmail.value;
            _context3.p = 1;
            params = new URLSearchParams();
            if (selectedEmail) params.append('email', selectedEmail);
            _context3.n = 2;
            return fetch("/api/orders?".concat(params.toString()));
          case 2:
            response = _context3.v;
            _context3.n = 3;
            return response.json();
          case 3:
            orders = _context3.v;
            availableStatuses = _toConsumableArray(new Set(orders.map(function (order) {
              return order.status;
            })));
            filterStatus.innerHTML = '<option value="">Tous les statuts</option>';
            availableStatuses.forEach(function (status) {
              var _statusLabels$status;
              var option = document.createElement('option');
              option.value = status;
              option.textContent = (_statusLabels$status = statusLabels[status]) !== null && _statusLabels$status !== void 0 ? _statusLabels$status : status;
              filterStatus.appendChild(option);
            });
            filterStatus.value = '';
            fetchOrders();
            _context3.n = 5;
            break;
          case 4:
            _context3.p = 4;
            _t3 = _context3.v;
            console.error('Erreur lors de la mise à jour des statuts:', _t3);
          case 5:
            return _context3.a(2);
        }
      }, _callee3, null, [[1, 4]]);
    }));
    return _updateAvailableStatues.apply(this, arguments);
  }
  function createOrderCard(order) {
    var _statusLabels$order$s, _statusColors$order$s;
    var imageHtml = order.menuImages && order.menuImages.length > 0 ? "<img src=\"".concat(order.menuImages[0].path, "\" alt=\"").concat(order.menuImages[0].alt, "\" class=\"rounded flex-shrink-0 object-fit-cover\" style=\"width: 55px; height: 55px;\">") : '';
    var statusBadge = (_statusLabels$order$s = statusLabels[order.status]) !== null && _statusLabels$order$s !== void 0 ? _statusLabels$order$s : order.status;
    var statusColor = (_statusColors$order$s = statusColors[order.status]) !== null && _statusColors$order$s !== void 0 ? _statusColors$order$s : 'secondary';
    var price = parseFloat(order.totalPrice).toFixed(2).replace('.', ',');
    return "\n            <div class=\"card shadow-sm\">\n                <div class=\"card-body p-3 p-md-4\">\n                    <div class=\"d-flex align-items-center gap-3\">\n                        ".concat(imageHtml, "\n                        <div class=\"flex-grow-1 min-w-0\">\n                            <h6 class=\"mb-1 fw-bold text-truncate\">").concat(order.menuTitle, "</h6>\n                            <small class=\"text-muted\">\n                                <i class=\"bi bi-person me-1\"></i>\n                                ").concat(order.firstName, " ").concat(order.lastName, "\n                                &nbsp;\xB7&nbsp;\n                                <i class=\"bi bi-calendar me-1\"></i>\n                                ").concat(order.deliveryDate, "\n                                &nbsp;\xB7&nbsp;\n                                <i class=\"bi bi-people me-1\"></i>\n                                ").concat(order.peopleCount, " pers.\n                            </small>\n                        </div>\n\n                        <div class=\"d-none d-lg-flex align-items-center gap-3 flex-shrink-0\">\n                            <span class=\"badge bg-").concat(statusColor, "\">\n                                ").concat(statusBadge, "\n                            </span>\n                            <strong>").concat(price, " \u20AC</strong>\n                            <a href=\"").concat(order.manageUrl, "\" class=\"btn btn-outline-primary\">\n                                <i class=\"bi bi-pencil me-1\"></i>G\xE9rer\n                            </a>\n                        </div>\n                    </div>\n\n                    <div class=\"d-flex d-lg-none flex-column gap-2 mt-2 pt-2 border-top\">\n                        <div class=\"d-flex align-items-center justify-content-between py-3\">\n                            <span class=\"badge bg-").concat(statusColor, "\">\n                                ").concat(statusBadge, "\n                            </span>\n                            <strong>").concat(price, " \u20AC</strong>\n                        </div>\n                        <a href=\"").concat(order.manageUrl, "\" class=\"btn btn-outline-primary w-100\">\n                            <i class=\"bi bi-pencil me-1\"></i>G\xE9rer cette commande\n                        </a>\n                    </div>\n                </div>\n            </div>\n        ");
  }
  function resetFilters() {
    filterStatus.value = '';
    filterEmail.value = '';
    fetchOrders();
  }
  loadAvailableEmails();
  filterForm.addEventListener('submit', function (e) {
    e.preventDefault();
    fetchOrders();
  });
  document.getElementById('reset-filters').addEventListener('click', resetFilters);
  filterStatus.addEventListener('change', fetchOrders);
  filterEmail.addEventListener('change', updateAvailableStatues);
});
/******/ })()
;
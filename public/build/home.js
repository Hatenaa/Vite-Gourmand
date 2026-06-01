/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./assets/js/home-menus.js ***!
  \*********************************/
document.addEventListener('DOMContentLoaded', function () {
  var container = document.getElementById('menuCards');
  var tabs = document.querySelectorAll('#menuTabs .nav-link');
  function renderCards(menus) {
    if (menus.length === 0) {
      container.innerHTML = '<p class="text-center">Aucun menu disponible.</p>';
      return;
    }
    container.innerHTML = menus.slice(0, 3).map(function (menu) {
      var _menu$image$alt;
      return "\n            <div class=\"col\">\n                <div class=\"card h-100 overflow-hidden rounded-4 shadow-sm position-relative\" style=\"min-height: 300px;\">\n                    ".concat(menu.image ? "<img src=\"/".concat(menu.image.path, "\" class=\"card-img h-100 object-fit-cover\" alt=\"").concat((_menu$image$alt = menu.image.alt) !== null && _menu$image$alt !== void 0 ? _menu$image$alt : menu.title, "\">") : "<div class=\"card-img h-100 bg-secondary\"></div>", "\n                    <div class=\"card-img-overlay d-flex align-items-end bg-dark bg-opacity-50\">\n                        <h3 class=\"card-title text-white fw-bold\">").concat(menu.title, "</h3>\n                        <a href=\"/menus/").concat(menu.id, "\" class=\"stretched-link\"></a>\n                    </div>\n                </div>\n            </div>      \n        ");
    }).join('');
  }
  function fetchMenus() {
    var themeId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
    container.innerHTML = '<div class="text-center py-5 w-100"><div class="spinner-border text-primary" role="status"></div></div>';
    var url = themeId ? "/api/menus?theme=".concat(themeId) : '/api/menus';
    fetch(url).then(function (r) {
      return r.json();
    }).then(renderCards);
  }
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function (e) {
      e.preventDefault();
      tabs.forEach(function (t) {
        t.classList.remove('active');
        t.classList.remove('link--flash');
      });
      tab.classList.add('active');
      tab.classList.add('link--flash');
      fetchMenus(tab.dataset.themeId);
    });
  });
  fetchMenus();
  var track = document.getElementById('reviewsTrack');
  var btn = document.getElementById('reviewsNavBtn');
  var icon = document.getElementById('reviewsNavIcon');
  if (track && btn) {
    var offset = 0;
    btn.addEventListener('click', function () {
      var step = track.children[0].offsetWidth + 24;
      var maxOffset = track.scrollWidth - track.parentElement.offsetWidth;
      if (btn.classList.contains('end-0')) {
        offset = Math.min(offset + step, maxOffset);
        track.style.transform = "translateX(-".concat(offset, "px)");
        if (offset >= maxOffset) {
          btn.classList.replace('end-0', 'start-0');
          icon.className = 'bi bi-arrow-left';
        }
      } else {
        offset = 0;
        track.style.transform = 'translateX(0)';
        btn.classList.replace('start-0', 'end-0');
        icon.className = 'bi bi-arrow-right';
      }
    });
  }
});
/******/ })()
;
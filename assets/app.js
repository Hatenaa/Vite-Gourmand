import './styles/app.scss';
import 'bootstrap';

// Gère le spinning des boutons
document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-spinner-btn]');
    if (!btn) return;
    btn.querySelector('.btn-label').classList.add('d-none');
    const spinner = btn.querySelector('.btn-spinner');
    spinner.classList.remove('d-none');
    spinner.classList.add('d-flex');
    btn.classList.add('pe-none');
});

window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
        document.querySelectorAll('[data-spinner-btn]').forEach(btn => {
            btn.querySelector('.btn-label').classList.remove('d-none');
            const spinner = btn.querySelector('.btn-spinner');
            spinner.classList.remove('d-flex');
            spinner.classList.add('d-none');
            btn.classList.remove('pe-none');
        });
    }
});

// Gère le parallax de nos images dashboard
const heroImg = document.querySelector('.hero-parallax');
if (heroImg && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    window.addEventListener('scroll', () => {
        heroImg.style.transform = `translateY(${window.scrollY * 0.3}px)`;
    }, { passive: true });
}


// S'occupe du texte pour activer ou désactiver un menu dans la page de modification
(function initToggle() {
  const toggle = document.getElementById('menu_isActive');
  const label = document.getElementById('isActiveLabel');
  
  if (toggle && label) {
    function updateLabel() {
      if (toggle.checked) {
        label.innerHTML = 'Désactiver le menu';
      } else {
        label.innerHTML = 'Activer le menu';
      }
    }
    
    updateLabel();
    toggle.addEventListener('change', updateLabel);
  }
})();


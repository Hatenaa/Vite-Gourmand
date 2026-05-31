import 'nouislider/dist/nouislider.css';
import noUiSlider from 'nouislider';

document.addEventListener('DOMContentLoaded', () => {
    const peopleSliderEl = document.getElementById('peopleSlider');
    const priceSliderEl = document.getElementById('priceSlider');

    if (!peopleSliderEl || !priceSliderEl) return;

    const peopleSlider = noUiSlider.create(peopleSliderEl, {
        start: [1, 25], connect: true, step: 1,
        range: { min: 1, max: 25 },
    });

    const peopleMinLabel = document.getElementById('peopleMinLabel');
    const peopleMaxLabel = document.getElementById('peopleMaxLabel');
    peopleSlider.on('update', (values) => {
        peopleMinLabel.textContent = Math.round(values[0]);
        peopleMaxLabel.textContent = Math.round(values[1]);
    });

    const priceSlider = noUiSlider.create(priceSliderEl, {
        start: [0, 300], connect: true, step: 5,
        range: { min: 0, max: 300 },
    });

    const priceMinLabel = document.getElementById('priceMinLabel');
    const priceMaxLabel = document.getElementById('priceMaxLabel');
    priceSlider.on('update', (values) => {
        priceMinLabel.textContent = `${Math.round(values[0])} €`;
        priceMaxLabel.textContent = `${Math.round(values[1])} €`;
    });

    async function fetchMenus() {
        const [, peopleMax] = peopleSlider.get();
        const [priceMin, priceMax] = priceSlider.get();

        const params = new URLSearchParams();
        if (Math.round(peopleMax) < 25) {
            params.append('minPeople', Math.round(peopleMax));
        }
        params.append('minPrice', Math.round(priceMin));
        params.append('maxPrice', Math.round(priceMax));

        const theme = document.getElementById('theme').value;
        const regime = document.getElementById('regime').value;
        if (theme) params.append('theme', theme);
        if (regime) params.append('regime', regime);

        const response = await fetch(`/api/menus?${params.toString()}`);
        const menus = await response.json();
        const menuList = document.querySelector('#menus-list');

        menuList.innerHTML = '';

        if (menus.length === 0) {
            menuList.innerHTML = '<p class="col text-muted">Aucun menu ne correspond à votre recherche.</p>';
            return;
        }

        menus.forEach((menu) => {
            menuList.innerHTML += createMenuCard(menu);
        });
    }

    // Refresh automatique
    peopleSlider.on('change', fetchMenus);
    priceSlider.on('change', fetchMenus);
    document.getElementById('theme').addEventListener('change', fetchMenus);
    document.getElementById('regime').addEventListener('change', fetchMenus);

    // Submit conservé comme fallback
    document.querySelector('#menu-filter-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchMenus();
    });
});

function createMenuCard(menu) {
    const imageHtml = menu.image ? `
        <div class="position-relative">
            <img src="${menu.image.path}" alt="${menu.image.alt ?? menu.title}"
                 class="card-img-top object-fit-cover" style="height: 220px;">
            <span class="position-absolute top-0 end-0 m-2 badge bg-dark fw-normal">
                <i class="bi bi-people-fill"></i>
                À partir de ${menu.minPeople} personnes
            </span>
        </div>` : '';

    return `
        <div class="col">
            <article class="card h-100 border-outline-secondary rounded-4 overflow-hidden">
                ${imageHtml}
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-baseline gap-2 mb-3">
                        <h3 class="fw-bold mb-0 h4">${menu.title}</h3>
                        <span class="ms-auto d-flex align-items-baseline gap-1">
                            <span class="text-primary fw-bold fs-2 lh-1">${menu.basePrice}€</span>
                            <small class="text-muted">/ per.</small>
                        </span>
                    </div>
                    <p class="text-muted text-justify small flex-grow-1">${menu.description ?? ''}</p>
                    <div class="d-grid gap-2 mt-3">
                        <a href="/menus/${menu.id}" class="btn btn-primary">Voir en détail →</a>
                        <a href="/commande/nouvelle/${menu.id}" class="btn btn-outline-secondary">Commander ce menu</a>
                    </div>
                </div>
            </article>
        </div>`;
}
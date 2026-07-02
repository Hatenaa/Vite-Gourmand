document.addEventListener('DOMContentLoaded', () => {


    const container = document.getElementById('menuCards');
    const tabs = document.querySelectorAll('#menuTabs .nav-link');


    function renderCards(menus) {
        if (menus.length === 0) {
            container.innerHTML = '<p class="text-center">Aucun menu disponible.</p>';
            return;
        }

        container.innerHTML = menus.slice(0, 3).map(menu => `
            <div class="col">
                <div class="card h-100 overflow-hidden rounded-4 shadow-sm position-relative" style="min-height: 300px;">
                    ${menu.image
                        ? `<img src="/${menu.image.path}" class="card-img h-100 object-fit-cover" alt="${menu.image.alt ?? menu.title}">`
                        : `<div class="card-img h-100 bg-secondary"></div>`
                    }
                    <div class="card-img-overlay d-flex align-items-end bg-dark bg-opacity-50">
                        <h3 class="card-title text-white fw-bold">${menu.title}</h3>
                        <a href="/menus/${menu.id}" class="stretched-link"></a>
                    </div>
                </div>
            </div>      
        `).join('');
    }


    function fetchMenus(themeId = '') {
        container.innerHTML = '<div class="text-center py-5 w-100"><div class="spinner-border text-primary" role="status"></div></div>';
        const url = themeId ? `/api/menus?theme=${themeId}` : '/api/menus';
        fetch(url)
            .then(r => r.json())
            .then(renderCards);
    }



    tabs.forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            tabs.forEach(t => {
                t.classList.remove('active');
                t.classList.remove('link--flash');
            });
            tab.classList.add('active');
            tab.classList.add('link--flash');
            fetchMenus(tab.dataset.themeId);
        })
    })

    fetchMenus();



    const track = document.getElementById('reviewsTrack');
    const btn = document.getElementById('reviewsNavBtn');
    const icon = document.getElementById('reviewsNavIcon');

    if (track && btn) {
        let offset = 0;

        btn.addEventListener('click', () => {
            const step = track.children[0].offsetWidth + 24;
            const maxOffset = track.scrollWidth - track.parentElement.offsetWidth;

            if (btn.classList.contains('end-0')) {
                offset = Math.min(offset + step, maxOffset);
                track.style.transform = `translateX(-${offset}px)`;
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
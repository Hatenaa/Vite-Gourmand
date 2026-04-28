document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#menu-filter-form');
    const menuList = document.querySelector('#menus-list');

    if (!form || !menuList) {
        return;
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()){
            if(value !== ''){
                params.append(key,value);
            }
        }
        
        const response = await fetch(`/api/menus?${params.toString()}`);
        const menus = await response.json();

        menuList.innerHTML = '';

        if (menus.length === 0) {
            menuList.innerHTML = '<p>Aucun menu ne correspond à votre recherche.</p>';
            return;
        }

        menus.forEach((menu) => {
            menuList.innerHTML += createMenuCard(menu);
        });

    });

});

function createMenuCard(menu) {
    const imageHtml = menu.image
    ? `<img src="/${menu.image.path}" alt="${menu.image.alt ?? menu.title}" width="300"`
    : '';

    return `
        <article>
            ${imageHtml}

            <p>À partir de ${menu.minPeople} personnes</p>
            <h3>${menu.title}</h3>
            <p>${menu.basePrice}€/pers</p>
            <p>${menu.description ?? ''}</p>
            <a href="/menus/${menu.id}">
                Voir en détail
            </a>

            <a href="#">Commande ce menu</a>

        </article>
    `;
}
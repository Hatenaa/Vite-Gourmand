const mapEl = document.getElementById('confirm-map');

if (mapEl) {
    
    const CATERER = [44.837789, -0.57918];
    const address = mapEl.dataset.address;
    const city = mapEl.dataset.city;

    const map = L.map('confirm-map').setView(CATERER, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const catererIcon = L.divIcon({
        html: '<i class="bi bi-geo-alt-fill marker-caterer"></i>',
        className: '', iconAnchor: [12, 32], popupAnchor: [0, -32]
    });

    const deliveryIcon = L.divIcon({
        html: '<i class="bi bi-geo-alt-fill marker-delivery"></i>',
        className: '', iconAnchor: [12, 32], popupAnchor: [0, -32]
    });

    L.marker(CATERER, { icon: catererIcon }).bindPopup('Vite et Gourmand').addTo(map);

    const mapWrapper = mapEl.parentElement;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                mapWrapper.classList.add('map-visible');
                map.invalidateSize();
                observer.disconnect();
            }
        });
    }, { threshold: 0.2 });
    observer.observe(mapWrapper);

    const query = encodeURIComponent(address + ', ' + city + ', France');
    fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&limit=1`, {
        headers: { 'User-Agent': 'Vite-et-Gourmand/1.0' }
    })

    .then(res => res.json())
    .then(data => {
        if (!data.length) return;
        const lat = parseFloat(data[0].lat);
        const lon = parseFloat(data[0].lon);

        L.marker([lat, lon], { icon: deliveryIcon })
            .bindPopup('Adresse de livraison')
            .addTo(map);
        
        return fetch(
            `https://router.project-osrm.org/route/v1/driving/${CATERER[1]},${CATERER[0]};${lon},${lat}?overview=full&geometries=geojson`
        );
    })
    .then(res => res?.json())
    .then(routeData => {
        if (!routeData || routeData.code !== 'Ok') return;
        const route = L.geoJson(routeData.routes[0].geometry, {
            style: { color: '#8B1A1A', weight: 4,  opacity: 0.8 }
        }).addTo(map);
        map.fitBounds(route.getBounds(), { padding: [30, 30] });
    })
    .catch(() => {});

}    
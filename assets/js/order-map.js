const mapEl = document.getElementById('delivery-map');

if (mapEl) {
    const CATERER = [44.837789, -0.57918];

    const map = L.map('delivery-map').setView(CATERER, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

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

    observer.observe(mapEl);

    const catererIcon = L.divIcon({
        html: '<i class="bi bi-geo-alt-fill marker-caterer"></i>',
        className: '',
        iconAnchor: [12, 32],
        popupAnchor: [0, -32]
    });

    const deliveryIcon = L.divIcon({
        html: '<i class="bi bi-geo-alt-fill marker-delivery"></i>',
        className: '',
        iconAnchor: [12, 32],
        popupAnchor: [0, -32]
    });

    L.marker(CATERER, { icon: catererIcon })
        .bindPopup('Vite et Gourmand')
        .addTo(map);

    let deliveryMarker = null;
    let routeLayer = null;
    let debounceTimer = null;

    const addressField = document.getElementById(mapEl.dataset.addressId);
    const cityField = document.getElementById(mapEl.dataset.cityId);

    function updateMap() {
        
        const address = addressField.value.trim();
        const city = cityField.value.trim();
        if (!address || !city) return;

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(async () => {
            const query = encodeURIComponent(address + ', ' + city + ', France');
            const geoRes = await fetch(
                `https://nominatim.openstreetmap.org/search?q=${query}&format=json&limit=1`,
                { headers: { 'User-Agent': 'Vite-et-Gourmand/1.0' } }
            );
            const geoData = await geoRes.json();
            if (!geoData.length) return;

            const lat = parseFloat(geoData[0].lat);
            const lon = parseFloat(geoData[0].lon);

            if (deliveryMarker) deliveryMarker.remove();
            deliveryMarker = L.marker([lat, lon], { icon: deliveryIcon })
            .bindPopup('Adresse de livraison')
            .addTo(map);

            const routeRes = await fetch(
                `https://router.project-osrm.org/route/v1/driving/${CATERER[1]},${CATERER[0]};${lon},${lat}?overview=full&geometries=geojson`
            );
            const routeData = await routeRes.json();
            if (routeData.code !== 'Ok') return;

            if (routeLayer) routeLayer.remove();
            routeLayer = L.geoJSON(routeData.routes[0].geometry, {
                style: { color: '#8B1A1A', weight: 4, opacity: 0.8 }
            }).addTo(map);

            map.fitBounds(routeLayer.getBounds(), { padding: [30, 30] });
        }, 800);
    }

    addressField.addEventListener('input', updateMap);
    cityField.addEventListener('input', updateMap);

    if (addressField.value && cityField.value) updateMap();
}

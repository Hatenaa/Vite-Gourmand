const addressInput = document.querySelector('[data-validate="address"]');
const cityInput = document.querySelector('[data-validate="city"]');
const dateInput = document.querySelector('[data-validate="date"]');
const timeInput = document.querySelector('[data-validate="time"]');
const peopleInput = document.querySelector('[data-validate="people"]');
const submitBtn = document.getElementById('order-submit');
const menuSelect = document.getElementById('order_menu');

if (menuSelect) {
    menuSelect.addEventListener('change', updateMenuPreview);
}

function updateMenuPreview() {

    const selected = menuSelect?.options[menuSelect.selectedIndex];
    const imageWrap = document.getElementById('menu-preview-image-wrap');
    const info = document.getElementById('menu-preview-info');
    const empty = document.getElementById('menu-preview-empty');
    const img = document.getElementById('menu-preview-img');
    const title = document.getElementById('menu-preview-title');
    const min = document.getElementById('menu-preview-min');
    const price = document.getElementById('menu-preview-price');

    if (!selected?.value) {

        imageWrap?.classList.remove('preview-visible');
        info?.classList.remove('preview-visible');

        setTimeout(() => {
            imageWrap?.classList.add('d-none');
            info?.classList.add('d-none');
        }, 300);

        empty?.classList.remove('d-none');
        setTimeout(() => empty?.classList.remove('preview-hiding'), 20);
        return;
    }

    if (submitBtn) submitBtn.dataset.basePrice = selected.dataset.basePrice;
    if (peopleInput) {
        peopleInput.dataset.minPeople = selected.dataset.minPeople;
        peopleInput.dispatchEvent(new Event('input'));
    } 

    empty?.classList.add('preview-hiding');
    imageWrap?.classList.remove('preview-visible');
    info?.classList.remove('preview-visible');
    
    setTimeout(() => {
        empty.classList.add('d-none');

        if (selected.dataset.image) {
            img.src = selected.dataset.image;
            img.alt = selected.dataset.alt;
            imageWrap?.classList.remove('d-none');
            setTimeout(() => imageWrap?.classList.add('preview-visible'), 20);
        } else {
            imageWrap?.classList.add('d-none');
        }

        title.textContent = selected.dataset.title;
        min.textContent = `Min. ${selected.dataset.minPeople} pers.`;
        price.textContent = `${parseFloat(selected.dataset.basePrice).toFixed(2)} €/pers.`;
        info?.classList.remove('d-none');
        setTimeout(() => info?.classList.add('preview-visible'), 20);

    }, 300);

}

if (submitBtn) {
    submitBtn.disabled = true;

    [addressInput, cityInput, dateInput, timeInput, peopleInput]
        .filter(Boolean)
        .forEach(input => input.addEventListener('input', validateForm));

    const allFilled = [addressInput, cityInput, dateInput, timeInput, peopleInput]
        .filter(Boolean)
        .every(i => i.value.trim() !== '');

    if (allFilled) validateForm();

    function validateForm() {
        validateRequired(addressInput);
        validateRequired(cityInput);
        validateDate(dateInput);
        validateRequired(timeInput);
        validatePeopleCount(peopleInput);
        updateButtonPrice();
        checkFormValidity();
    }

    // Pour afficher dynamiquement 
    // le prix du menu.

    let hideDiscountTimer = null;

    function updateButtonPrice() {
        const basePrice = parseFloat(submitBtn.dataset.basePrice);
        const count = parseInt(peopleInput?.value);
        const discountRow = document.getElementById('discount-row');
        const discountBadge = document.getElementById('discount-badge');
        const livraisonRow = document.getElementById('livraison-row');
        const priceEl = document.getElementById('btn-price');

        if (!basePrice || !count || count < 1) {
            
            priceEl?.classList.remove('visible');
            livraisonRow?.classList.remove('squared');
            discountRow?.classList.remove('discount-visible');
            clearTimeout(hideDiscountTimer);
            hideDiscountTimer = setTimeout(() => discountRow?.classList.add('d-none'), 300);
            return;
        }

        const min = parseInt(peopleInput.dataset.minPeople) || 1;
        const menuPrice = basePrice * count;
        const discount = count >= min + 5 ? menuPrice * 0.10 : 0;
        const total = menuPrice - discount;
        

        if (priceEl) {
            priceEl.textContent = `· ${total.toFixed(2)} €`;
            priceEl.classList.add('visible');
        }

        if (discount > 0) {

            clearTimeout(hideDiscountTimer); // Pour éviter qu'un utilisateur rentre et supprime trop vite une valeure (ça sert à annuler le timer).
            discountRow?.classList.remove('d-none');
            setTimeout(() => discountRow?.classList.add('discount-visible'), 20);
            if (discountBadge) discountBadge.textContent = `−${discount.toFixed(2)} €`;
            requestAnimationFrame(() => requestAnimationFrame(() => livraisonRow?.classList.add('squared')));

        } else {
            
            discountRow?.classList.remove('discount-visible');
            livraisonRow?.classList.remove('squared');
            clearTimeout(hideDiscountTimer);
            hideDiscountTimer = setTimeout(() => discountRow?.classList.add('d-none'), 300);
        }
    }


    function checkFormValidity() {
        const allValid = [addressInput, cityInput, dateInput, timeInput, peopleInput]
            .filter(Boolean)
            .every(i => i.classList.contains('is-valid'));
        if (submitBtn) submitBtn.disabled = !allValid;
    }

    function setValid(input) {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
    }

    function setInvalid(input) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }

    function validateRequired(input) {
        if (!input) return;
        input.value.trim() !== '' ? setValid(input) : setInvalid(input);
    }

    function validateDate(input) {
        if (!input) return;
        if (!input.value) { setInvalid(input); return; }
        const selected = new Date(input.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        selected >= today ? setValid(input) : setInvalid(input);
    }

    function validatePeopleCount(input) {
        if (!input) return;
        const value = parseInt(input.value);
        const min = parseInt(input.dataset.minPeople) || 1;
        const feedback = document.getElementById('people-feedback');

        if (input.value.trim() === '') {
            setInvalid(input);
            return;
        }

        if (isNaN(value)) {
            if (feedback) feedback.textContent = 'Veuillez entrer un chiffre valide.';
            setInvalid(input);
            return;
        }

        if (value < min) {
            if (feedback) feedback.textContent = `Minimum ${min} ${min > 1 ? 'personnes requises' : 'personne requise'} pour ce menu.`;
            setInvalid(input);
            return;
        }

        setValid(input);
    }
}
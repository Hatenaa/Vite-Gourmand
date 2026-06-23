document.addEventListener('DOMContentLoaded', function() {

    const titleInput = document.getElementById('menu_title');
    const basePriceInput = document.getElementById('menu_basePrice');
    const minPeopleInput = document.getElementById('menu_minPeople');
    const stockInput = document.getElementById('menu_stock');
    const conditionsInput = document.getElementById('menu_conditions');
    const themeSelect = document.getElementById('menu_theme');
    const regimeSelect = document.getElementById('menu_regime');
    const submitBtn = document.querySelector('button[type="submit"]');

    const allInputs = [titleInput, basePriceInput, minPeopleInput, stockInput, conditionsInput, themeSelect, regimeSelect].filter(Boolean);

    allInputs.forEach(input => {
        input.addEventListener('input', validateAll);
        input.addEventListener('change', validateAll);
    });

    validateAll();

    function validateAll() {
        
        validateRequired(titleInput, 45);
        validatePrice(basePriceInput);
        validatePositiveNumber(minPeopleInput);
        validatePositiveNumber(stockInput);
        validateRequired(conditionsInput);
        validateRequired(themeSelect);
        validateRequired(regimeSelect);
        checkFormValidity();
    }

    function validateRequired(input, maxLength = null) {
        if (!input) return;
        const val = input.value.trim();
        const valid = val.length > 0 && (!maxLength || val.length <= maxLength);
        valid ? setValid(input) : setInvalid(input);
    }

    function validatePrice(input) {
        if (!input) return;
        const val = parseFloat(input.value);
        const valid = !isNaN(val) && val > 0;
        valid ? setValid(input) : setInvalid(input);
    }

    function validatePositiveNumber(input) {
        if (!input) return;
        const val = parseInt(input.value);
        const valid = !isNaN(val) && val > 0;
        valid ? setValid(input) : setInvalid(input);
    }

    function checkFormValidity() {
        if (allInputs.length === 0) {
            if (submitBtn) submitBtn.disabled = true;
            return;
        }

        const allValid = allInputs.every(i => i.classList.contains('is-valid'));
        if (submitBtn) submitBtn.disabled = !allValid;
    }

    function setValid(input) {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
    }

    function setInvalid(input) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    }
});

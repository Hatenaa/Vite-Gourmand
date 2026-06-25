document.addEventListener('DOMContentLoaded', function () {

    const openingTimeInput = document.querySelector('[data-validate="opening-time"]');
    const closingTimeInput = document.querySelector('[data-validate="closing-time"]');
    const isClosedCheckbox = document.querySelector('[data-validate="is-closed"]');
    const submitBtn = document.getElementById('submitBtn');

    const allInputs = [openingTimeInput, closingTimeInput].filter(Boolean);

    allInputs.forEach(input => {
        input.addEventListener('input', validateAll);
        input.addEventListener('change', validateAll);
    });
    if (isClosedCheckbox) {
        isClosedCheckbox.addEventListener('change', validateAll);
    }

    validateAll();

    function setValid(input) {

        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
    }

    
    function setInvalid(input) {

        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    }

    function validateTime(input) {

        if (!input) return;
        input.value.trim() !== '' ? setValid(input) : setInvalid(input);
    }

    function validateOrder() {

        if (!openingTimeInput || !closingTimeInput) return;
        const openVal = openingTimeInput.value.trim();
        const closeVal = closingTimeInput.value.trim();

        // Si l’un est vide, on ne vérifie pas l’ordre
        if (openVal === '' || closeVal === '') return;
        if (openVal >= closeVal) {
            setInvalid(closingTimeInput);
        } else {
            setValid(closingTimeInput);
        }
    }

    function validateAll() {

        const isClosed = isClosedCheckbox ? isClosedCheckbox.checked : false;

        if (isClosed) {
            
            openingTimeInput.disabled = true;
            closingTimeInput.disabled = true;
            openingTimeInput.value = '';
            closingTimeInput.value = '';
          
            setValid(openingTimeInput);
            setValid(closingTimeInput);
        } else {
            
            openingTimeInput.disabled = false;
            closingTimeInput.disabled = false;
            
            validateTime(openingTimeInput);
            validateTime(closingTimeInput);
            
            if (openingTimeInput.value.trim() !== '' && closingTimeInput.value.trim() !== '') {
                validateOrder();
            }
        }

        checkFormValidity();
    }

    function checkFormValidity() {

        const isClosed = isClosedCheckbox ? isClosedCheckbox.checked : false;
        let allValid = false;

        if (isClosed) {
            allValid = true;
        } else {
            const inputs = [openingTimeInput, closingTimeInput]
                .filter(i => i !== null && !i.disabled);
            allValid = inputs.every(i => i.classList.contains('is-valid'));
        }

        submitBtn.disabled = !allValid;
    }
});
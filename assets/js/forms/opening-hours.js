import { setValid, setInvalid, checkFormValidity, setupFormValidation } from '../shared/validators.js';

const openingTimeInput = document.querySelector('[data-validate="opening-time"]');
const closingTimeInput = document.querySelector('[data-validate="closing-time"]');
const isClosedCheckbox = document.querySelector('[data-validate="is-closed"]');
const submitBtn = document.getElementById('submitBtn');

const allInputs = [openingTimeInput, closingTimeInput].filter(Boolean);

function validateOrder() {

    if (!openingTimeInput || !closingTimeInput) return;
    const openVal = openingTimeInput.value.trim();
    const closeVal = closingTimeInput.value.trim();

    if (openVal === '' || closeVal === '') return;
    if (openVal >= closeVal) {
        setInvalid(closingTimeInput);
    } else {
        setValid(closingTimeInput);
    }
}

function validateOpeningHours() {

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
        const openVal = openingTimeInput.value.trim();
        const closeVal = closingTimeInput.value.trim();
        openVal ? setValid(openingTimeInput) : setInvalid(openingTimeInput);
        closeVal ? setValid(closingTimeInput) : setInvalid(closingTimeInput);
        
        if (openVal && closeVal) {
            validateOrder();
        }
    }

    const isClosedNow = isClosedCheckbox ? isClosedCheckbox.checked : false;
    
    if (isClosedNow) {
        submitBtn.disabled = false;
    } else {
        const inputsToCheck = [openingTimeInput, closingTimeInput].filter(i => i && !i.disabled);
        checkFormValidity(inputsToCheck, submitBtn);
    }
}

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: [
        { field: openingTimeInput, validateFn: validateOpeningHours }
    ]
});

if (isClosedCheckbox) {
    isClosedCheckbox.addEventListener('change', validateOpeningHours);
}

validateOpeningHours();
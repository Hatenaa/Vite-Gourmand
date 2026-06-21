const addressInput = document.querySelector('[data-validate="address"');
const cityInput = document.querySelector('[data-validate="city"]');
const dateInput = document.querySelector('[data-validate="date"]');
const timeInput = document.querySelector('[data-validate="time"]');
const peopleInput = document.querySelector('[data-validate="people"]');
const submitBtn = document.querySelector('button[type="submit"]');

const minPeople = parseInt(peopleInput?.dataset.minPeople ?? 1, 10);

const allInputs = [addressInput, cityInput, dateInput, timeInput, peopleInput].filter(Boolean);

allInputs.forEach(input => {
    input.addEventListener('input', validateAll);
    input.addEventListener('change', validateAll);
})

validateAll();

function validateAll() {
    validateRequired(addressInput);
    validateRequired(cityInput);
    validateDate(dateInput);
    validateRequired(timeInput);
    validatePeople(peopleInput);
    checkFormValidity();
}

function checkFormValidity() {
    const allValid = allInputs.every(i => i.classList.contains('is-valid'));
    if (submitBtn) submitBtn.disabled = !allValid;
}


function setValid(input) { input.classList.add('is-valid'); input.classList.remove('is-invalid'); }
function setInvalid(input) { input.classList.add('is-invalid'); input.classList.remove('is-valid'); }


function validateRequired(input) {

    if (!input) return;
    input.value.trim() ? setValid(input) : setInvalid(input);
}

function validateDate(input) {

    if (!input) return;
    if (!input.value) { setInvalid(input); return; }
    const selected = new Date(input.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    selected >= today ? setValid(input) : setInvalid(input);
}


function validatePeople(input) {

    if (!input) return;
    const val = parseInt(input.value, 10);
    (!isNaN(val) && val >= minPeople) ? setValid(input) : setInvalid(input);
}
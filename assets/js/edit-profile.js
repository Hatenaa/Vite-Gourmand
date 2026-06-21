const firstNameInput = document.querySelector('[data-validate="firstName"]');
const lastNameInput = document.querySelector('[data-validate="lastName"]');
const emailInput = document.querySelector('[data-validate="email"]');
const phoneInput = document.querySelector('[data-validate="phone"]');
const addressInput = document.querySelector('[data-validate="address"]');
const cityInput = document.querySelector('[data-validate="city"]');
const submitBtn = document.querySelector('button[type="submit"]');

const requiredInputs = [firstNameInput, lastNameInput, emailInput, phoneInput].filter(Boolean);
const optionalInputs = [addressInput, cityInput].filter(Boolean);

[...requiredInputs, ...optionalInputs].forEach(input => {
    input.addEventListener('input', validateAll);
});

validateAll();

function validateAll() {
    validateRequired(firstNameInput);
    validateRequired(lastNameInput);
    validateEmail(emailInput);
    validatePhone(phoneInput);
    validateOptional(addressInput);
    validateOptional(cityInput);
    checkFormValidity();
}

function checkFormValidity() {
    const allValid = requiredInputs.every(i => i.classList.contains('is-valid'));
    if (submitBtn) submitBtn.disabled = !allValid;
}

function setValid(input) { input.classList.add('is-valid'); input.classList.remove('is-invalid'); }
function setInvalid(input) { input.classList.add('is-invalid'); input.classList.remove('is-valid'); }
function setNeutral(input) { input.classList.remove('is-valid', 'is-invalid'); }

function validateRequired(input) {
    if (!input) return;
    input.value.trim() ? setValid(input) : setInvalid(input);
}

function validateEmail(input) {

    if (!input) return;
    const val = input.value.trim();
    if (!val) { setInvalid(input); return; }
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ? setValid(input) : setInvalid(input);
}

function validatePhone(input) {

    if (!input) return;
    const val = input.value.trim();
    if (!val) { setInvalid(input); return; }
    /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/.test(val) ? setValid(input) : setInvalid(input);
}

function validateOptional(input) {
    if (!input) return;
    input.value.trim() ? setValid(input) : setNeutral(input);
}


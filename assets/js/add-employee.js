const firstName = document.querySelector('[data-validate="firstName"]');
const lastName = document.querySelector('[data-validate="lastName"]');
const email = document.querySelector('[data-validate="email"]');
const password = document.querySelector('[data-validate="plainPassword"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [firstName, lastName, email, password].filter(Boolean);

allInputs.forEach(input => {
    input.addEventListener('input', validateAll);
    input.addEventListener('change', validateAll);
});

validateAll();

function validateAll() {
    validateRequired(firstName);
    validateRequired(lastName);
    validateEmail(email);
    validatePassword(password);
    checkFormValidaty();
}

function validatePassword(input) {
    if (!input) return;
    const val = input.value;
    const valid =
        val.length >= 10 &&
        /[A-Z]/.test(val) &&
        /[a-z]/.test(val) &&
        /[0-9]/.test(val) &&
        /[^A-Za-z0-9]/.test(val);
    valid ? setValid(input) : setInvalid(input);
}

function validateEmail(input) {

    if (!input) return;
    const val = input.value.trim();
    if (!val) { setInvalid(input); return; }
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) ? setValid(input) : setInvalid(input);
}

function checkFormValidaty() {
    if (allInputs.length === 0) {
        if (submitBtn) submitBtn.disabled = true;
        return;
    }
    const allValid = allInputs.every(i => i.classList.contains('is-valid'));
    if (submitBtn) submitBtn.disabled = !allValid;
}

function setValid(input) { input.classList.add('is-valid'); input.classList.remove('is-invalid'); }
function setInvalid(input) { input.classList.add('is-invalid'); input.classList.remove('is-valid'); }

function validateRequired(input) {
    if (!input) return;
    input.value.trim() ? setValid(input) : setInvalid(input);
}
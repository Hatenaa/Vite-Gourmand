// Implémentation du js de la page d'inscription

const inputName = document.querySelector('[data-validate="firstname"]');
const inputLastName = document.querySelector('[data-validate="lastname"]');
const inputMail = document.querySelector('[data-validate="email"]');
const inputAddress = document.querySelector('[data-validate="address"]');
const inputPhone = document.querySelector('[data-validate="phone"]');
const inputCity = document.querySelector('[data-validate="city"]');
const inputPassword = document.querySelector('[data-validate="password"]');
const submitBtn = document.getElementById('submitBtn');

[inputName, inputLastName, inputMail, inputAddress, inputPhone, inputCity, inputPassword].forEach(input => {
    if (input) input.addEventListener("input", validateForm);
});

function validateForm() {
    validateMinLength(inputName, 2);
    validateMinLength(inputLastName, 2);
    validateEmail(inputMail);
    validateMinLength(inputAddress, 5);
    validatePhone(inputPhone);
    validateCity(inputCity);
    validatePassword(inputPassword);
    checkFormValidity();
}

function checkFormValidity() {
    const required = [inputName, inputLastName, inputMail, inputCity, inputPassword];
    const optional = [inputAddress, inputPhone];

    const allRequiredValid = required
        .filter(i => i !== null)
        .every(i => i.classList.contains('is-valid'));

    const allOptionalValid = optional
        .filter(i => i !== null)
        .every(i => i.value === '' || i.classList.contains('is-valid'));

    submitBtn.disabled = !(allRequiredValid && allOptionalValid);
}

function setValid(input) {
    input.classList.add("is-valid");
    input.classList.remove("is-invalid");
}

function setInvalid(input) {
    input.classList.remove("is-valid");
    input.classList.add("is-invalid");
}

function validateMinLength(input, min) {
    if (!input) return;
    input.value.length >= min ? setValid(input) : setInvalid(input);
}

function validateEmail(input) {
    if (!input) return;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailRegex.test(input.value) ? setValid(input) : setInvalid(input);
}

function validatePhone(input) {
    if (!input) return;
    const phoneRegex = /^[0-9]{10}$/;
    phoneRegex.test(input.value.replace(/\s/g, '')) ? setValid(input) : setInvalid(input);
}

function validateCity(input) {
    if (!input) return;
    const cityRegex = /^[a-zA-ZÀ-ÿ\s\-']{2,}$/;
    cityRegex.test(input.value) ? setValid(input) : setInvalid(input);
}

function validatePassword(input) {
    if (!input) return;
    const v = input.value;
    const valid = v.length >= 10
        && /[A-Z]/.test(v)
        && /[a-z]/.test(v)
        && /[0-9]/.test(v)
        && /[\W_]/.test(v);
    valid ? setValid(input) : setInvalid(input);
}

function validateOptional(input, validatorFn) {
    if (!input) return;
    if (input.value === '') {
        input.classList.remove('is-valid', 'is-invalid');
        return;
    }
    validatorFn();
}
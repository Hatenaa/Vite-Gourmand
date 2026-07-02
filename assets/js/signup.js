import { setValid, setInvalid, validateEmail, validatePhone, validateRequired, validatePassword } from './validators.js';

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

    validateRequired(inputName, 2);
    validateRequired(inputLastName, 2);
    validateEmail(inputMail);
    validateRequired(inputAddress, 5);
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

function validateCity(input) {

    if (!input) return;
    const cityRegex = /^[a-zA-ZÀ-ÿ\s\-']{2,}$/;
    cityRegex.test(input.value) ? setValid(input) : setInvalid(input);
}

function validateOptional(input, validatorFn) {
    
    if (!input) return;
    if (input.value === '') {
        input.classList.remove('is-valid', 'is-invalid');
        return;
    }
    validatorFn();
}
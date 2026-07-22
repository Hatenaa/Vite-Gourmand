import { validateEmail, validatePassword, checkFormValidity } from '../shared/validators.js';

const inputMail = document.querySelector('[data-validate="email"]');
const inputPassword = document.querySelector('[data-validate="password"]');
const submitBtn = document.getElementById('submitBtn');

[inputMail, inputPassword].forEach(input => {
    if (input) input.addEventListener("input", validateForm);
});

function validateForm() {
    validateEmail(inputMail);
    validatePassword(inputPassword);
    checkFormValidity([inputMail, inputPassword], submitBtn);
}
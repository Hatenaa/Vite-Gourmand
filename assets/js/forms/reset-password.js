import { validatePassword, setValid, setInvalid, checkFormValidity } from '../shared/validators.js';

const inputFirstPassword = document.querySelector('[data-validate="firstPassword"]');
const inputLastPassword = document.querySelector('[data-validate="lastPassword"]');
const submitBtn = document.querySelector('[type="submit"]');

[inputFirstPassword, inputLastPassword].forEach(input => {
    if (input) input.addEventListener("input", validateForm);
});

if (inputLastPassword) {
    inputLastPassword.addEventListener('paste', (e) => {
        e.preventDefault();
        inputLastPassword.classList.add('is-invalid');
    });
}

function validateForm() {
    validatePassword(inputFirstPassword);
    validatePasswordsMatch();
    checkFormValidity([inputFirstPassword, inputLastPassword], submitBtn);
}

function validatePasswordsMatch() {
    if (!inputFirstPassword || !inputLastPassword) return false;
    
    const passwordsMatch = inputFirstPassword.value === inputLastPassword.value && inputFirstPassword.value !== '';
    passwordsMatch ? setValid(inputLastPassword) : setInvalid(inputLastPassword);
    return passwordsMatch;
}
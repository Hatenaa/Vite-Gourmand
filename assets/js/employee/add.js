import { validateRequired, validateEmail, validatePassword, setupFormValidation } from "../shared/validators.js";

const firstName = document.querySelector('[data-validate="firstName"]');
const lastName = document.querySelector('[data-validate="lastName"]');
const email = document.querySelector('[data-validate="email"]');
const password = document.querySelector('[data-validate="plainPassword"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [firstName, lastName, email, password];

const validators = [
    { field: firstName, validateFn: validateRequired, params: [2] },
    { field: lastName, validateFn: validateRequired, params: [2] },
    { field: email, validateFn: validateEmail },
    { field: password, validateFn: validatePassword },
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators,
});
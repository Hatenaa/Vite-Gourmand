import { validateRequired, validateEmail, validatePassword, setupFormValidation } from "./validators";

const firstName = document.querySelector('[data-validate="firstName"]');
const lastName = document.querySelector('[data-validate="lastName"]');
const email = document.querySelector('[data-validate="email"]');
const password = document.querySelector('[data-validate="plainPassword"]');
const submitBtn = document.querySelector('button[type="submit"]');

const validators = [
    { field: firstName, validateFn: validateRequired },
    { field: lastName, validateFn: validateRequired },
    { field: email, validateFn: validateEmail },
    { field: password, validateFn: validatePassword },
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators,
});
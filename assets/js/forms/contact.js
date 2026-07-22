import { validateRequired, validateEmail, setupFormValidation } from '../shared/validators.js';

const titleInput = document.querySelector('[data-validate="contactTitle"]');
const emailInput = document.querySelector('[data-validate="contactEmail"]');
const messageInput = document.querySelector('[data-validate="contactMessage"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [titleInput, emailInput, messageInput].filter(Boolean);

const validators = [
    { field: titleInput, validateFn: validateRequired, params: [2] }, // min 2 caractères
    { field: emailInput, validateFn: validateEmail },
    { field: messageInput, validateFn: validateRequired, params: [10] } // min 10 caractères
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators,
});

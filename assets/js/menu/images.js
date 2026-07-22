import {  validateImageFile, validatePosition, setupFormValidation } from '../shared/validators.js';

const fileInput = document.querySelector('[data-validate="menuImageFile"]');
const positionInput = document.querySelector('[data-validate="menuImagePosition"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [fileInput, positionInput].filter(Boolean);

const validators = [
    { field: fileInput, validateFn: validateImageFile },
    { field: positionInput, validateFn: validatePosition }
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators
});
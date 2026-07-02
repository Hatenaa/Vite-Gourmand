import { validateRequired, setupFormValidation } from './validators';

const titleInput = document.querySelector('[data-validate="dishTitle"]');
const typeSelect = document.querySelector('[data-validate="dishType"]');
const descriptionInput = document.querySelector('[data-validate="dishDescription"]');
const imageFileInput = document.querySelector('[data-validate="dishImageFile"]');
const submitBtn = document.querySelector('button[type="submit"]');

const requiredInputs = [titleInput, typeSelect].filter(Boolean);
const allInputs = [titleInput, typeSelect, descriptionInput, imageFileInput].filter(Boolean);

const validators = [
    { field: titleInput, validateFn: validateRequired, params: [0, 255] },
    { field: typeSelect, validateFn: validateRequired },
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators,
    checkInputs: requiredInputs
});
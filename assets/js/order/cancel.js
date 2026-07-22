import { validateSelectRequired, validateRequired, setupFormValidation } from '../shared/validators.js';

const contactModeInput = document.querySelector('[data-validate="contactMode"]');
const reasonInput = document.querySelector('[data-validate="reason"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [contactModeInput, reasonInput].filter(Boolean);

const validators = [
    { field: contactModeInput, validateFn: validateSelectRequired },
    { field: reasonInput, validateFn: validateRequired, params: [10] }
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators
});
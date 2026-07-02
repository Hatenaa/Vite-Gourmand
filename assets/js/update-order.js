import { validateSelectRequired, validateRequired, setupFormValidation } from './validators';

const statusInput = document.querySelector('[data-validate="status"]');
const contactModeInput = document.querySelector('[data-validate="contactMode"]');
const reasonInput = document.querySelector('[data-validate="reason"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [statusInput, contactModeInput, reasonInput].filter(Boolean);

const validators = [
    { field: statusInput, validateFn: validateSelectRequired },
    { field: contactModeInput, validateFn: validateSelectRequired },
    { field: reasonInput, validateFn: validateRequired, params: [10] }
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators
});
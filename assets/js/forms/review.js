import { validatePositiveNumber, validateRequired, setupFormValidation, } from "../shared/validators";

const noteInput = document.querySelector('[data-validate="note"]');
const reviewInput = document.querySelector('[data-validate="comment"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [noteInput, reviewInput].filter(Boolean);

const validators = [
    { field: noteInput, validateFn: validatePositiveNumber, params: [1, 5] },
    { field: reviewInput, validateFn: validateRequired, params: [6] },
]

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators,
});
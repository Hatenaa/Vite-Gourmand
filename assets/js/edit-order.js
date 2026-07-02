import { validateRequired, validateDate, validatePeople, setupFormValidation } from './validators';

const addressInput = document.querySelector('[data-validate="address"]');
const cityInput = document.querySelector('[data-validate="city"]');
const dateInput = document.querySelector('[data-validate="date"]');
const timeInput = document.querySelector('[data-validate="time"]');
const peopleInput = document.querySelector('[data-validate="people"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [addressInput, cityInput, dateInput, timeInput, peopleInput].filter(Boolean);

const validators = [
    { field: addressInput, validateFn: validateRequired },
    { field: cityInput, validateFn: validateRequired },
    { field: dateInput, validateFn: validateDate },
    { field: timeInput, validateFn: validateRequired },
    { field: peopleInput, validateFn: validatePeople, params: [1] }
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators
});
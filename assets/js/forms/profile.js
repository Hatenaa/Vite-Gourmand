import { validateRequired, validateEmail, validatePhone, setupFormValidation, validateOptional } from "../shared/validators";

const firstNameInput = document.querySelector('[data-validate="firstName"]');
const lastNameInput = document.querySelector('[data-validate="lastName"]');
const emailInput = document.querySelector('[data-validate="email"]');
const phoneInput = document.querySelector('[data-validate="phone"]');
const addressInput = document.querySelector('[data-validate="address"]');
const cityInput = document.querySelector('[data-validate="city"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [firstNameInput, lastNameInput, emailInput, phoneInput, addressInput, cityInput].filter(Boolean);

const validators = [
    { field: firstNameInput, validateFn: validateRequired },
    { field: lastNameInput, validateFn: validateRequired },
    { field: emailInput, validateFn: validateEmail },
    { field: phoneInput, validateFn: validatePhone },
    { field: addressInput, validateFn: validateOptional },
    { field: cityInput, validateFn: validateOptional }
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators,
});
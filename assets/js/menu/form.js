import { validateRequired, validatePrice, validatePositiveNumber, setupFormValidation } from './validators';

const titleInput = document.querySelector('[data-validate="menuTitle"]');
const basePriceInput = document.querySelector('[data-validate="menuBasePrice"]');
const minPeopleInput = document.querySelector('[data-validate="menuMinPeople"]');
const stockInput = document.querySelector('[data-validate="menuStock"]');
const conditionsInput = document.querySelector('[data-validate="menuConditions"]');
const themeSelect = document.querySelector('[data-validate="menuTheme"]');
const regimeSelect = document.querySelector('[data-validate="menuRegime"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [ titleInput, basePriceInput, minPeopleInput, stockInput, conditionsInput, themeSelect, regimeSelect ].filter(Boolean);

const validators = [
    { field: titleInput, validateFn: validateRequired, params: [0, 45] },
    { field: basePriceInput, validateFn: validatePrice },
    { field: minPeopleInput, validateFn: validatePositiveNumber },
    { field: stockInput, validateFn: validatePositiveNumber },
    { field: conditionsInput, validateFn: validateRequired },
    { field: themeSelect, validateFn: validateRequired },
    { field: regimeSelect, validateFn: validateRequired }
];

setupFormValidation({
    inputs: allInputs,
    submitBtn: submitBtn,
    validators: validators
});
const contactModeInput = document.querySelector('[data-validate="contactMode"]');
const reasonInput = document.querySelector('[data-validate="reason"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [contactModeInput, reasonInput].filter(Boolean);

allInputs.forEach(input => {
    input.addEventListener('input', validateAll);
    input.addEventListener('change', validateAll);
});

validateAll();

function validateAll() {

    validateSelectRequired(contactModeInput);
    validateRequired(reasonInput);
    checkFormValidity();
}

function checkFormValidity() {

    const hasInvalid = allInputs.some(input => input.classList.contains('is-invalid'));
    if (submitBtn) {
        submitBtn.disabled = hasInvalid;
    }
}

function setValid(input) {

    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
}

function setInvalid(input) {

    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
}

function validateSelectRequired(input) {

    if (!input) return;
    const value = input.value;
    if (value && value.trim() !== '') {
        setValid(input);
    } else {
        setInvalid(input);
    }
}

function validateRequired(input) {

    if (!input) return;
    const value = input.value.trim();

    if (value.length >= 10) {
        setValid(input);
    } else {
        setInvalid(input);
    }
}
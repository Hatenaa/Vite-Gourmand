const statusInput = document.querySelector('[data-validate="status"]');
const contactModeInput = document.querySelector('[data-validate="contactMode"]');
const reasonInput = document.querySelector('[data-validate="reason"]');
const submitBtn = document.querySelector('button[type="submit"]');

const allInputs = [statusInput, contactModeInput, reasonInput].filter(Boolean);

allInputs.forEach(input => {
    input.addEventListener('input', validateAll);
    input.addEventListener('change', validateAll);
});

validateAll();

function validateAll() {

    validateSelectRequired(statusInput);
    validateSelectRequired(contactModeInput);
    validateReason(reasonInput);
    checkFormValidaty();
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

function setNeutral(input) {
    input.classList.remove('is-valid', 'is-invalid');
}

function validateSelectRequired(input) {

    if (!input) return;
    const value = input.value;

    if (value && value.trim() !== '') {
        setValid(input)
    } else {
        setInvalid(input);
    }
}

function validateReason(input) {
    
    if (!input) return;
    const value = input.value.trim();

    if (value === '') {
        setNeutral(input);
    } else {
        setValid(input);
    }
}
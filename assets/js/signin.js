// Implémentation du JS de la page de connexion

const inputMail = document.querySelector('[data-validate="email"]');
const inputPassword = document.querySelector('[data-validate="password"]');
const submitBtn = document.getElementById('submitBtn');

[inputMail, inputPassword].forEach(input => {
    if (input) input.addEventListener("input", validateForm);
});

function validateForm() {
    validateEmail(inputMail);
    validateRequired(inputPassword);
    checkFormValidity();
}

function checkFormValidity() {
    const allValid = [inputMail, inputPassword]
        .filter(i => i !== null)
        .every(i => i.classList.contains('is-valid'));
    submitBtn.disabled = !allValid;
}

function setValid(input) {
    input.classList.add("is-valid");
    input.classList.remove("is-invalid");
}

function setInvalid(input) {
    input.classList.remove("is-valid");
    input.classList.add("is-invalid");
}

function validateEmail(input) {
    if (!input) return;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailRegex.test(input.value) ? setValid(input) : setInvalid(input);
}

function validateRequired(input) {
    if (!input) return;
    input.value !== '' ? setValid(input) : setInvalid(input);
}

/* Utilitaires de classes */
export function setValid(input) {
    input.classList.add('is-valid');
    input.classList.remove('is-invalid');
}

export function setInvalid(input) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
}

export function setNeutral(input) {
    input.classList.remove('is-valid', 'is-invalid');
}

/* Validations de base */
export function validateRequired(input, minLength = 0, maxLength = null) {

    if (!input) return false;
    const val = input.value.trim();
    const valid = val.length >= minLength && (!maxLength || val.length <= maxLength);
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validateEmail(input) {

    if (!input) return false;
    const val = input.value.trim();
    if (!val) { setInvalid(input); return false; }
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validatePassword(input) {

    if (!input) return false;
    const val = input.value;
    const valid = val.length >= 10 &&
        /[A-Z]/.test(val) &&
        /[a-z]/.test(val) &&
        /[0-9]/.test(val) &&
        /[^A-Za-z0-9]/.test(val);
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validatePhone(input) {

    if (!input) return false;
    const val = input.value.trim();
    if (!val) { setInvalid(input); return false; }
    const valid = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/.test(val);
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validateSelectRequired(input) {

    if (!input) return false;
    const val = input.value;
    const valid = val && val.trim() !== '';
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validateDate(input) {

    if (!input) return false;
    if (!input.value) { setInvalid(input); return false; }
    const selected = new Date(input.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const valid = selected >= today;
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validatePeople(input, minPeople = 1) {

    if (!input) return false;
    const val = parseInt(input.value, 10);
    const valid = !isNaN(val) && val >= minPeople;
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validatePrice(input) {

    if (!input) return false;
    const val = parseFloat(input.value);
    const valid = !isNaN(val) && val > 0;
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validatePositiveNumber(input, minValue = 0, maxValue = null) {

    if (!input) return false;
    const val = parseInt(input.value, 10);
    const valid = !isNaN(val) && val >= minValue && (!maxValue || val <= maxValue);
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validateImageFile(input) {

    if (!input) return false;
    const valid = input.files && input.files.length > 0;
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

export function validatePosition(input) {

    if (!input) return false;
    const val = parseInt(input.value, 10);
    const valid = !isNaN(val) && val >= 0;
    valid ? setValid(input) : setInvalid(input);
    return valid;
}

/* Fonction utilitaire pour vérifier la validité globale du formulaire */
export function checkFormValidity(inputs, submitBtn) {

    if (!inputs || inputs.length === 0) {
        if (submitBtn) submitBtn.disabled = true;
        return;
    }
    const allValid = inputs.every(input => input.classList.contains('is-valid'));
    if (submitBtn) submitBtn.disabled = !allValid;
}

export function setupFormValidation({ inputs, submitBtn, validators, checkInputs = null }) {

    let hasStartedEditing = false;
    if (submitBtn) submitBtn.disabled = true;

    const validateAll = () => {

        if (!hasStartedEditing) return;
        validators.forEach(({ field, validateFn, params = [] }) => {
            
            validateFn(field, ...params);
        });

        const inputsToCheck = checkInputs || inputs;
        checkFormValidity(inputsToCheck, submitBtn);
    };

    inputs.forEach(input => {
        input.addEventListener('input', () => { hasStartedEditing = true; validateAll(); });
        input.addEventListener('change', () => { hasStartedEditing = true; validateAll(); });
    });

    return validateAll;
}
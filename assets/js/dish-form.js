document.addEventListener('DOMContentLoaded', function() {

    const titleInput = document.getElementById('dish_title');
    const typeSelect = document.getElementById('dish_type');
    const descriptionInput = document.getElementById('dish_description');
    const imageFileInput = document.getElementById('dish_imageFile');
    const submitBtn = document.querySelector('button[type="submit"]');

    const requiredInputs = [titleInput, typeSelect].filter(Boolean);
    const allInputs = [titleInput, typeSelect, descriptionInput, imageFileInput].filter(Boolean);
    let hasStartedEditing = false;

    allInputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
        input.addEventListener('input', () => {
            hasStartedEditing = true;
            validateAll();
        });
        input.addEventListener('change', () => {
            hasStartedEditing = true;
            validateAll();
        });
    });

    function validateAll() {
        if (!hasStartedEditing) return;

        validateRequired(titleInput, 255);
        validateRequired(typeSelect);
        checkFormValidity();
    }

    function validateRequired(input, maxLength = null) {
        if (!input) return;
        const val = input.value.trim();
        const valid = val.length > 0 && (!maxLength || val.length <= maxLength);
        valid ? setValid(input) : setInvalid(input);
    }

    function checkFormValidity() {
        if (requiredInputs.length === 0) {
            if (submitBtn) submitBtn.disabled = true;
            return;
        }

        const allValid = requiredInputs.every(i => i.classList.contains('is-valid'));
        if (submitBtn) submitBtn.disabled = !allValid;
    }

    function setValid(input) {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
    }

    function setInvalid(input) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.querySelector('input[name*="[imageFile]"]');
    const positionInput = document.querySelector('input[name*="[position]"]');
    const submitBtn = document.querySelector('button[type="submit"]');

    const allInputs = [fileInput, positionInput].filter(Boolean);
    let hasStartedEditing = false;

    allInputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    allInputs.forEach(input => {
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
        
        validateImageFile(fileInput);
        validatePosition(positionInput);
        checkFormValidity();
    }

    function validateImageFile(input) {
        if (!input) return;
        const valid = input.files && input.files.length > 0;
        valid ? setValid(input) : setInvalid(input);
    }

    function validatePosition(input) {
        if (!input) return;
        const val = parseInt(input.value);
        const valid = !isNaN(val) && val >= 0;
        valid ? setValid(input) : setInvalid(input);
    }

    function checkFormValidity() {
        if (allInputs.length === 0) {
            if (submitBtn) submitBtn.disabled = true;
            return;
        }

        const allValid = allInputs.every(i => i.classList.contains('is-valid'));
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

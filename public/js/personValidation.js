document.addEventListener("DOMContentLoaded", function () {
    const personForm = document.getElementById("person-form");
    const firstNameInput = document.querySelector("#person-form input[name='first_name']");
    const lastNameInput = document.querySelector("#person-form input[name='last_name']");
    const birthDateInput = document.querySelector("#person-form input[name='birth_date']");
    const personImageInput = document.querySelector("#person-form input[name='image']");
    const personDescriptionInput = document.querySelector("#person-form textarea[name='description']");

    function setValidationMessage(inputElement, message, isValid) {
        let msgElem = inputElement.nextElementSibling;
        if (!msgElem || !msgElem.classList.contains("validation-message")) {
            msgElem = document.createElement("span");
            msgElem.className = "validation-message";
            inputElement.insertAdjacentElement("afterend", msgElem);
        }
        msgElem.textContent = message;
        msgElem.style.color = isValid ? "green" : "red";
        inputElement.style.border = isValid ? "1px solid green" : "1px solid red";
    }

    function validateFirstName() {
        const name = firstNameInput.value.trim();
        const lettersOnlyRegex = /^[A-Za-z]+$/;
        if (name.length < 2) {
            setValidationMessage(firstNameInput, "First name must be at least 2 characters.", false);
            return false;
        } else if (!lettersOnlyRegex.test(name)) {
            setValidationMessage(firstNameInput, "First name can only contain letters.", false);
            return false;
        } else {
            setValidationMessage(firstNameInput, "", true);
            return true;
        }
    }

    function validateLastName() {
        const name = lastNameInput.value.trim();
        const lettersOnlyRegex = /^[A-Za-z]+$/;
        if (name.length < 2) {
            setValidationMessage(lastNameInput, "Last name must be at least 2 characters.", false);
            return false;
        } else if (!lettersOnlyRegex.test(name)) {
            setValidationMessage(lastNameInput, "Last name can only contain letters.", false);
            return false;
        } else {
            setValidationMessage(lastNameInput, "", true);
            return true;
        }
    }


    function validateBirthDate() {
        if (!birthDateInput.value) {
            setValidationMessage(birthDateInput, "Birth date is required.", false);
            return false;
        } else {
            const birthDate = new Date(birthDateInput.value);
            const today = new Date();
            const minDate = new Date("1900-01-01");

            if (birthDate > today) {
                setValidationMessage(birthDateInput, "Birth date cannot be in the future.", false);
                return false;
            } else if (birthDate < minDate) {
                setValidationMessage(birthDateInput, "Birth date must be after January 1, 1900.", false);
                return false;
            } else {
                setValidationMessage(birthDateInput, "", true);
                return true;
            }
        }
    }


    function validatePersonDescription() {
        if (personDescriptionInput.value.trim().length < 10) {
            setValidationMessage(personDescriptionInput, "Description must be at least 10 characters.", false);
            return false;
        } else {
            setValidationMessage(personDescriptionInput, "", true);
            return true;
        }
    }


    function debounce(func, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }


    if (firstNameInput) {
        firstNameInput.addEventListener("keyup", debounce(validateFirstName, 500));
    }
    if (lastNameInput) {
        lastNameInput.addEventListener("keyup", debounce(validateLastName, 500));
    }
    if (birthDateInput) {
        birthDateInput.addEventListener("change", validateBirthDate);
    }
    if (personDescriptionInput) {
        personDescriptionInput.addEventListener("keyup", debounce(validatePersonDescription, 500));
    }
});

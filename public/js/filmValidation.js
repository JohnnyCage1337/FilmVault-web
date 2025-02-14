document.addEventListener("DOMContentLoaded", function () {
    const filmForm = document.getElementById("film-form");
    const titleInput = document.querySelector("#film-form input[name='title']");
    const yearInput = document.querySelector("#film-form input[name='year']");
    const genreInput = document.querySelector("#film-form input[name='genre']");
    const peopleInput = document.querySelector("#film-form input[name='people']");
    const durationInput = document.querySelector("#film-form input[name='duration']");
    const imageInput = document.querySelector("#film-form input[name='image']");
    const descriptionInput = document.querySelector("#film-form textarea[name='description']");

    let allGenresSet = new Set();
    let checkedPeople = new Set();

    fetch("/getAllGenres")
        .then(response => response.json())
        .then(data => {
            data.forEach(genre => {
                allGenresSet.add(genre.id.toLowerCase());
            });
            console.log("Pobrane gatunki:", allGenresSet);
        })
        .catch(error => {
            console.error("Błąd przy pobieraniu gatunków:", error);
        });

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

    function validateTitle() {
        if (titleInput.value.trim().length < 2) {
            setValidationMessage(titleInput, "Title must be at least 2 characters.", false);
            return false;
        } else {
            setValidationMessage(titleInput, "", true);
            return true;
        }
    }

    function validateYear() {
        const year = parseInt(yearInput.value.trim());
        const currentYear = new Date().getFullYear();
        if (isNaN(year) || year < 1900 || year > currentYear + 5) {
            setValidationMessage(yearInput, `Year must be between 1900 and ${currentYear + 5}.`, false);
            return false;
        } else {
            setValidationMessage(yearInput, "", true);
            return true;
        }
    }

    function validateDuration() {
        const duration = parseInt(durationInput.value.trim());
        if (isNaN(duration) || duration <= 0) {
            setValidationMessage(durationInput, "Duration must be a positive number.", false);
            return false;
        } else {
            setValidationMessage(durationInput, "", true);
            return true;
        }
    }

    function validateDescription() {
        if (descriptionInput.value.trim().length < 10) {
            setValidationMessage(descriptionInput, "Description must be at least 10 characters.", false);
            return false;
        } else {
            setValidationMessage(descriptionInput, "", true);
            return true;
        }
    }

    function isGenresInDataBase(genreInput) {
        const genresArray = genreInput.value.split(",")
            .map(genre => genre.trim())
            .filter(genre => genre !== "");
        let genreMessage = document.getElementById("genreMessage");
        if (!genreMessage) {
            genreMessage = document.createElement("span");
            genreMessage.id = "genreMessage";
            genreMessage.style.display = "block";
            genreInput.parentNode.insertBefore(genreMessage, genreInput.nextSibling);
        }
        if (genresArray.length === 0) {
            setValidationMessage(genreInput, "At least 1 genre.", false);
            return;
        }
        else{
            setValidationMessage(genreInput, "", true);

        }
        const missingGenres = genresArray.filter(genre => !allGenresSet.has(genre.toLowerCase()));
        if (missingGenres.length > 0) {
            genreMessage.textContent = "Not found genres:" + missingGenres.join(", ") + ". Will be added to database.";
            genreMessage.style.color = "red";
            genreInput.style.border = "1px solid red";
        } else {
            genreMessage.textContent = "All genres exitst in database.";
            genreMessage.style.color = "green";
            genreInput.style.border = "1px solid green";
        }
    }

    function isPeopleInDataBase(peopleInput) {
        const peopleArray = peopleInput.value.split(/[,\/]+/)
            .map(person => person.trim())
            .filter(person => person !== "");
        let peopleMessage = document.getElementById("peopleMessage");
        if (!peopleMessage) {
            peopleMessage = document.createElement("span");
            peopleMessage.id = "peopleMessage";
            peopleMessage.style.display = "block";
            peopleInput.parentNode.insertBefore(peopleMessage, peopleInput.nextSibling);
        }
        if (peopleArray.length === 0) {
            setValidationMessage(peopleInput, "Type at least 1 person.", false);
            return;
        }
        const peopleString = encodeURIComponent(peopleArray.join(","));
        fetch(`/isPeopleInDataBase/${peopleString}`)
            .then(response =>
                response.json().then(data => ({ status: response.status, body: data }))
            )
            .then(({ status, body }) => {
                if (status === 200) {
                    peopleMessage.textContent = "All persons exist in data base.";
                    peopleMessage.style.color = "green";
                    peopleInput.style.border = "1px solid green";
                    peopleArray.forEach(person => checkedPeople.add(person.toLowerCase()));
                } else if (status === 404) {
                    peopleMessage.textContent = "Not found persons: " + body.error;
                    peopleMessage.style.color = "red";
                    peopleInput.style.border = "1px solid red";
                } else if (status === 403) {
                    peopleMessage.textContent = "Error: Not logged";
                    peopleMessage.style.color = "red";
                    peopleInput.style.border = "1px solid red";
                } else {
                    peopleMessage.textContent = "Unexpected error";
                    peopleMessage.style.color = "red";
                    peopleInput.style.border = "1px solid red";
                }
            })
            .catch(error => {
                console.error("Błąd sieci:", error);
                peopleMessage.textContent = "Error.";
                peopleMessage.style.color = "red";
                peopleInput.style.border = "1px solid red";
            });
    }

    function debounce(func, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }

    if (titleInput) {
        titleInput.addEventListener("keyup", debounce(validateTitle, 500));
    }
    if (yearInput) {
        yearInput.addEventListener("keyup", debounce(validateYear, 500));
    }
    if (durationInput) {
        durationInput.addEventListener("keyup", debounce(validateDuration, 500));
    }
    if (descriptionInput) {
        descriptionInput.addEventListener("keyup", debounce(validateDescription, 500));
    }
    if (genreInput) {
        let debounceTimerGenres;
        const debounceDelay = 1000;
        genreInput.addEventListener("keyup", function () {
            clearTimeout(debounceTimerGenres);
            debounceTimerGenres = setTimeout(() => isGenresInDataBase(genreInput), debounceDelay);
        });
        genreInput.addEventListener("keydown", function () {
            clearTimeout(debounceTimerGenres);
        });
    }
    if (peopleInput) {
        let debounceTimerPeople;
        peopleInput.addEventListener("keyup", function () {
            clearTimeout(debounceTimerPeople);
            debounceTimerPeople = setTimeout(() => isPeopleInDataBase(peopleInput), 1000);
        });
        peopleInput.addEventListener("keydown", function () {
            clearTimeout(debounceTimerPeople);
        });
    }
});

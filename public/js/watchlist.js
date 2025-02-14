const main = document.querySelector("main");
const bookmarkButton = main.querySelector(".fa-bookmark");


function addToWatchList() {
    const bookmarked = this;
    const container = bookmarked.parentElement.parentElement;
    const id = container.getAttribute("id");

    fetch(`/addToWatchList/${id}`)
        .then(response => response.json().then(data => ({ status: response.status, body: data }))) // Pobranie statusu i JSON
        .then(({ status, body }) => {
            if (status === 200) {
                alert("Success" + body.success);
            } else if (status === 403) {
                alert("Error" + body.error + " (Not logged)");
            } else if (status === 400) {
                alert("Error: Niepoprawne żądanie.");
            } else if (status === 500) {
                alert("Error:" + " Already bookmarked.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Not logged .");
        });
}



    bookmarkButton.addEventListener("click", addToWatchList);



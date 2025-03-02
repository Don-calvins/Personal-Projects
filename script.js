document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("send_mail.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("responseMessage").innerText = data.message;
        if (data.status === "success") {
            this.reset();
        }
    })
    .catch(error => console.error("Error:", error));
});

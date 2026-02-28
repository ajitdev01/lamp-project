setTimeout(function () {
    const alertBox = document.getElementById("alertMessage");
    if (alertBox) {
        alertBox.classList.remove("show");
        setTimeout(function () {
            alertBox.classList.add("d-none");
        }, 300); 
    }
}, 3000);
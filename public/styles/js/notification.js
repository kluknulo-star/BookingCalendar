let toast = document.querySelectorAll('.flash')

toast.forEach(function (el) {
    console.log(el.dataset.flahType);

    Toastify({
        text: el.textContent.trim(),
        // className: el.dataset.flashType.toString(),
        className: "has-background-",
        duration: 7000,
        close: true,
        gravity: "bottom",
        position: "right",
        stopOnFocus: true
    }).showToast();
})
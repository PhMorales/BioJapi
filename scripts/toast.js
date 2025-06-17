function showToast(type, message) {
    let toastBox = document.querySelector(".toastBox")
    let toast = document.createElement("div")
    toast.classList.add("toast")

    if (type == "Erro") {
        message = "<i class='fa-solid fa-circle-xmark'></i>" + message

        toast.classList.add("error")
    } else if (type == "Alerta") {
        message = "<i class='fa-solid fa-circle-exclamation'></i>" + message

        toast.classList.add("warning")
    } else {
        message = "<i class='fa-solid fa-circle-check'></i>" + message
    }

    toast.innerHTML = message

    toastBox.appendChild(toast)

    var after = window.getComputedStyle(toast, "::after")
    const verificacao = setInterval(() => {
        if (parseFloat(after.getPropertyValue("width")) <= 0) {
            sair()
        }
    }, 300)

    toast.addEventListener('click', () => sair())

    function sair() {
        clearInterval(verificacao)
        toast.classList.add("leave")
        toast.addEventListener('animationend', () => {
            toast.remove()
        })
    }
}

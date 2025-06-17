<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <title>BioJapi</title>
    <link rel="stylesheet" href="../Css/changePass.css">
    <link rel="stylesheet" href="../Css/components/toast.css">
    <link rel="stylesheet" href="../Css/components/modal.css">

</head>

<body>
    <!-- Página -->
    <div class="loginContainer">
        <!-- Imagem -->
        <div class="loginImg">
            <img src="../img/pages_usage/serra.jpg" alt="">
        </div>
        <!-- Espaço para o formulario de registro -->
        <div class="loginForm">
            <div class="btnVoltar">
                <a href="../Pages/login.php"><i class="fa-solid fa-arrow-left"></i> Cancelar</a>
            </div>
            <div class="loginPresentation">



                <div class="imgLogin">
                    <img src="../img/logo/bioJapi4.svg" alt="Logo BioJapi" class="logo">
                    <h1>BioJapi</h1>
                    <h3>Redefinição de senha</h3>
                </div>

            </div>
            <!-- Formulário de registro -->
            <form class="redefForm email" method="post">
                <div class="inputs">
                    <div class="input">
                        <label for="email">Insira seu email</label>
                        <input type="email" name="email" id="email" placeholder="Exemplo@email.com">
                    </div>

                    <div class="input hidden">
                        <label for="senha">Nova senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Digite a nova senha">
                    </div>
                    <div class="input hidden">
                        <label for="confirmarSenha">Confirme a nova senha</label>
                        <input type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirme a nova senha">
                    </div>
                </div>


                <div class="button">
                    <button type="submit" class="sendBtn">Enviar código</button>
                </div>


            </form>

        </div>

    </div>

    <div class="toastBox"></div>

    <div id="codeModal" class="modal hidden">
        <div class="modal-content">
            <h2>Verificação de Email</h2>
            <p>Insira o código que enviamos para seu email:</p>
            <input type="text" id="verificationCodeInput" placeholder="Digite o código" />
            <div class="modal-buttons">
                <button id="verifyCodeBtn">Verificar</button>
                <button id="cancelModalBtn">Cancelar</button>
            </div>
        </div>
    </div>


    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>

    <script>
        let verificationCode = ""
        const form = document.querySelector(".redefForm")
        form.addEventListener("submit", async (event) => {
            event.preventDefault()
            if (form.classList.contains('email')) {
                if (event.srcElement[0].value == false) {
                    showToast("Alerta", "Preencha o email")
                    return
                }
                showModal()
                verificationCode = await generateCode(verificationCode, event.srcElement[0].value)
                return
            }
            if (event.srcElement[0].value == false) {
                showToast("Alerta", "Preencha o email")
                return
            }
            if (event.srcElement[1].value == false) {
                showToast("Alerta", "Preencha a senha")
                return
            }
            if (event.srcElement[1].value.length < 8) {
                showToast("Alerta", "A senha deve ter pelo menos 8 caracteres")
                return
            }
            if (event.srcElement[2].value == false) {
                showToast("Alerta", "Confirme a senha")
                return
            }
            if (event.srcElement[1].value != event.srcElement[2].value) {
                showToast("Erro", "As senhas não coincidem")
                return
            }
            const formData = new FormData()
            formData.append("email", event.srcElement[0].value)
            formData.append("senha", event.srcElement[1].value)
            changePass(formData)

        })






        async function changePass(formData) {
            let passResult = ""
            const pass = await fetch("../Action/user/changePass.php", {
                method: "POST",
                body: formData
            })
            passResult = await pass.text()
            if (passResult == "Sucesso") {
                window.location.href = './login.php?passResult=Sucesso'

            }
            if (passResult == "FalhaUser") {
                showToast("Erro", "Usuário não cadastrado")
                return
            }
            if (passResult == "FalhaPDO") {
                showToast("Erro", "Houve um erro ao alterar a senha")
                return
            }
        }

        let limitDate = new Date(0)

        async function generateCode(code, email) {
            if (new Date().getTime() < limitDate.getTime()) {
                return code
            }
            limitDate = new Date().getTime() + 300000
            limitDate = new Date(limitDate)
            const codigo = Math.floor(100000 + Math.random() * 900000).toString()
            const codeFormData = new FormData()
            codeFormData.append("codigo", codigo)
            codeFormData.append("email", email)
            const sendCodePhp = await fetch('../Action/sendCode.php', {
                method: "POST",
                body: codeFormData
            })
            let codeResult = await sendCodePhp.text()
            if (codeResult == "FalhaEmail") {
                showToast("Erro", "Email inválido")
                return
            }
            return codigo
        }

        function showModal() {
            document.getElementById("codeModal").classList.remove("hidden")
        }

        function hideModal() {
            document.getElementById("codeModal").classList.add("hidden")
        }

        document.getElementById("cancelModalBtn").addEventListener("click", hideModal)
        document.getElementById("verifyCodeBtn").addEventListener("click", async () => {
            const inputCode = document.getElementById("verificationCodeInput").value
            console.log(verificationCode, inputCode)
            if (inputCode === verificationCode && new Date().getTime() < limitDate.getTime()) {

                hideModal()
                form.classList.remove("email")
                document.querySelectorAll(".input.hidden").forEach(div => {
                    div.classList.remove('hidden')

                })
                document.querySelector(".sendBtn").innerHTML = "Redefinir Senha"

            } else {
                showToast("Erro", "Código incorreto")
            }
        })
    </script>
</body>

</html>
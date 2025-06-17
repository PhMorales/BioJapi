<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <title>BioJapi</title>
    <link rel="stylesheet" href="../Css/register.css">
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
                <a href="../index.php"><i class="fa-solid fa-arrow-left"></i> Voltar à pagina inicial</a>
            </div>
            <div class="loginPresentation">



                <div class="imgLogin">
                    <img src="../img/logo/bioJapi4.svg" alt="Logo BioJapi" class="logo">
                    <h1>BioJapi</h1>
                    <h3>Crie sua conta</h3>
                </div>

            </div>
            <!-- Formulário de registro -->
            <form class="registerForm" method="post">

                <div class="input">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" placeholder="Nome A. B. Sobrenome">
                </div>

                <div class="input">
                    <label for="username">Nome de usuário</label>
                    <input type="text" name="username" id="username" placeholder="nomedeusuario123">
                </div>

                <div class="input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="exemplo@email.com">
                </div>

                <div class="input">
                    <label for="password">Senha (mínimo 8 caracteres)</label>
                    <input type="password" name="password" id="password" placeholder="********">
                </div>
                <div class="input">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado">
                        <option value="" selected>SELECIONE</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="input">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" placeholder="Jundiaí">
                </div>

                <div class="button">
                    <button type="submit">Registrar</button>
                </div>

                <div class="switchP">
                    <p class="loginOption">Já possui uma conta? <a href="./login.php" class="switchLogin">Entrar</a></p>
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
        const form = document.querySelector(".registerForm")
        form.addEventListener("submit", async (event) => {
            event.preventDefault()

            if (event.srcElement[0].value == false) {
                showToast("Alerta", "Preencha o nome")
                return
            }
            if (event.srcElement[1].value == false) {
                showToast("Alerta", "Preencha o nome de usuário")
                return
            }

            if (event.srcElement[1].value.length < 3) {
                showToast("Alerta", "O nome de usuário deve ter pelo menos 3 caracteres")
                return
            }

            if (event.srcElement[2].value == false) {
                showToast("Alerta", "Preencha o email")
                return
            }

            if (event.srcElement[3].value == false) {
                showToast("Alerta", "Preencha a senha")
                return
            }
            if (event.srcElement[3].value.length < 8 || event.srcElement[3].value.length > 25) {
                showToast("Alerta", "A senha deve ter entre 8 e 25 caracteres")
                return
            }
            if (event.srcElement[4].value == false) {
                showToast("Alerta", "Selecione o estado")
                return
            }
            if (event.srcElement[5].value == false) {
                showToast("Alerta", "Preencha a cidade")
                return
            }

            const formData = new FormData(event.target)

            formDataGlobal = formData

            showModal()
            verificationCode = await generateCode(verificationCode, event.srcElement[2].value)
        })

        async function login(formData) {
            const login = await fetch("../Action/user/register.php", {
                method: "POST",
                body: formData
            })
            const loginResult = await login.text()
            if (loginResult == "Sucesso") {
                window.location.href = './login.php?registerResult=Sucesso'
            }
            if (loginResult == "FalhaCadastroExistente") {
                showToast("Erro", "Email ou nome de usuario já cadastrado")
                return
            }
            if (loginResult == "FalhaPDO") {
                showToast("Erro", "Houve uma falha no cadastro. Tente novamente")
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
            if (inputCode === verificationCode && new Date().getTime() < limitDate.getTime()) {
                hideModal()

                const response = await fetch("../Action/user/register.php", {
                    method: "POST",
                    body: formDataGlobal
                })

                const result = await response.text()
                if (result === "Sucesso") {
                    window.location.href = './login.php?registerResult=Sucesso'
                } else if (result === "FalhaCadastroExistente") {
                    showToast("Erro", "Email ou nome de usuario já cadastrado")
                } else {
                    showToast("Erro", "Houve uma falha no cadastro. Tente novamente")
                }

            } else {
                showToast("Erro", "Código incorreto")
            }
        })
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <title>BioJapi</title>
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="stylesheet" href="../Css/components/toast.css">

</head>

<body>

    <!-- Container da página -->
    <div class="loginContainer">
        <!-- Imagem de fundo -->
        <div class="loginImg">
            <img src="../img/pages_usage/serra.jpg" alt="">
        </div>

        <!-- Espaço para o formulário de Login -->
        <div class="loginForm">
            <div class="btnVoltar">
                <a href="../index.php"><i class="fa-solid fa-arrow-left"></i> Voltar à pagina inicial</a>
            </div>
            <!-- Espaço para o logo e o botão de voltar -->
            <div class="loginPresentation">



                <div class="imgLogin">
                    <img src="../img/logo/bioJapi4.svg" alt="Logo BioJapi" class="logo">
                    <h1>BioJapi</h1>
                    <h3>Entre em sua conta</h3>
                </div>

            </div>

            <!-- Formulário de Login -->
            <form class="loginForm" method="post">

                <div class="input">
                    <label for="email">Email ou Nome de usuário</label>
                    <input type="text" name="email" id="email" placeholder="example@email.com">
                </div>

                <div class="input">
                    <label for="email">Senha</label>
                    <input type="password" name="password" id="password" placeholder="*******">
                </div>

                <button type="submit">Entrar</button>
                <div class="otherStuff">
                    <p class="loginOption">Não possui uma conta? <a href="./register.php" class="switchLogin">Registre-se</a></p>
                    <p class="loginOption">Esqueceu a senha? <a href="./redefinirSenha.php" class="switchLogin">Redefinir</a></p>
                </div>

            </form>

        </div>

    </div>
    <div class="toastBox"></div>


    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>

    <script>
        window.addEventListener('load', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('postResult') === 'FalhaLogin') {
                showToast("Erro", "Você deve estar logado para publicar")
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (urlParams.get('registerResult') === 'Sucesso') {
                showToast("Sucesso", "Registrado com sucesso")
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (urlParams.get('passResult') === 'Sucesso') {
                showToast("Sucesso", "Senha alterada com sucesso")
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (urlParams.get('logoutResult') === 'ErroLogin') {
                showToast("Erro", "Você não está logado")
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (urlParams.get('editarPerfilResult') === 'FalhaLogin') {
                showToast("Erro", "Você deve estar logado para editar o perfil")
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        })

        const form = document.querySelector(".loginForm")
        form.addEventListener('submit', (event) => {
            event.preventDefault()
            if (event.srcElement[0].value == false) {
                showToast("Alerta", "Insira o email")
                return;
            }
            if (event.srcElement[1].value == false) {
                showToast("Alerta", "Insira a senha")
                return;
            }

            const formData = new FormData()
            formData.append("email", event.srcElement[0].value)
            formData.append("password", event.srcElement[1].value)
            login(formData)

        })

        async function login(formData) {
            const login = await fetch("../Action/user/login.php", {
                method: "POST",
                body: formData
            })
            const loginResult = await login.text()
            if (loginResult == "Sucesso") {
                window.location.href = '../index.php?loginResult=Sucesso'
            }
            if (loginResult == "FalhaLogin") {
                showToast("Erro", "Email ou senha incorreto")
                return;
            }

        }
    </script>
</body>

</html>
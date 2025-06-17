<?php
require "../Connection/connDB.php";
require "../Action/fetchStuff.php";
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../Pages/login.php?editarPerfilResult=FalhaLogin");
    exit();
}

$response = fetchPostsUser($conn, $_SESSION['usuario']->nome_usuario);
if ($_SESSION['usuario']->foto_usuario != 'default.png') {
    $nomeFotoUsuario = explode("@", $_SESSION['usuario']->foto_usuario)[0] . ".";
    $extensaoFoto = explode(".", $_SESSION['usuario']->foto_usuario);
    $nomeFotoUsuario .= end($extensaoFoto);
} else {
    $nomeFotoUsuario = 'default.png';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição Biografia</title>
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <link rel="stylesheet" href="../Css/editPerfil.css">
    <link rel="stylesheet" href="../Css/components/toast.css">
</head>

<body>

    <div class="content">
        <form enctype="multipart/form-data" class="editForm">
            <div class="imgInput">
                <img src="../img/fotos_usuario/<?php echo $_SESSION['usuario']->foto_usuario ?>" alt="" class="userImg">
                <div class="input">
                    <label for="imagem" class="inputImagem">Insira um arquivo</label>
                    <input type="file" name="imagem" id="imagem" class="imagem" accept=".png, .jpg, .jpeg" />
                    <p class="nomeArq">Arquivo selecionado: </br><?php echo $nomeFotoUsuario ?></p>
                </div>

            </div>
            <div class="inputs">
                <div class="Username">
                    <label for="username">Nome</label>
                    <input type="text" name="username" id="username" placeholder="<?php echo $_SESSION['usuario']->nome ?>">
                    <p class="nomepadrao" style="display: none;"><?php echo $_SESSION['usuario']->nome ?></p>
                </div>

                <div class="Usertag">
                    <label for="username">Nome de usuário</label>
                    <input type="text" name="username" id="username" placeholder="<?php echo str_replace("@", "", $_SESSION['usuario']->nome_usuario) ?>">
                </div>

                <div class="email">
                    <label for="user_email">Email</label>
                    <input type="email" name="user_email" id="user_email" placeholder="<?php echo $_SESSION['usuario']->email ?>">
                </div>
                <div class="bio">
                    <p>Biografia</p>
                    <textarea type="text" name="" id="user_bio" placeholder="<?php echo $_SESSION['usuario']->bio_usuario ?>"></textarea>
                </div>
            </div>



            <div class="btns">
                <a href="./perfil.php?usuario=<?php echo $_SESSION['usuario']->nome_usuario ?>">
                    <p>Cancelar</p>
                </a>
                <button type="submit">Aplicar mudanças</button>
            </div>

        </form>
    </div>

    <div class="toastBox"></div>

    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>
    <script>
        let imgInput = document.querySelector(".imagem")
        let img = document.querySelector(".userImg")
        imgInput.addEventListener("change", () => {
            const file = imgInput.files[0]
            const pArquivo = document.querySelector(".nomeArq")
            if (file) {
                const reader = new FileReader()
                reader.onload = function(e) {
                    const fileURL = e.target.result

                    if (file.type.startsWith('image/')) {
                        img.src = fileURL
                    }

                }
                reader.readAsDataURL(file)
                pArquivo.innerHTML = `Arquivo selecionado: </br> ${file.name}`
            } else {
                img.src = "../img/fotos_usuario/default.jpg"
                pArquivo.innerHTML = `Arquivo selecionado: \n Nenhum`
            }
        })

        const form = document.querySelector(".editForm")
        form.addEventListener('submit', (event) => {
            event.preventDefault()
            const formData = new FormData()
            if (event.srcElement[0].files[0] == undefined && event.srcElement[1].value == false && event.srcElement[2].value == false && event.srcElement[3].value == false && event.srcElement[4].value == false) {
                showToast("Alerta", "Ao menos um dos campos deve ser alterado")
                return
            }
            if (event.srcElement[0].files[0] != undefined) {
                formData.append("imagem", event.srcElement[0].files[0])
            }
            if (event.srcElement[1].value != false) {
                formData.append("nome", event.srcElement[1].value)
            }
            if (event.srcElement[2].value != false) {
                if (event.srcElement[2].value.length < 3) {
                    showToast("Alerta", "O nome de usuário deve ter pelo menos 3 caracteres")
                    return
                }
                formData.append("nome_usuario", event.srcElement[2].value)
            }
            if (event.srcElement[3].value != false) {
                formData.append("email", event.srcElement[3].value)
            }
            if (event.srcElement[4].value != false) {
                formData.append("bio", event.srcElement[4].value)
            }
            edit(formData)

        })

        async function edit(formData) {
            const editInfo = await fetch("../Action/user/editInfo.php", {
                method: "POST",
                body: formData
            })
            const editResult = await editInfo.json()
            if (editResult.status == "Sucesso") {
                window.location.href = `../Pages/perfil.php?usuario=${editResult.usuario}&editResult=Sucesso`
            }
            if (editResult.status == "FalhaCadastroExistente") {
                showToast("Erro", "Email ou nome de usuário já registrado")
            }
            if (editResult.status == "FalhaExtensao") {
                showToast("Erro", "Tipo de imagem não suportado")
            }
            if (editResult.status == "FalhaAlteracao") {
                showToast("Alerta", "Nenhum dado foi alterado")
            }
            if (editResult.status == "FalhaIMG") {
                showToast("Erro", "Houve um erro ao alterar a imagem. Tente novamente")
            }
            if (editResult.status == "FalhaPDO") {
                showToast("Erro", "Houve um problema ao alterar os dados. Tente novamente mais tarde")
            }
        }


        window.addEventListener('load', function() {

            const urlParams = new URLSearchParams(window.location.search);
            checkToast(urlParams)
        });

        function checkToast(param) {
            if (param.get('postResult') === 'Sucesso') {
                showToast("Sucesso", "Postagem bem sucedida")
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (param.get('postResult') === 'Error') {
                showToast("Erro", "Falha no salvamento")
                window.history.replaceState({}, document.title, window.location.pathname);
            }
            if (param.get('loginResult') === 'Sucesso') {
                showToast("Sucesso", "Login bem sucedido")
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }
    </script>
</body>

</html>
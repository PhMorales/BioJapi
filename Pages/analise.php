<?php
require "../Connection/connDB.php";
require "../Action/fetchStuff.php";
session_start();

$response = fetchPostsUser($conn, $_SESSION['usuario']->nome_usuario)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edição Biografia</title>
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <link rel="stylesheet" href="../Css/analise.css">
    <link rel="stylesheet" href="../Css/toast.css">


</head>

<body>

    <div class="header scrolled">
        <!-- Só leva pro começo da página mesmo -->
        <a href='../index.php' class="logoContainer">
            <img src="../img/logo/bioJapi4.svg" alt="Logo do Biojapi" class="logo">
            <img src="../img/pages_usage/BioJapi.svg" class="texto" alt="">
        </a>
        <!-- Barra de pesquisa -->
        <div class="searchbar">

            <form action="../Pages/search.php" method="get">
                <input type="text" name="busca" id="busca" placeholder="Procure por um usuário/post" />
                <button type="submit" title="Pesquisar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

        </div>
        <!-- Botões do header -->
        <div class="headerButtons">
            <div class="perfilBtn options">
                <?php

                if (isset($_SESSION['usuario'])) {

                    echo "<a class='loginBtn' onclick='showDropdown(event)'>
                <img class='fotoUsuario' src='../img/fotos_usuario/" . $_SESSION['usuario']->foto_usuario . "' alt='Imagem do usuario'>
            </a>
            <div class='dropdown'>
                    <a href='../Pages/newPost.php'><i class='fa-solid fa-plus'></i> Nova postagem</a>
                    <a href='../Pages/perfil.php?usuario=" . $_SESSION['usuario']->nome_usuario . "'><i class='fa-solid fa-user'></i> Ir à página de perfil</a>
                    <button class='logout' onclick=''><i class='fa-solid fa-right-from-bracket'></i> Logout</button>
                </div>";
                } else {
                    echo "<a href='../Pages/login.php' class='loginBtn'><i class='fa-solid fa-right-to-bracket'></i></a>";
                }

                ?>
            </div>
        </div>
        <div class="optionsContainer">
            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="options">
                    <button class="optionBtn" onclick="showDropdown(event)"><i class="fa-solid fa-bars"></i></button>
                    <div class="dropdown">
                        <a href="../Pages/newPost.php"><i class="fa-solid fa-plus"></i> Nova postagem</a>
                        <a href="../Pages/perfil.php"><i class="fa-solid fa-user"></i> Ir à página de perfil</a>
                        <button class='logout'><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </div>
                </div>
            <?php else: ?>
                <a href='../Pages/login.php' class='loginBtn'><i class='fa-solid fa-right-to-bracket'></i></a>
            <?php endif; ?>
        </div>

    </div>
    <div class="aux"></div>
    <div class="content">

        <!--Arrumar as CSS-->

        <div class="btnsDownload">
            <h2>Escolha o banco de dados para download</h2>
            <button type="button">BIODIVERSIDADE</button>
            <button type="button">ANIMAIS SILVESTRES ATROPELADOS</button>
        </div>

        <div class="Analise">
            <h2>Dados sobre Fauna e Flora</h2>
            <div class="SerieTemporal">
                <h3>Selecione a serie temporal</h3>
                <div class="tempoInicial">
                    <h4>Tempo Inicial</h4>
                    <input type="date" name="" id="">
                </div>
                <div class="tempoFinal">
                    <h4>Tempo Final</h4>
                    <input type="date" name="" id="">
                </div>

            </div>
            <div class="Especie">
                <h2>Espécie</h2>
                <div class="inputGenero">
                    <h4>Genero</h4>
                    <input list="frutas" name="fruta">
                    <datalist id="frutas">
                        <option value="Maçã">
                        <option value="Banana">
                        <option value="Laranja">
                    </datalist>
                </div>
                <div class="inputEspecie">
                    <h4>Especie</h4>
                    <input list="frutas" name="fruta">
                    <datalist id="frutas">
                        <option value="Maçã">
                        <option value="Banana">
                        <option value="Laranja">
                    </datalist>
                </div>
                <button type="button">Adicionar especie</button>
            </div>
            <button type="button">Gerar Grafico</button>
        </div>

        <div class="Graficos">
            <h2>Exibindo dados</h2>

        </div>
    </div>
    <div class="aux"></div>

    <script src="../Action/javascript/editPerfil.js"></script>
    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script>
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

        function showDropdown(event) {
            const button = event.currentTarget;
            const optionsDiv = button.closest(".options");
            const dropdown = optionsDiv.querySelector(".dropdown");
            dropdown.classList.toggle("show");
        }

        const logoutBtn = document.getElementById('logout')
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault()
            logout()
        })
        async function logout() {
            const logoutFetch = await fetch('../Action/user/logout.php')
            const result = await logoutFetch.text()
            if (result === "Sucesso") {
                window.location = "../index.php?logoutResult=Sucesso"
            } else if (result === "ErroLogin") {
                window.location = "../pages/login.php?logoutResult=ErroLogin"
            } else {
                showToast("Erro", "Erro ao realizar logout")
            }
        }
    </script>
</body>

</html>
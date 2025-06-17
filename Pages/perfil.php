<?php
require "../Connection/connDB.php";
require "../Action/fetchStuff.php";
if (!isset($_GET['usuario'])) {
    header('Location: ../index.php?userResult=naoEncontrado');
}
$response = fetchPostsUser($conn, $_GET['usuario']);
$usuario = fetchUser($conn, $_GET['usuario']);
if (!$usuario) {
    header('Location: ../index.php?userResult=naoEncontrado');
}
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioJapi - Perfil</title>
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <link rel="stylesheet" href="../Css/perfil.css">
    <link rel="stylesheet" href="../Css/components/toast.css">

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
    <div></div>
    <div class="content">
        <div class="sidebar">
            <div class="userInfo">
                <div class="userNameImg">
                    <img src="../img/fotos_usuario/<?php echo $usuario['foto_usuario'] ?>" alt="">
                    <div class="usernameTag">
                        <p class="username"><?php echo $usuario['nome'] ?></p>
                        <p class="username"><?php echo $usuario['nome_usuario'] ?></p>
                    </div>
                </div>

                <div class="userBio">
                    <p>Biografia:</p>
                    <p class="biografia"><?php echo $usuario['bio_usuario'] ?></p>
                    <?php if (isset($_SESSION['usuario'])):
                        if ($_SESSION['usuario']?->nome_usuario == $usuario['nome_usuario']): ?>
                            <a href="editPerfil.php">Editar informações pessoais</a>
                    <?php endif;
                    endif; ?>

                </div>
            </div>
        </div>
        <div class="posts">
            <?php if ($response->rowCount() == 0): ?>
                <div class="noPosts">
                    <p>Este usuário ainda não possui postagens.</p>
                </div>
            <?php endif; ?>
            <?php
            while ($row = $response->fetch(PDO::FETCH_OBJ)):

                if ($row->acidente == 1) continue;
            ?>
                <a href='../Pages/post.php?id=<?php echo $row->post_id ?>' class='postCard'>
                    <div class="postImg <?php echo (str_contains($row->imagem_nome, '.mp4') || str_contains($row->imagem_nome, '.webm')) ? "video" : "" ?>">
                        <?php
                        if (str_contains($row->imagem_nome, '.mp4') || str_contains($row->imagem_nome, '.webm')) {
                            echo "<video  class='videoPost " .  ($row->sensivel == 1 ? "sensivel'" : "") . "' preload='none' data-src='../img/fotos_post/" . $row->imagem_nome . "' alt='Imagem do post'></video>";
                        } else {
                            echo "<img src='../img/fotos_post/" . $row->imagem_nome . "' loading='lazy' alt='Imagem do post'" . ($row->sensivel == 1 ? "class=sensivel" : "") . ">";
                        }
                        ?>
                    </div>
                    <div class='card-content'>
                        <h2><?php echo $row->nome_cientifico ?></h2>

                        <div class="authorInfo">
                            <img src="../img/fotos_usuario/<?php echo $row->foto_usuario ?>" alt="">
                            <div class="authorName">
                                <p><?php echo $row->nome ?></p>
                            </div>
                            <p class="authorUsername"><?php echo $row->nome_usuario ?></p>
                        </div>

                        <p> <?php echo $row->legenda ?></p>
                        <p class='postTime'><?php echo date('d/m/Y H:i', strtotime($row->data_upload)) ?></p>
                        <div class="likeNcommentCount">
                            <div class="likeCount">
                                <i class="fa-solid fa-heart"></i>
                                <p><?php echo $row->likeCount ?></p>
                            </div>
                            <div class="commentCount">
                                <i class="fa-solid fa-comment"></i>
                                <p><?php echo $row->commentCount ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="toastBox"></div>
    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>
    <script>
        window.addEventListener('load', function() {

            const urlParams = new URLSearchParams(window.location.search);
            checkToast(urlParams)
        });

        function checkToast(param) {
            if (param.get('editResult') === 'Sucesso') {
                showToast("Sucesso", "Dados alterados.")
                param.delete('editResult');
                window.history.replaceState({}, document.title, window.location.pathname + `?${param.toString()}`);
            }
        }

        function showDropdown(event) {
            const button = event.currentTarget;
            const optionsDiv = button.closest(".options");
            const dropdown = optionsDiv.querySelector(".dropdown");
            dropdown.classList.toggle("show");
        }

        const logoutBtn = document.querySelectorAll('.logout')
        logoutBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault()
                logout()
            })
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
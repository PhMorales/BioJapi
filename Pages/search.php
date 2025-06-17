<?php
require "../Connection/connDB.php";
require "../Action/fetchStuff.php";
$busca = isset($_GET["busca"]) ? $_GET['busca'] : false;
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : false;
if ($busca == "" && !isset($categoria)) {
    header("Location: ../index.php");
} else {
    if ($categoria) {
        echo $categoria;
        $response = fetchPostsCategoria($conn, $categoria);
    } else {
        $response = fetchPostsBusca($conn, $busca);
    }
}
session_start();
if ($categoria) {
    $categoriaJson = file_get_contents("../Connection/categorias.json");
    $categorias = json_decode($categoriaJson, true);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <title>BioJapi</title>
    <link rel="stylesheet" href="../Css/search.css">
</head>

<body>
    <!-- Header -->
    <div class="header scrolled">
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
                    <button class='logout'><i class='fa-solid fa-right-from-bracket'></i> Logout</button>
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

    <!-- Espaço que só vai servir pra preencher o espaço abaixo do header -->
    <div></div>
    <?php if ($categoria) : ?>
        <div class="categoriaContainer">
            <div class="categoriaImg">
                <img src="../img/categorias/<?php echo $categorias[$categoria]['imagem'] ?>" alt="Imagem da categoria">
            </div>
            <div class="categoriaInfo">
                <div class="categoriaNomes">
                    <h1><?php echo $categorias[$categoria]['nome_popular'] ?></h1>
                    <h2><?php echo $categorias[$categoria]['nome_cientifico'] ?></h2>
                </div>
                <p class="descricao"><?php echo $categorias[$categoria]['descricao'] ?></p>
                <p class="info">Para identificar um <?php echo $categorias[$categoria]["nome_popular"] ?>, acesse <a href="<?php echo $categorias[$categoria]["pesquisa"] ?>"><?php echo $categorias[$categoria]["pesquisa"] ?></a> ou sites similares</p>
            </div>
        </div>
    <?php endif; ?>
    <!-- Posts -->
    <?php if ($busca) : ?>
        <h1>Resultados para "<?php echo htmlspecialchars($busca) ?>"</h1>
    <?php else : ?>
        <h1>Posts da categoria "<?php echo $categorias[$categoria]['nome_popular'] ?>"</h1>
    <?php endif; ?>
    <?php if ($response->rowCount() == 0) : ?>
        <p class="noPosts">Nenhum post encontrado</p>
    <?php endif; ?>
    <div class="posts">
        <!-- Php para mostrar os posts na tabela -->
        <?php
        while ($row = $response->fetch(PDO::FETCH_OBJ)):

            if ($row->acidente == 1) continue;
        ?>
            <a href='../Pages/post.php?id=<?php echo $row->post_id ?>' class='postCard'>
                <div class="postImg <?php echo (str_contains($row->imagem_nome, '.mp4') || str_contains($row->imagem_nome, '.webm')) ? "video" : "" ?>">
                    <?php
                    if (str_contains($row->imagem_nome, '.mp4') || str_contains($row->imagem_nome, '.webm')) {
                        echo "<video  class='videoPost " .  ($row->sensivel == 1 ? "sensivel'" : "") . "' preload='none' data-src='./img/fotos_post/" . $row->imagem_nome . "' alt='Imagem do post'></video>";
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
    <script>
        window.addEventListener('scroll', function() {
            // para carregar mais posts
            const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 100;
            if (nearBottom) {
                newFeedPosts()
            }
        })

        // Vídeos carregarem conforme a página scrolla para melhorar a otimização do site
        function lazyVideosHandler() {
            const lazyVideos = document.querySelectorAll('video[data-src]')

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const video = entry.target
                        video.src = video.dataset.src
                        video.load()
                        video.removeAttribute('data-src')
                        observer.unobserve(video)
                    }
                });
            }, {
                rootMargin: '0px 0px 50px 0px', // carrega um pouco antes de entrar totalmente
                threshold: 0.25 // 25% visível já carrega
            });

            lazyVideos.forEach(video => observer.observe(video))
        }

        const limit = 4
        let offset = limit + 4
        const headerParams = new URLSearchParams(window.location.search)
        const busca = headerParams.get('busca')
        let loading = false
        async function newFeedPosts() {
            if (loading) return;
            loading = true
            var postsFetch = await fetch(`../Action/posts/fetchPosts.php?limit=${limit}&offset=${offset}&busca=${busca}`)
            var posts = await postsFetch.json()
            posts.forEach(post => {
                let postContainer = document.querySelector(".posts")
                postContainer.appendChild(gerarPost(post))
            })
            lazyVideosHandler()
            offset += limit
            loading = false
        }

        function gerarPost(post) {
            const a = document.createElement('a')
            a.href = `./Pages/post.php?id=${post.post_id}`
            a.classList.add('postCard')

            // Container da imagem/vídeo
            const postImg = document.createElement('div')
            postImg.classList.add('postImg')

            if (post.imagem_nome.includes('.mp4') || post.imagem_nome.includes('.webm')) {
                const video = document.createElement('video')
                video.controls = true
                video.classList.add('videoPost')
                video.setAttribute('preload', 'none')
                video.setAttribute('data-src', `../img/fotos_post/${post.imagem_nome}`)
                video.setAttribute('alt', 'Imagem do post')
                postImg.appendChild(video)
            } else {
                const img = document.createElement('img')
                img.src = `../img/fotos_post/${post.imagem_nome}`
                img.alt = 'Imagem do post'
                img.loading = 'lazy'
                postImg.appendChild(img)
            }

            a.appendChild(postImg)

            // Conteúdo do post
            const cardContent = document.createElement('div')
            cardContent.classList.add('card-content')

            const h2 = document.createElement('h2')
            h2.textContent = post.nome_cientifico

            const authorInfo = document.createElement('div');
            authorInfo.className = 'authorInfo';

            const authorImg = document.createElement('img');
            authorImg.src = `./img/fotos_usuario/${post.foto_usuario}`;
            authorImg.alt = '';
            const authorNameDiv = document.createElement('div');
            authorNameDiv.className = 'authorName';

            const nameP = document.createElement('p');
            nameP.textContent = post.nome;
            authorNameDiv.appendChild(nameP);

            const usernameP = document.createElement('p');
            usernameP.className = 'authorUsername';
            usernameP.textContent = post.nome_usuario;

            authorInfo.appendChild(authorImg);
            authorInfo.appendChild(authorNameDiv);
            authorInfo.appendChild(usernameP);

            const pLegenda = document.createElement('p')
            pLegenda.textContent = post.legenda

            const pData = document.createElement('p')
            pData.classList.add("postTime")
            const dataFormatadaConfig = {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
            }
            const dataFormatada = new Date(post.data_upload).toLocaleString(undefined, dataFormatadaConfig).replace(',', '')
            pData.textContent = `${dataFormatada}`


            cardContent.appendChild(h2)
            cardContent.appendChild(authorInfo);
            cardContent.appendChild(pLegenda)
            cardContent.appendChild(pData)
            cardContent.appendChild(criarLikeECommentCount(post))
            a.appendChild(cardContent)

            return a
        }

        function criarLikeECommentCount(post) {
            const container = document.createElement('div');
            container.className = 'likeNcommentCount';

            const likeDiv = document.createElement('div');
            likeDiv.className = 'likeCount';

            const likeIcon = document.createElement('i');
            likeIcon.className = 'fa-solid fa-heart';

            const likeText = document.createElement('p');
            likeText.textContent = post.likeCount ?? 0;

            likeDiv.appendChild(likeIcon);
            likeDiv.appendChild(likeText);

            const commentDiv = document.createElement('div');
            commentDiv.className = 'commentCount';

            const commentIcon = document.createElement('i');
            commentIcon.className = 'fa-solid fa-comment';

            const commentText = document.createElement('p');
            commentText.textContent = post.commentCount ?? 0;

            commentDiv.appendChild(commentIcon);
            commentDiv.appendChild(commentText);

            container.appendChild(likeDiv);
            container.appendChild(commentDiv);

            return container;
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
    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
require __DIR__ . "/Connection/connDB.php";
require  __DIR__ . "/Action/fetchStuff.php";


$response = fetchPosts($conn, 1);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/logo/bioJapi4.svg" type="image/x-icon">
    <title>BioJapi</title>
    <link rel="stylesheet" href="./Css/home.css">
    <link rel="stylesheet" href="./Css/components/toast.css">
</head>

<body>

    <!-- Header -->
    <div class="header">
        <!-- Só leva pro começo da página mesmo -->
        <a href='#' class="logoContainer">
            <img src="./img/logo/bioJapi4.svg" alt="Logo do Biojapi" class="logo">
            <img src="./img/pages_usage/BioJapi.svg" class="texto" alt="">
        </a>
        <!-- Barra de pesquisa -->
        <div class="searchbar">

            <form action="./Pages/search.php" method="get">
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
                <img class='fotoUsuario' src='img/fotos_usuario/" . $_SESSION['usuario']->foto_usuario . "' alt='Imagem do usuario'>
            </a>
            <div class='dropdown'>
                    <a href='./Pages/newPost.php'><i class='fa-solid fa-plus'></i> Nova postagem</a>
                    <a href='./Pages/perfil.php?usuario=" . $_SESSION['usuario']->nome_usuario . "'><i class='fa-solid fa-user'></i> Ir à página de perfil</a>
                    <button class='logout' onclick=''><i class='fa-solid fa-right-from-bracket'></i> Logout</button>
                </div>";
                } else {
                    echo "<a href='./Pages/login.php' class='loginBtn'><i class='fa-solid fa-right-to-bracket'></i></a>";
                }

                ?>
            </div>
        </div>
        <div class="optionsContainer">
            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="options">
                    <button class="optionBtn" onclick="showDropdown(event)"><i class="fa-solid fa-bars"></i></button>
                    <div class="dropdown">
                        <a href="./Pages/newPost.php"><i class="fa-solid fa-plus"></i> Nova postagem</a>
                        <a href="./Pages/perfil.php"><i class="fa-solid fa-user"></i> Ir à página de perfil</a>
                        <button class='logout'><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </div>
                </div>
            <?php else: ?>
                <a href='./Pages/login.php' class='loginBtn'><i class='fa-solid fa-right-to-bracket'></i></a>
            <?php endif; ?>
        </div>

    </div>

    <!-- Futuro Hero -->
    <div class="hero">
        <div class="arrow">
            <i class="fa-solid fa-arrow-down"></i>
        </div>
        <div class="presentation">
            <div class="logo">
                <img src="./img/logo/bioJapi4.svg" class="heroLogoImg" alt="Logo do Biojapi">
                <img src="./img/pages_usage/BioJapi.svg" class="heroLogoTxt" alt="">
            </div>
            <div class="presentationContent">
                <p>Promovendo a <b>Ciência Cidadã</b> e a <b>Preservação Ambiental</b> para todos</p>
            </div>
        </div>

        <div class="heroContent">
            <div class=" searchbar">
                <p>Você pode começar com uma <b>pesquisa</b></p>

                <form action="./Pages/search.php" method="get">
                    <input type="text" name="busca" id="busca" placeholder="Procure por um usuário/post" />
                    <button type="submit" title="Pesquisar">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
            <div class="heroContentBtns">
                <?php
                if (!isset($_SESSION['usuario'])) {

                    echo "<p>ou pode <a href='./Pages/login.php' class='heroLoginBtn'>Entrar na sua conta</a></p>";
                } else {
                    echo "<p>ou <a href='./Pages/newPost.php' class='heroLoginBtn'>Fazer uma nova postagem</a></p>";
                }

                ?>
            </div>
        </div>
    </div>
    <div class="carrosselContainer">
        <h1>Pesquisar por categoria</h1>
        <div class="carrossel">

            <div class="mySlides fade">
                <div class="numbertext">1 / 10</div>
                <a href="Pages/search.php?categoria=mamífero"><img src="img/slider/Lobo_Guará_andando.jpg" class='slideImg'></a>
                <div class="text">MAMÍFEROS</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 10</div>
                <a href="Pages/search.php?categoria=anfíbio"><img src="img/slider/sapo cururu.jpg" class='slideImg'></a>
                <div class="text">ANFÍBIOS</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 10</div>
                <a href="Pages/search.php?categoria=ave"><img src="img/slider/seriema2.jpg" class='slideImg'></a>
                <div class="text">AVES</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">4 / 10</div>
                <a href="Pages/search.php?categoria=réptil"><img src="img/slider/jararca.jpg" class='slideImg'></a>
                <div class="text">REPTEIS</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">5 / 10</div>
                <a href="Pages/search.php?categoria=aracnídeo"><img src="img/slider/phoneutria fera.jpg" class='slideImg'></a>
                <div class="text">ARACNÍDEOS</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">6 / 10</div>
                <a href="Pages/search.php?categoria=inseto"><img src="img/slider/Cerambycidae_-_Dorcacerus_barbatus.jpg" class='slideImg'></a>
                <div class="text">INSETOS</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">7 / 10</div>
                <a href="Pages/search.php?categoria=árvore"><img src="img/slider/Pau-brasil_mococa_sp.jpg" class='slideImg'></a>
                <div class="text">GRANDES ÁRVORES</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">8 / 10</div>
                <a href="Pages/search.php?categoria=arbusto"><img src="img/slider/Araca-amarelo.jpg" class='slideImg'></a>
                <div class="text">ARBUSTOS</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">9 / 10</div>
                <a href="Pages/search.php?categoria=rasteira"><img src="img/slider/musgo.jpg" class='slideImg'></a>
                <div class="text">PLANTAS RASTEIRAS</div>
            </div>
            <div class="mySlides fade">
                <div class="numbertext">10 / 10</div>
                <a href="Pages/search.php?categoria=cogumelo"><img src="img/slider/cogumelo.jpg" class='slideImg'></a>
                <div class="text">COGUMELOS</div>
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <div class='dotContainer' style="text-align:center">
        </div>
    </div>



    <div class="posts">
        <!-- Php para mostrar os posts na tabela -->
        <?php
        while ($row = $response->fetch(PDO::FETCH_OBJ)):

            if ($row->acidente == 1) continue;
        ?>
            <a href='./Pages/post.php?id=<?php echo $row->post_id ?>' class='postCard'>
                <div class="postImg <?php echo (str_contains($row->imagem_nome, '.mp4') || str_contains($row->imagem_nome, '.webm')) ? "video" : "" ?>">
                    <?php
                    if (str_contains($row->imagem_nome, '.mp4') || str_contains($row->imagem_nome, '.webm')) {
                        echo "<video  class='videoPost " .  ($row->sensivel == 1 ? "sensivel'" : "") . "' preload='none' data-src='./img/fotos_post/" . $row->imagem_nome . "' alt='Imagem do post'></video>";
                    } else {
                        echo "<img src='./img/fotos_post/" . $row->imagem_nome . "' loading='lazy' alt='Imagem do post'" . ($row->sensivel == 1 ? "class=sensivel" : "") . ">";
                    }
                    ?>
                </div>
                <div class='card-content'>
                    <h2><?php echo $row->nome_cientifico ?></h2>

                    <div class="authorInfo">
                        <img src="./img/fotos_usuario/<?php echo $row->foto_usuario ?>" alt="">
                        <div class="authorName">
                            <p><?php echo $row->nome ?></p>
                        </div>
                        <p class="authorUsername"><?php echo $row->nome_usuario ?></p>
                    </div>

                    <p class='legenda'> <?php echo $row->legenda ?></p>
                    <div class="timeNstuff">

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
                </div>
            </a>
        <?php endwhile; ?>

    </div>
    <div class="toastBox"></div>
    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="./scripts/toast.js"></script>

    <script>
        window.addEventListener('load', function() {
            document.body.style.opacity = '1'
            const urlParams = new URLSearchParams(window.location.search);
            checkToast(urlParams)
        });

        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header')
            if (window.scrollY > window.innerHeight * 0.5) {
                header.classList.add('scrolled')
            } else {
                header.classList.remove('scrolled')
            }
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
        let offset = limit
        let loading = false
        async function newFeedPosts() {
            if (loading) return;
            loading = true
            var postsFetch = await fetch(`./Action/posts/fetchPosts.php?limit=${limit}&offset=${offset}`)
            var posts = await postsFetch.json()
            posts.filter(post => post.acidente != 1).forEach(post => {
                let postContainer = document.querySelector(".posts")
                postContainer.appendChild(gerarPost(post))
            })
            lazyVideosHandler()
            offset += limit
            loading = false
        }

        function gerarPost(post) {
            if (post.acidente == 1) {
                return;
            }
            const a = document.createElement('a')
            a.href = `./Pages/post.php?id=${post.post_id}`
            a.classList.add('postCard')

            // Container da imagem/vídeo
            const postImg = document.createElement('div')
            postImg.classList.add('postImg')

            if (post.imagem_nome.includes('.mp4') || post.imagem_nome.includes('.webm')) {
                postImg.classList.add("video")
                const video = document.createElement('video')
                video.controls = false
                video.classList.add('videoPost')
                if (post.sensivel == 1) {
                    video.classList.add('sensivel')
                }
                video.setAttribute('preload', 'none')
                video.setAttribute('data-src', `../img/fotos_post/${post.imagem_nome}`)
                video.setAttribute('alt', 'Imagem do post')
                postImg.appendChild(video)
            } else {
                const img = document.createElement('img')
                img.src = `../img/fotos_post/${post.imagem_nome}`
                img.alt = 'Imagem do post'
                img.loading = 'lazy'
                if (post.sensivel == 1) {
                    img.classList.add('sensivel')
                }
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
            if (param.get('deletePostResult') == 'Sucesso') {
                showToast("Sucesso", "Post Excluído")
            }
            if (param.get('userResult') == 'naoEncontrado') {
                showToast("Erro", "Usuário não encontrado")
                window.history.replaceState({}, document.title, window.location.pathname);
            }
            if (param.get('logoutResult') === 'Sucesso') {
                showToast("Sucesso", "Logout realizado com sucesso")
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }

        function showDropdown(event) {
            const button = event.currentTarget;
            const optionsDiv = button.closest(".options");
            const dropdown = optionsDiv.querySelector(".dropdown");
            dropdown.classList.toggle("show");
        }

        let slideIndex = 0

        function getSlidesPerView() {
            const width = window.innerWidth
            if (width >= 1024) return 4
            if (width >= 768) return 3
            if (width >= 601) return 2
            return 1
        }

        function plusSlides(n) {
            const slidesPerView = getSlidesPerView();
            showSlides(slideIndex += n * slidesPerView);
        }

        function currentSlide(n) {
            const slidesPerView = getSlidesPerView();
            slideIndex = (n - 1) * slidesPerView;
            showSlides(slideIndex);
        }

        function defineDots() {
            const slides = document.getElementsByClassName("mySlides")
            const totalSlides = slides.length;
            const slidesPerView = getSlidesPerView();
            const dots = document.querySelector(".dotContainer")
            while (dots.firstChild) {
                dots.firstChild.remove()
            }
            for (i = 0; i < Math.ceil(totalSlides / slidesPerView); i++) {
                const dot = document.createElement('span')
                dot.classList.add("dot")
                dot.setAttribute('onclick', `currentSlide(${i+1})`)
                dots.appendChild(dot)

            }
        }

        function showSlides(startIndex) {
            defineDots()
            const slides = document.getElementsByClassName("mySlides")
            const dots = document.getElementsByClassName("dot")
            const totalSlides = slides.length;
            const slidesPerView = getSlidesPerView();

            if (startIndex >= totalSlides) {
                slideIndex = 0;
            } else if (startIndex < 0) {
                slideIndex = totalSlides - 1 - (totalSlides - 1) % slidesPerView;
                if (slideIndex < 0) slideIndex = 0

            }

            for (let i = 0; i < totalSlides; i++) {
                slides[i].style.display = "none"
            }

            for (let i = 0; i < slidesPerView; i++) {
                if (slideIndex + i < totalSlides) {
                    slides[slideIndex + i].style.display = "block"
                }
            }

            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "")
            }
            const activeDot = Math.floor(slideIndex / slidesPerView)
            if (dots[activeDot]) {
                dots[activeDot].className += " active"
            }

        }

        const logoutBtn = document.querySelectorAll('.logout')
        logoutBtn.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault()
                logout()
            })
        })

        async function logout() {
            const logoutFetch = await fetch('./Action/user/logout.php')
            const result = await logoutFetch.text()
            if (result === "Sucesso") {
                window.location = "./index.php?logoutResult=Sucesso"
            } else if (result === "ErroLogin") {
                window.location = "./pages/login.php?logoutResult=ErroLogin"
            } else {
                showToast("Erro", "Erro ao realizar logout")
            }
        }

        window.addEventListener("resize", () => showSlides(slideIndex))
        window.addEventListener("load", () => showSlides(slideIndex))
    </script>

</body>

</html>
<?php
require "../Connection/connDB.php";
require "../Action/fetchStuff.php";

if (!$_GET['id']) {
    header('Location: /');
    exit;
}

$id = $_GET['id'];
$post = fetchPost($conn, $id);

if (!$post) {
    header('Location: /');
    exit;
}

$comments = fetchComments($conn, $id);
$likeCount = fetchLikes($conn, $id);
$likeCount = $likeCount ? $likeCount['likes'] : 0;

session_start();
if (isset($_SESSION['usuario'])) {
    $username = $_SESSION['usuario']->nome_usuario;
} else {
    $username = null;
}
$liked = fetchLiked($conn, $id, $username);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioJapi</title>
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <link rel="stylesheet" href="../Css/post.css">
    <link rel="stylesheet" href="../Css/components/toast.css">
    <link rel="stylesheet" href="../Css/components/dropdown.css">
</head>

<body>

    <div class="postContainer">
        <div class="post">

            <!-- Imagem -->
            <div class="postImg">
                <?php
                if (str_contains($post['imagem_nome'], '.mp4') || str_contains($post['imagem_nome'], '.webm')) {
                    echo "<video controls src='../img/fotos_post/" . $post['imagem_nome'] . "' alt='Imagem do post'></video>";
                } else {
                    echo "<img src='../img/fotos_post/" . $post['imagem_nome'] . "' alt='Imagem do post'>";
                }
                ?>
            </div>

            <!-- Conteúdo do post -->
            <div class="postContent">
                <a class="btnVoltar" onclick=retornar()>
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <?php
                if (isset($_SESSION['usuario']) && ($post['nome_usuario'] == $_SESSION['usuario']->nome_usuario)): ?>
                    <div class="optionsContainer">
                        <div class="options">
                            <button class="optionBtn" onclick="showDropdown(event)"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <div class="dropdown">
                                <button id="delete" onclick="deletePost('<?php echo $post['post_id'] ?>')"><i class="fa-solid fa-trash"></i> Excluir postagem</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Informações do autor e da espécie -->
                <div class="comentariosInfo">

                    <!-- Título e Localização -->
                    <div class="infoTitulo">
                        <div class="especie">
                            <p class="nomePopular"><?php echo isset($post['nome_popular']) ? $post['nome_popular'] : "Sem nome popular" ?></p>
                            <p class="nomeCientifico"><?php echo $post['nome_cientifico'] ?></p>
                        </div>
                        <div class="fotoInfo">
                            <p class="postLocation"><i class="fa-solid fa-location-dot"></i> <?php echo $post['localizacao'] ?></p>
                            <p class="imgDate"><i class="fa-solid fa-calendar-days"></i> <?php echo date('d/m/Y', strtotime($post['data_imagem'])) ?></p>
                        </div>
                    </div>

                    <!-- Autor e legenda -->
                    <div class="infoAuthor">


                        <div class="postFormatted">

                            <!-- Cabeçalho do autor -->
                            <a href="./perfil.php?usuario=<?php echo $post['nome_usuario'] ?>">
                                <div class="authorHeader">
                                    <div class="authorData">
                                        <img src="../img/fotos_usuario/<?php echo $post['foto_usuario'] ?>" alt="">
                                        <div class="authorName">
                                            <p><?php echo $post['nome'] ?></p>
                                        </div>
                                        <p class="authorUsername"><?php echo $post['nome_usuario'] ?></p>
                                    </div>
                                </div>
                            </a>

                            <!-- Legenda -->
                            <div class="authorComment">
                                <div class="commentText">
                                    <p><?php echo $post['legenda']  ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Botão de like -->
                        <div class="likeBtn">
                            <?php if ($liked): ?>
                                <a onclick="unlikePost()" class="btnLike">
                                    <i class="fa-solid fa-heart"></i>
                                </a>
                            <?php else: ?>
                                <a onclick="likePost()" class="btnLike">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            <?php endif; ?>
                            <p class="likeCount"><?php echo $likeCount ?></p>
                        </div>
                    </div>
                    <p class="postDate"><?php echo date('d/m/Y H:i', strtotime($post['data_upload'])) ?></p>
                </div>
                <div>

                </div>

                <!-- Comentários -->
                <div class="comentariosContent">
                    <div class="comentarios">
                        <?php while ($row = $comments->fetch(PDO::FETCH_OBJ)): ?>
                            <div class='comentario'>
                                <div class="comentarioAutor">
                                    <a href="./perfil.php?usuario=<?php echo $row->nome_usuario; ?>">
                                        <img src="../img/fotos_usuario/<?php echo $row->foto_usuario ?>" alt="">
                                        <p><?php echo $row->nome_usuario ?></p>
                                    </a>
                                    <?php
                                    if (isset($_SESSION['usuario']) && ($row->nome_usuario == $_SESSION['usuario']->nome_usuario)): ?>
                                        <div class="optionsContainer">
                                            <div class="options">
                                                <button class="optionBtn" onclick="showDropdown(event)"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                                <div class="dropdown">
                                                    <button
                                                        class="editBtn"
                                                        data-id="<?php echo htmlspecialchars($row->id_comentario, ENT_QUOTES) ?>"
                                                        data-comment="<?php echo htmlspecialchars($row->comentario, ENT_QUOTES) ?>">
                                                        <i class="fa-solid fa-pencil"></i> Editar comentário
                                                    </button>
                                                    <button id="delete" onclick="deleteComment('<?php echo $row->id_comentario ?>')"><i class="fa-solid fa-trash"></i> Excluir comentário</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="commentText">
                                    <p><?php echo $row->comentario ?></p>
                                </div>
                                <p class='commentDate'><?php echo date('d/m/Y H:i', strtotime($row->data_comentario)) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Formulário de comentário -->
                <form class="formComentarios" method="post">
                    <div class="editInfo">Editando comentário. Clique no botão para enviar. Clique fora para cancelar</div>
                    <div class="formulario">
                        <input type="hidden" name="post_id" id="comment_id" value="<?php echo $id ?>">
                        <textarea name="comentario" id="comentarioTXT" cols="30" rows="3" maxlength="255" placeholder="Adicione um comentário..."></textarea>
                        <button type="submit">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="toastBox"></div>

    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>
    <script>
        let editState = false
        const formComentarios = document.querySelector(".formComentarios")
        formComentarios.addEventListener('submit', (event) => {
            const headerParams = new URLSearchParams(window.location.search)
            event.preventDefault()
            if (event.srcElement[1].value == false) {
                showToast("Alerta", "Insira um comentário")
                return;
            }
            let id = ""
            if (!editState) {
                id = headerParams.get('id')
            } else {
                id = comment_id.value
            }
            const formData = new FormData()
            formData.append("id", id)
            formData.append("comentario", event.srcElement[1].value)
            if (!editState) {
                postarComentario(formData)
            } else {
                editarComentario(formData)
            }

        })

        document.querySelectorAll(".editBtn").forEach(btn => {
            btn.addEventListener("click", () => {
                const id = btn.dataset.id;
                const comentario = btn.dataset.comment;
                editComment(id, comentario);
            });
        });

        const headerParams = new URLSearchParams(window.location.search)

        checkToast(headerParams)

        const id = headerParams.get('id')
        async function postarComentario(formData) {
            const postComment = await fetch("../Action/comments/addComment.php", {
                method: "POST",
                body: formData
            })
            const commentResult = await postComment.text()
            if (commentResult == "Sucesso") {
                window.location.href = window.location.pathname + `?id=${id}&commentResult=Sucesso`
            }
            if (commentResult == "FalhaID") {
                showToast("Erro", "Ocorreu um erro. Tente novamente.")
            }
            if (commentResult == "FalhaLogin") {
                window.location.href = '../Pages/login.php?commentResult=FalhaLogin'
            }
            if (commentResult == "FalhaPDO") {
                showToast("Erro", "Houve uma falha no envio. Tente novamente")

            }
        }

        async function editarComentario(formData) {
            const editComment = await fetch("../Action/comments/editComment.php", {
                method: "POST",
                body: formData
            })
            const commentResult = await editComment.text()
            if (commentResult == "Sucesso") {
                window.location.href = window.location.pathname + `?id=${id}&editCommentResult=Sucesso`
            }
            if (commentResult == "FalhaComentario") {
                showToast("Alerta", "O texto alterado é idêntico ao original.")
            }
            if (commentResult == "FalhaPDO") {
                showToast("Erro", "Houve uma falha no envio. Tente novamente")

            }
        }


        let loading = false
        async function likePost() {
            if (loading) return;
            loading = true
            var liked = await fetch(`../Action/likes/likePost.php?id=${id}`)
            if (liked) {
                window.location.reload()
            }
        }

        async function unlikePost() {
            if (loading) return;
            loading = true
            var unliked = await fetch(`../Action/likes/unlikePost.php?id=${id}`)
            if (unliked) {
                window.location.reload()
            }
        }

        function retornar() {
            if (document.referrer !== '') {
                if (document.referrer == window.location.href) {
                    window.location.href = "/"
                    return;
                }
                window.history.back()

            } else {
                window.location.href = '/'
            }

        }

        function checkToast(param) {
            if (param.get('commentResult') === 'Sucesso') {
                showToast("Sucesso", "Postagem bem sucedida.")
                param.delete('commentResult')
                window.history.replaceState({}, document.title, window.location.pathname + `?${param.toString()}`);
            }
            if (param.get('editCommentResult') === 'Sucesso') {
                showToast("Sucesso", "Edição bem sucedida.")
                param.delete('editCommentResult')
                window.history.replaceState({}, document.title, window.location.pathname + `?${param.toString()}`);
            }
            if (param.get('deleteCommentResult') === 'Sucesso') {
                showToast("Sucesso", "Exclusão bem sucedida.")
                param.delete('deleteCommentResult')
                window.history.replaceState({}, document.title, window.location.pathname + `?${param.toString()}`);
            }

        }

        function showDropdown(event) {
            const button = event.currentTarget;
            const optionsDiv = button.closest(".options");
            const dropdown = optionsDiv.querySelector(".dropdown");
            dropdown.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!(event.target.matches('.optionBtn') || event.target.matches('.fa-ellipsis-vertical'))) {
                var dropdowns = document.getElementsByClassName("dropdown");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
            if (!(event.target.closest('.formComentarios') || event.target.matches(".editBtn") || event.target.closest('.toast')) && editState) {
                editState = false
                comentarioTXT.value = ''
                editInfo = document.querySelector('.editInfo')
                editInfo.classList.remove('editing')


            }
        }

        function editComment(id, comentario) {
            editState = true
            editInfo = document.querySelector('.editInfo')
            editInfo.classList.add('editing')
            comment_id.value = id
            comentarioTXT.value = comentario
            comentarioTXT.scrollIntoView()
        }

        async function deleteComment(id) {
            let formData = new FormData()
            formData.append("id", id)
            const deleteComment = await fetch("../Action/comments/deleteComment.php", {
                method: "POST",
                body: formData
            })
            const deleteCommentResult = await deleteComment.text()
            if (deleteCommentResult == "Sucesso") {
                window.location.href = window.location.pathname + `?id=${headerParams.get('id')}&deleteCommentResult=Sucesso`
            } else if (deleteCommentResult == "FalhaPDO") {
                showToast("Erro", "Houve uma falha no envio. Tente novamente")
            }
        }

        async function deletePost(id) {
            let formData = new FormData()
            formData.append("id", id)
            const deletePost = await fetch("../Action/posts/deletePost.php", {
                method: "POST",
                body: formData
            })
            const deletePostResult = await deletePost.text()
            if (deletePostResult == "Sucesso") {
                window.location.href = "../index.php?deletePostResult=Sucesso"
            } else if (deletePostResult == "FalhaPDO") {
                showToast("Erro", "Houve uma falha no envio. Tente novamente")
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
</body>

</html>
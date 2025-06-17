<?php
require __DIR__ . "/../Connection/connDB.php";

function fetchPost($dbConnection, $id)
{
    $stmt = $dbConnection->prepare("SELECT posts.*, usuarios.nome, usuarios.foto_usuario, especies.nome_popular FROM posts JOIN usuarios ON posts.nome_usuario = usuarios.nome_usuario JOIN especies ON LOWER(posts.nome_cientifico) = LOWER(especies.nome_cientifico) WHERE posts.post_id = :post_id ORDER BY data_upload DESC");
    $stmt->bindParam(':post_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchComments($dbConnection, $id)
{
    $stmt = $dbConnection->prepare("SELECT comentarios.*, usuarios.foto_usuario FROM comentarios JOIN usuarios ON comentarios.nome_usuario = usuarios.nome_usuario WHERE post_id = :post_id ORDER BY data_comentario DESC");
    $stmt->bindParam(':post_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
}

function fetchPosts($dbConnection)
{
    $stmt = $dbConnection->prepare("SELECT posts.*, usuarios.nome, usuarios.foto_usuario, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS likeCount, (SELECT COUNT(*) FROM comentarios WHERE comentarios.post_id = posts.post_id) AS commentCount FROM posts JOIN usuarios ON posts.nome_usuario = usuarios.nome_usuario ORDER BY data_upload DESC LIMIT 4");
    $stmt->execute();
    return $stmt;
}


function fetchPostsBusca($dbConnection, $busca)
{
    $busca = str_replace("@", "", "%" . $busca . "%");
    $stmt = $dbConnection->prepare("SELECT posts.*, usuarios.nome, usuarios.foto_usuario, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS likeCount, (SELECT COUNT(*) FROM comentarios WHERE comentarios.post_id = posts.post_id) AS commentCount, especies.nome_popular FROM posts JOIN usuarios ON posts.nome_usuario = usuarios.nome_usuario join especies on posts.nome_cientifico = especies.nome_cientifico WHERE REPLACE(posts.nome_usuario,'@','') LIKE :busca OR posts.nome_cientifico LIKE :busca OR usuarios.nome LIKE :busca OR especies.nome_popular LIKE :busca ORDER BY data_upload DESC LIMIT 8");
    $stmt->bindParam(':busca', $busca, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
}


function fetchPostsCategoria($dbConnection, $categoria)
{
    $stmt = $dbConnection->prepare("SELECT posts.*, usuarios.nome, usuarios.foto_usuario, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS likeCount, (SELECT COUNT(*) FROM comentarios WHERE comentarios.post_id = posts.post_id) AS commentCount FROM posts JOIN usuarios ON posts.nome_usuario = usuarios.nome_usuario JOIN especies ON LOWER(posts.nome_cientifico) = LOWER(especies.nome_cientifico) WHERE LOWER(especies.classificacao) = LOWER(:categoria) ORDER BY data_upload DESC LIMIT 8;");
    $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
}


function fetchUsers($dbConnection)
{
    $stmt = $dbConnection->prepare("SELECT nome_usuario FROM usuarios ORDER BY nome_usuario ASC;");
    $stmt->execute();
    return $stmt;
}

function fetchUser($dbConnection, $nomeUsuario)
{
    $stmt = $dbConnection->prepare("SELECT * FROM usuarios WHERE nome_usuario = :nome_usuario;");
    $stmt->bindParam(':nome_usuario', $nomeUsuario);
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        return false;
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function fetchPostsUser($dbConnection, $username)
{
    $stmt = $dbConnection->prepare("SELECT posts.*, usuarios.nome, usuarios.foto_usuario, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS likeCount, (SELECT COUNT(*) FROM comentarios WHERE comentarios.post_id = posts.post_id) AS commentCount FROM posts JOIN usuarios ON posts.nome_usuario = usuarios.nome_usuario WHERE posts.nome_usuario = :username ORDER BY data_upload DESC LIMIT 4");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt;
}

function formatUsername($username)
{
    $username = str_replace([" ", "'", "´", "`", '"', "@",], "", $username);
    $username = "@" . $username;
    return $username;
}

function fetchLikes($dbConnection, $id)
{
    $stmt = $dbConnection->prepare("SELECT COUNT(*) as likes FROM likes WHERE post_id = :post_id");
    $stmt->bindParam(':post_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchLiked($dbConnection, $id, $user)
{
    $stmt = $dbConnection->prepare("SELECT COUNT(*) as liked FROM likes WHERE post_id = :post_id AND nome_usuario = :nome_usuario");
    $stmt->bindParam(':post_id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':nome_usuario', $user, PDO::PARAM_STR);
    $stmt->execute();
    $liked = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($liked['liked'] == 0) {
        return false;
    } else {
        return true;
    }
}

function fetchSpecies($dbConnection)
{
    $stmt = $dbConnection->prepare("SELECT * FROM especies");
    $stmt->execute();
    return $stmt;
}

function fetchSpecie($dbConnection, $tipo_nome, $nome)
{
    $stmt = $dbConnection->prepare("SELECT * FROM especies WHERE LOWER($tipo_nome) = LOWER(:nome)");
    $stmt->bindParam(":nome", $nome);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

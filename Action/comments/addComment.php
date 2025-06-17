<?php
require __DIR__ . "/../../Connection/connDB.php";
$id = $_POST['id'];
$comentario = $_POST['comentario'];
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "FalhaLogin";
    exit;
}

if (!isset($_POST['id']) || !isset($_POST['comentario'])) {
    echo "FalhaID";
    exit;
}


// Checar se o ID do post é válido
$id_check = $conn->prepare("SELECT post_id FROM posts WHERE post_id = :post_id");
$id_check->bindParam(':post_id', $id, PDO::PARAM_STR);
$id_check->execute();
$id_check = $id_check;

// Se o ID não for válido, redirecionar para a página inicial
if ($id_check->rowCount() == 0) {
    echo "FalhaID";
    exit;
}
try {
    $comentarioFiltrado = trim($comentario);
    $id_comentario = uniqid($id, true);
    $conn->beginTransaction();
    $usuario = $_SESSION['usuario']->nome_usuario;
    $stmt = $conn->prepare("INSERT INTO comentarios (post_id, nome_usuario, id_comentario, comentario) VALUES (:post_id, :nome_usuario, :id_comentario, :comentario)");
    $stmt->bindParam(':post_id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':nome_usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':id_comentario', $id_comentario, PDO::PARAM_STR);
    $stmt->bindParam(':comentario', $comentarioFiltrado, PDO::PARAM_STR);
    $stmt->execute();
    $conn->commit();
    echo "Sucesso";
    exit;
} catch (PDOException $e) {
    // Tratar erro de transação
    $conn->rollBack();
    echo "FalhaPDO";
    exit;
}

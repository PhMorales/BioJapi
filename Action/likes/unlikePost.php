<?php
require __DIR__ . "/../../Connection/connDB.php";


$id = $_GET['id'];

// Checar se o ID do post é válido
$id_check = $conn->prepare("SELECT post_id FROM posts WHERE post_id = :post_id");
$id_check->bindParam(':post_id', $id, PDO::PARAM_STR);
$id_check->execute();
// Se o ID não for válido, redirecionar para a página inicial
if (!$id || $id_check->rowCount() == 0) {
    header('Location: /');
    exit;
}
// Verificar se o usuário está logado, e se não estiver, redirecionar para a página de login
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../Pages/login.php");
    exit;
}

$user = $_SESSION['usuario']->nome_usuario;

$conn->beginTransaction();

try {
    $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = :post_id AND nome_usuario = :nome_usuario");
    $stmt->bindParam(':post_id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':nome_usuario', $user, PDO::PARAM_STR);
    $stmt->execute();

    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
    // tratar erro depois
}

header("Location: ../../Pages/post.php?id=$id");

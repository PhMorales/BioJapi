<?php
require "../../Connection/connDB.php";

header('Content-Type: application/json');

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3;

$stmt = $conn->prepare("SELECT posts.*, usuarios.nome, usuarios.foto_usuario, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.post_id) AS likeCount, (SELECT COUNT(*) FROM comentarios WHERE comentarios.post_id = posts.post_id) AS commentCount FROM posts JOIN usuarios ON posts.nome_usuario = usuarios.nome_usuario ORDER BY data_upload DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($posts);

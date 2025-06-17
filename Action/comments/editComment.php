<?php

require __DIR__ . "/../../Connection/connDB.php";

$id = $_POST['id'];
$comentario = $_POST['comentario'];
$check = $conn->prepare("SELECT * FROM comentarios WHERE id_comentario = :id");
$check->bindParam(":id", $id);
$check->execute();
$comment = $check->fetch(PDO::FETCH_ASSOC);
if ($comentario == $comment['comentario']) {
    echo "FalhaComentario";
    exit;
}

$conn->beginTransaction();

try {
    $sql = "UPDATE `comentarios` SET `comentario`=:comentario WHERE `id_comentario`=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":comentario", $comentario);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $conn->commit();
    echo "Sucesso";
    exit;
} catch (Exception $e) {
    echo "FalhaPDO";
    exit;
}

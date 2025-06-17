<?php

require __DIR__ . "/../../Connection/connDB.php";
$id = $_POST["id"];
$getImg = "SELECT imagem_nome FROM `posts` WHERE post_id = :post_id";
$getImg = $conn->prepare($getImg);
$getImg->bindParam(":post_id", $id);
$getImg->execute();
if ($getImg->rowCount() == 0) {
    echo "FalhaID";
    exit;
}
$img = $getImg->fetch(PDO::FETCH_ASSOC);
$img = __DIR__ . "/../../img/fotos_post/" . $img['imagem_nome'];
$conn->beginTransaction();
try {
    $sql = "DELETE FROM `comentarios` WHERE post_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $sql = "DELETE FROM `likes` WHERE post_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $sql = "DELETE FROM `posts` WHERE post_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    if (file_exists($img)) {
        unlink($img);
    }
    $conn->commit();
    echo "Sucesso";
} catch (Exception $e) {
    echo "FalhaPDO";
    $conn->rollBack();
}

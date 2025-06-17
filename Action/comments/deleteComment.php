<?php

require __DIR__ . "/../../Connection/connDB.php";
$id = $_POST["id"];
$conn->beginTransaction();
try {
    $sql = "DELETE FROM `comentarios` WHERE id_comentario = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $conn->commit();
    echo "Sucesso";
} catch (Exception $e) {
    echo "FalhaPDO";
    $conn->rollBack();
}

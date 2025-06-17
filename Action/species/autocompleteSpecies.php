<?php
require __DIR__ . "/../fetchStuff.php";
require __DIR__ . "/../../Connection/connDB.php";
$tipo_nome = $_POST['tipo_nome'];
$nome = $_POST['nome'];
$especie = fetchSpecie($conn, $tipo_nome, $nome);
echo json_encode($especie);

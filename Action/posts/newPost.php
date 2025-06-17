<?php
require __DIR__ . "/../../Connection/connDB.php";

// verificando se o usuário já está logado
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "FalhaLogin";
    exit;
}

$imagem = $_FILES['imagem']['name'];
$tipos_permitidos = array('jpg', 'png', 'jpeg', "mp4", 'webm');
$extensao = pathinfo($imagem, PATHINFO_EXTENSION);
$nome_temp = $_FILES['imagem']['tmp_name'];
$imagem = str_replace(('.' . $extensao), "", $imagem);
$imagem .= $_SESSION['usuario']->nome_usuario . date("dmYHis") . '.' . $extensao;
$destino = "../../img/fotos_post/" . $imagem;

$coord = $_POST['coord'];
$descricao = $_POST['descricao'];
$nome_cientifico = $_POST['nome_cientifico'];
$data_img = $_POST['data_img'];
$sensivel = $_POST['sensivel'];
$acidente = $_POST['acidente'];

if (!in_array($extensao, $tipos_permitidos)) {
    echo "FalhaExtensao";
    exit;
}

if (!move_uploaded_file($nome_temp, $destino)) {
    echo "FalhaIMG";
    exit;
}

$conn->beginTransaction();

try {
    $id = uniqid("", true);
    $sql = "INSERT INTO posts(`post_id`, `imagem_nome`, `nome_cientifico`, `nome_usuario`, `sensivel`, `acidente`, `legenda`, `data_imagem`, `localizacao`) VALUES (:id, :imagem_nome, :nome_cientifico, :nome, :sensivel, :acidente, :legenda, :data_imagem, :coord)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_STR);
    $stmt->bindParam(":imagem_nome", $imagem, PDO::PARAM_STR);
    $stmt->bindParam(":nome", $_SESSION['usuario']->nome_usuario, PDO::PARAM_STR);
    $stmt->bindParam(":legenda", $descricao, PDO::PARAM_STR);
    $stmt->bindParam(":nome_cientifico", $nome_cientifico, PDO::PARAM_STR);
    $stmt->bindParam(":data_imagem", $data_img, PDO::PARAM_STR);
    $stmt->bindParam(":coord", $coord, PDO::PARAM_STR);
    $stmt->bindParam(":sensivel", $sensivel, PDO::PARAM_INT);
    $stmt->bindParam(":acidente", $acidente, PDO::PARAM_INT);
    $stmt->execute();
    $conn->commit();

    echo "Sucesso";
} catch (Exception $e) {
    $conn->rollBack();
    echo "FalhaPDO";
}

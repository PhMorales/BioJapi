<?php

require "../../Connection/connDB.php";
require "../fetchStuff.php";

session_start();

$alterado = false;

$nomeFotoUsuario = explode("@", $_SESSION['usuario']->foto_usuario)[0] . ".";
$extensaoFoto = explode(".", $_SESSION['usuario']->foto_usuario);
$nomeFotoUsuario .= end($extensaoFoto);

$sql = "UPDATE `usuarios` SET ";


if (isset($_FILES["imagem"]) && $_FILES['imagem']['name'] != $nomeFotoUsuario) {
    $imagem = $_FILES['imagem']['name'];
    $tipos_permitidos = array('jpg', 'png', 'jpeg');
    $extensao = pathinfo($imagem, PATHINFO_EXTENSION);
    $nome_temp = $_FILES['imagem']['tmp_name'];
    $imagem = str_replace(('.' . $extensao), "", $imagem);
    $imagem .= $_SESSION['usuario']->nome_usuario . date("dmYHis") . '.' . $extensao;
    $destino = "../../img/fotos_usuario/" . $imagem;

    if (!in_array($extensao, $tipos_permitidos)) {
        echo json_encode([
            "status" => "FalhaExtensao"
        ]);
        exit;
    }
    if (!move_uploaded_file($nome_temp, $destino)) {
        echo json_encode([
            "status" => "FalhaIMG"
        ]);
        exit;
    }
    $sql .= "`foto_usuario`=:imagem{";
    $alterado = true;
}

if (isset($_POST['nome']) && $_POST['nome'] != $_SESSION['usuario']->nome) {
    $nome = $_POST["nome"];
    $sql = str_replace("{", ", ", $sql);
    $sql .= "`nome`=:nome{";
    $alterado = true;
}
if (isset($_POST['nome_usuario']) && formatUsername($_POST['nome_usuario']) != $_SESSION['usuario']->nome_usuario) {
    $nomeUsuario = $_POST["nome_usuario"];
    $nomeUsuario = formatUsername($nomeUsuario);
    $sql = str_replace("{", ", ", $sql);
    $sql .= "`nome_usuario`=:nome_usuario{";
    $alterado = true;
}
if (isset($_POST['email']) && $_POST['email'] != $_SESSION['usuario']->email) {
    $email = $_POST["email"];
    $sql = str_replace("{", ", ", $sql);
    $sql .= "`email`=:email{";
    $alterado = true;
}
if (isset($_POST['bio']) && $_POST['bio'] != $_SESSION['usuario']->bio_usuario) {
    $bio = $_POST["bio"];
    $sql = str_replace("{", ", ", $sql);
    $sql .= "`bio_usuario`=:bio{";
    $alterado = true;
}

if ($alterado == false) {
    echo json_encode([
        "status" => "FalhaAlteracao"
    ]);
    exit;
}


$response = $conn->prepare("SELECT * FROM usuarios WHERE email = :email OR nome_usuario = :nome_usuario");
$response->bindParam(":email", $email);
$response->bindParam(":nome_usuario", $nomeUsuario);
$response->execute();

//verificando se o email já existe no banco de dados ou se os campos estão vazios
if ($response->rowCount() > 0) {

    echo json_encode([
        "status" => "FalhaCadastroExistente"
    ]);
    exit;
}

$conn->beginTransaction();
$sql = str_replace("{", " ", $sql);

$sql .= "WHERE `nome_usuario` = :nome_usuarioAlt";
$nome_usuarioAlt = $_SESSION['usuario']->nome_usuario;

try {

    $stmt = $conn->prepare($sql);
    if (isset($imagem)) {
        $stmt->bindParam(":imagem", $imagem, PDO::PARAM_STR);
        $foto_antiga = "../../img/fotos_usuario/" . $_SESSION['usuario']->foto_usuario;
        if ($_SESSION['usuario']->foto_usuario != "default.png") {
            if (file_exists($foto_antiga)) {
                unlink($foto_antiga);
            }
        }
    }
    if (isset($nome)) {
        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    }
    if (isset($nomeUsuario)) {
        $stmt->bindParam(":nome_usuario", $nomeUsuario, PDO::PARAM_STR);
    }
    if (isset($email)) {
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    }
    if (isset($bio)) {
        $stmt->bindParam(":bio", $bio, PDO::PARAM_STR);
    }
    $stmt->bindParam(":nome_usuarioAlt", $nome_usuarioAlt, PDO::PARAM_STR);
    $stmt->execute();
    $conn->commit();

    if (!isset($email)) {
        $email = $_SESSION['usuario']->email;
    }
    $response = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $response->bindParam(':email', $email, PDO::PARAM_STR);
    $response->execute();
    $row = $response->fetch(PDO::FETCH_OBJ);
    $_SESSION["usuario"] = $row;

    echo json_encode([
        "status" => "Sucesso",
        "usuario" => $row->nome_usuario
    ]);
    exit;
} catch (Exception $e) {

    $conn->rollBack();
    echo json_encode([
        "status" => "FalhaPDO"
    ]);
    exit;
}

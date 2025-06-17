<?php
require __DIR__ . "/../../Connection/connDB.php";

if (!isset($_POST['email']) || !isset($_POST['senha'])) {
    echo "FalhaInfo";
    exit;
}
$email = $_POST['email'];
$senha = $_POST['senha'];

$verify = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
$verify->bindParam(":email", $email);
$verify->execute();

if ($verify->rowCount() == 0) {

    echo "FalhaUser";
    exit;
}


$conn->beginTransaction();
try {
    require "../../Connection/connenv.php";
    $password = openssl_encrypt($senha, $algoritmo, $chave, $options, $iv);

    $password = base64_encode($iv . $password);


    $sql = "UPDATE `usuarios` SET `senha`=:senha";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":senha", $password);
    $stmt->execute();
    $conn->commit();
    echo "Sucesso";
    exit;
} catch (Exception $e) {
    $conn->rollBack();
    echo "FalhaPDO";
    exit;
}

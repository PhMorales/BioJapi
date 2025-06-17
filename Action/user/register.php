<?php
require __DIR__ . "/../../Connection/connDB.php";
require __DIR__ . "/../fetchStuff.php";

$nome = $_POST["name"];
$nomeUsuario = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$estado = $_POST["estado"];
$cidade = $_POST["cidade"];
$nomeUsuario = formatUsername($nomeUsuario);
$response = $conn->prepare("SELECT * FROM usuarios WHERE email = :email OR nome_usuario = :nome_usuario");
$response->bindParam(":email", $email);
$response->bindParam(":nome_usuario", $nomeUsuario);
$response->execute();

//verificando se o email já existe no banco de dados ou se os campos estão vaziosz
if ($response->rowCount() > 0) {

    // por enquanto só envia de volta para a página de registro, mas depois eu vou criar um handler de erro e preparar um alertazinho, com uma mensagem de erro e o código de erro
    echo "FalhaCadastroExistente";
    exit;
}




// preparando o dotenv
require "../../Connection/connenv.php";

try {
    // criptografando a senha
    $password = openssl_encrypt($password, $algoritmo, $chave, $options, $iv);

    // salvando o iv junto com a senha, para depois conseguir descriptografar
    $password = base64_encode($iv . $password);

    $conn->beginTransaction();


    // inserindo os dados no banco de dados
    $sql = "INSERT INTO usuarios(`nome`, `nome_usuario`, `email`, `senha`, `cidade`, `estado`) VALUES (:nome, :nome_usuario, :email, :pass, :cidade, :estado)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":nome_usuario", $nomeUsuario);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pass", $password);
    $stmt->bindParam(":cidade", $cidade);
    $stmt->bindParam(":estado", $estado);

    $stmt->execute();
    $conn->commit();
    echo "Sucesso";
} catch (Exception $e) {
    // por enquanto só envia de volta para a página de registro, mas depois eu vou criar um handler de erro e preparar um alertazinho, com uma mensagem de erro e o código de erro
    $conn->rollBack();
    echo "FalhaPDO";
}

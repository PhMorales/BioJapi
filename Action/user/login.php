<?php
require __DIR__ . "/../../Connection/connDB.php";

$email = $_POST["email"];
$password = $_POST["password"];
$response = $conn->prepare("SELECT * FROM usuarios WHERE Email = :email OR REPLACE(nome_usuario, '@', '') =REPLACE(:email,'@', '')");
$response->bindParam(':email', $email, PDO::PARAM_STR);
$response->execute();
$row = $response->fetch(PDO::FETCH_OBJ);

if (!$row) {
    echo "FalhaLogin";
    exit;
}
require "../decodepass.php";

if ($password == decodePassword($row->senha)) {
    session_start();
    $_SESSION["Logado"] = true;
    $_SESSION["usuario"] = $row;


    echo "Sucesso";
} else {

    echo "FalhaLogin";
}

<?php
function decodePassword($password)
{
    // preparando o dotenv
    require __DIR__ . "/../Connection/connenv.php";

    // decodificando a senha
    $iv = substr(base64_decode($password), 0, $iv_len);
    $password = substr(base64_decode($password), $iv_len);

    return openssl_decrypt($password, $algoritmo, $chave, $options, $iv);
}

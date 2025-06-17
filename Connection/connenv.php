<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// configurando o algoritmo de criptografia
$algoritmo = $_ENV["ALGORITMO_CRIPTOGRAFIA"];
$chave = $_ENV["CHAVE_CRIPTOGRAFIA"];
$iv_len = openssl_cipher_iv_length($algoritmo);
$iv = openssl_random_pseudo_bytes($iv_len);
$options = 0;

$resend = $_ENV["CHAVE_RESEND"];

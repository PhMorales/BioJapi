<?php

require __DIR__ . "/../Connection/resend.php";

$codigo = $_POST['codigo'];
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "FalhaEmail";
    exit;
}

$resend->emails->send([
    'from' => 'Acme <onboarding@resend.dev>',
    'to' => "pmctrlplay@gmail.com", //"$email",
    'subject' => 'TESTE DE CÓDIGO',
    'html' => "<p>Seu código de verificação é <strong>$codigo</strong></p>"
]);

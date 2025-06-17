<?php
session_start();
if (isset($_SESSION['usuario'])) {
    session_destroy();
    echo "Sucesso";
} else {
    echo "ErroLogin";
}

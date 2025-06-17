<?php
require "../Connection/connDB.php";
require "../Action/fetchStuff.php";
session_start();
$response = fetchPostsUser($conn, $_SESSION['usuario']->nome_usuario)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioJapi - Novo Post</title>
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="../Css/especialista.css">
    <link rel="stylesheet" href="../Css/components/toast.css">
</head>

<body>
    <div class="formContainer">
        <div class="infos">
            <div class="BTNS">
                <div class="btnVoltar">
                    <a href="../"><i class="fa-solid fa-arrow-left"></i> Voltar à pagina inicial</a>
                </div>
            </div>
            <div class="titulo">
                <h1>ESPECIALIZAÇÃO</h1>
            </div>
            <div class="info">
                <p>Auxilie a BIOJAPI a ser um site ainda melhor!</p>
                <ul>
                    <p>Ao se tornar um especialista, você poderá contribuir das seguintes formas:</p>
                    <li>Validar espécies em posts;</li>
                    <li>Sanar dúvidas nos fóruns;</li>
                    <li>Auxiliar usuários a identificarem espécies;</li>
                    <li>Facilitar a divulgação da ciência ao público geral.</li>
                </ul>
            </div>
        </div>


        <div class="TxtContent">
            <div class="aux">
                <div class="inputs">
                    <div class="input">
                        <label for="especializacao">Escreva sua área de especialização</label>
                        <select name="especialização" id="especialização">
                            <option value="" selected>SELECIONE A CATEGORIA</option>
                            <optgroup label="Fauna">
                                <option value="Mamífero">Mamífero</option>
                                <option value="Ave">Ave</option>
                                <option value="Anfíbio">Anfíbio</option>
                                <option value="Réptil">Réptil</option>
                                <option value="Peixe">Peixe</option>
                                <option value="Inseto">Inseto</option>
                                <option value="Outros">Outros</option>
                            </optgroup>
                            <optgroup label="Flora">
                                <option value="Árvore">Árvore</option>
                                <option value="Arbusto">Arbusto</option>
                                <option value="Rasteira">Vegetação Rasteira</option>
                                <option value="Rasteira">Cogumelos</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="input">
                        <label for="id_lattes">Informe seu ID Lattes</label>
                        <input type="text" name="id_lattes" id="id_lattes">
                    </div>
                    <div class="input">
                        <label for="descricao">Escreva brevemente suas experiencias com a BIOJAPI</label>
                        <textarea name="descricao" id="descricao" cols="30" rows="5" maxlength="255"></textarea>
                    </div>
                </div>
                <div class="BTNSubmit"><button type="button" id="BntEnviar" name="BntEnviar">ENVIAR</button></div>
            </div>
        </div>

    </div>

    <div class="toastBox"></div>


    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>

    <script>

    </script>

</body>

</html>
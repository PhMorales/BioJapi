<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../Pages/login.php?postResult=FalhaLogin");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioJapi - Novo Post</title>
    <link rel="shortcut icon" href="../img/logo/bioJapi4.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="../Css/newPost.css">
    <link rel="stylesheet" href="../Css/components/toast.css">
</head>

<body>
    <div class="formContainer">

        <form method="post" class="newPostForm" enctype="multipart/form-data">
            <div class="imgArea">
                <div class="imgInput">

                    <!-- Pré-visualização (imagem ou vídeo) -->
                    <div class="previewContainer">
                        <img class="imgPreview" src="" alt="Pré-visualização da imagem">
                        <video class="videoPreview" controls></video>
                    </div>
                    <div class="input">
                        <label for="imagem" class="inputImagem">Insira um arquivo</label>
                        <input type="file" name="imagem" id="imagem" accept=".png, .jpg, .jpeg, .mp4, .webm">
                        <p class="nomeArq">Arquivo selecionado: Nenhum</p>
                    </div>


                </div>

                <div class="input">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" cols="30" rows="3" maxlength="255"></textarea>
                </div>
                <div class="infoAnimal">
                    <div class="inputs">
                        <div class="input">
                            <label for="nome_popular">Nome popular</label>
                            <input type="text" name="nome_popular" id="nome_popular" placeholder="Ex: Paca">
                        </div>
                        <div class="input">
                            <label for="nome_cientifico">Nome científico</label>
                            <input type="text" name="nome_cientifico" id="nome_cientifico" placeholder="Ex: Cuniculus paca">
                        </div>
                    </div>

                    <div class="input identificacao">
                        <label for="identificacao">Não identificado
                            <input type="checkbox" name="identificacao" id="identificacao" class="checkbox">
                            <span class="checkmark"></span>
                        </label>
                        <select name="tag" id="tag" disabled='true'>
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
                                <option value="Cogumelo">Cogumelos</option>
                            </optgroup>

                        </select>
                    </div>

                </div>



            </div>
            <div class="infoAdicional">
                <div class="btnVoltar">
                    <a href="../"><i class="fa-solid fa-arrow-left"></i> Voltar à pagina inicial</a>
                </div>
                <div class="input mapInput">
                    <label for="mapContainer">Localização da imagem:</label>
                    <div id='mapContainer' class="mapContainer">
                        <div id="map"></div>
                    </div>
                </div>
                <div class="otherInputs">
                    <div class="blurInputs">
                        <div class="input sensivel">
                            <label for="sensivel">Sensível?
                                <input type="checkbox" name="sensivel" id="sensivel" class="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <div class="input sensivel">
                            <label for="acidente" style="opacity:0" id="acidenteLabel">Acidente?
                                <input type="checkbox" name="acidente" id="acidente" class="checkbox" disabled>
                                <span class="checkmark"></span>

                            </label>
                        </div>
                    </div>

                    <div class="misc">
                        <div class="input">
                            <label for="dataFoto">Data da foto</label>
                            <input type="date" name="dataFoto" id="dataFoto">
                        </div>
                        <button type="submit">Publicar</button>
                    </div>

                </div>


            </div>
        </form>

    </div>

    <div class="toastBox"></div>


    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://kit.fontawesome.com/31a701f672.js" crossorigin="anonymous"></script>
    <script src="../scripts/toast.js"></script>

    <script>
        var map = L.map('map').setView([-23.229566454768744, -46.955902196882796], 13)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            minZoom: 10,
            maxZoom: 19,
        }).addTo(map)
        map.locate({
            setView: true,
            maxZoom: 16,
            enableHighAccuracy: true
        })
        let marker = null
        let coord = ""

        function setMarker(latlng, accuracyText = '') {
            if (marker) {
                marker.setLatLng(latlng)
            } else {
                marker = L.marker(latlng).addTo(map)
            }
            marker.bindPopup(`Localização marcada: ${latlng.lat.toFixed(6)} ${latlng.lng.toFixed(6)} ${accuracyText}`).openPopup()
            coord = `${latlng.lat.toFixed(6)} ${latlng.lng.toFixed(6)}`
        }

        function onLocationFound(e) {
            if (e.accuracy > 100) {
                map.setView([-23.229566454768744, -46.955902196882796], 13)
                showToast("Erro", `Precisão baixa demais (${Math.round(e.accuracy)}m)`)
                showToast("Alerta", "Selecione o local manualmente no mapa")
            } else {
                setMarker(e.latlng, `(±${Math.round(e.accuracy)}m)`)
            }
        }

        map.on('locationfound', onLocationFound)

        map.on('locationerror', function() {
            map.setView([-23.229566454768744, -46.955902196882796], 13)
            showToast("Erro", "Falha ao localizar (GPS desativado)")
            showToast("Alerta", "Selecione o local manualmente no mapa")
        })

        map.on('click', function(e) {
            setMarker(e.latlng, '(selecionado manualmente)')
        })


        const inputMedia = document.getElementById('imagem')
        const imgPreview = document.querySelector('.imgPreview')
        const videoPreview = document.querySelector('.videoPreview')

        inputMedia.addEventListener('change', function() {
            const file = this.files[0]
            const pArquivo = document.querySelector(".nomeArq")
            if (file) {
                const reader = new FileReader()
                reader.onload = function(e) {
                    const fileURL = e.target.result

                    if (file.type.startsWith('image/')) {
                        imgPreview.src = fileURL
                        imgPreview.style.display = 'block'
                        videoPreview.style.display = 'none'
                        videoPreview.src = ''
                    } else if (file.type.startsWith('video/')) {
                        videoPreview.src = fileURL
                        videoPreview.style.display = 'block'
                        imgPreview.style.display = 'none'
                        imgPreview.src = ''
                    }
                }
                reader.readAsDataURL(file)
                pArquivo.innerHTML = `Arquivo selecionado: ${file.name}`
            } else {
                imgPreview.style.display = 'none'
                videoPreview.style.display = 'none'
                imgPreview.src = ''
                videoPreview.src = ''
                pArquivo.innerHTML = `Arquivo selecionado: Nenhum`
            }
        })

        const form = document.querySelector(".newPostForm")
        form.addEventListener('submit', (event) => {
            event.preventDefault()
            if (event.srcElement[0].files[0] == undefined) {
                showToast("Alerta", "Insira uma imagem")
                return
            }
            if (event.srcElement[1].value == false) {
                showToast("Alerta", "Insira uma descrição")
                return
            }
            if (event.srcElement[3].value == false) {
                showToast("Alerta", "Insira o nome científico ou popular do animal")
                return
            }
            if (event.srcElement[5].value == false) {
                showToast("Alerta", "Selecione a categoria do ser vivo")
                return
            }
            if (coord == "") {
                showToast("Alerta", "Selecione o local aproximado da foto no mapa")
                return
            }
            if (event.srcElement[8].value == false) {
                showToast("Alerta", "Selecione a data da foto")
                return
            }

            let hoje = new Date()
            let inputDataVal = new Date(event.srcElement[8].value + "T00:00")
            if (inputDataVal > hoje) {
                showToast("Alerta", "A data da foto não pode ser depois da data atual")
                return
            }

            const formData = new FormData()
            formData.append("imagem", event.srcElement[0].files[0])
            formData.append("descricao", event.srcElement[1].value)
            formData.append("nome_cientifico", event.srcElement[3].value != "-" ? event.srcElement[3].value : `Não Identificado - ${tag.value}`)
            formData.append("coord", coord)
            formData.append("data_img", event.srcElement[8].value)
            formData.append("sensivel", sensivel.checked == true ? 1 : 0)
            formData.append("acidente", acidente.checked == true ? 1 : 0)
            newPost(formData)

        })
        identificacao.addEventListener("click", () => {
            if (identificacao.checked) {
                nomeCientifico.value = "-"
                nomePopular.value = "-"
            } else {
                nomeCientifico.value = ""
                nomePopular.value = ""
            }
            nomeCientifico.disabled = identificacao.checked
            nomePopular.disabled = identificacao.checked
            tag.disabled = !identificacao.checked
        })
        sensivel.addEventListener("click", () => {
            if (sensivel.checked) {
                acidenteLabel.style.opacity = "1"
                acidente.disabled = false
            } else {
                acidenteLabel.style.opacity = "0"
                acidente.checked = false
                acidente.disabled = true

            }

        })

        async function newPost(formData) {
            const newPost = await fetch("../Action/posts/newPost.php", {
                method: "POST",
                body: formData
            })
            const postResult = await newPost.text()
            if (postResult == "Sucesso") {
                window.location.href = '../?postResult=Sucesso'
            }
            if (postResult == "FalhaIMG") {
                showToast("Erro", "Falha ao salvar a imagem")
                return
            }
            if (postResult == "FalhaExtensao") {
                showToast("Alerta", "Tipo de arquivo não permitido")
                return
            }
            if (postResult == "FalhaLogin") {
                window.location.href = '../Pages/login.php?postResult=FalhaLogin'
            }
            if (postResult == "FalhaPDO") {
                window.location.href = '../?postResult=Error'
            }
        }

        const nomeCientifico = document.getElementById('nome_cientifico')
        const nomePopular = document.getElementById('nome_popular')
        const classificacao = document.getElementById('tag')
        nomeCientifico.addEventListener('change', () => mudarValores('nome_cientifico', nomeCientifico.value))
        nomePopular.addEventListener('change', () => mudarValores('nome_popular', nomePopular.value))

        async function mudarValores(tipo, nome) {
            const formData = new FormData()
            formData.append("tipo_nome", tipo)
            formData.append("nome", nome)

            const fetchEspecie = await fetch('../Action/species/autoCompleteSpecies.php', {
                method: 'POST',
                body: formData
            })

            const especie = await fetchEspecie.json()
            if (especie.nome_cientifico == undefined) {
                showToast("Alerta", "Animal não registrado")
                return
            }

            if (tipo == 'nome_cientifico') {
                nomePopular.value = especie.nome_popular
                nomeCientifico.value = especie.nome_cientifico
                classificacao.value = especie.classificacao
            }

            if (tipo == 'nome_popular') {
                nomeCientifico.value = especie.nome_cientifico
                nomePopular.value = especie.nome_popular
                classificacao.value = especie.classificacao
            }


        }
    </script>

</body>

</html>
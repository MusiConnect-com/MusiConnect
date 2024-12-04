
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #preview {
            margin-top: 10px;
        }
        img {
            max-width: 300px; /* Limita a largura da imagem para melhor visualização */
            max-height: 300px; /* Limita a altura da imagem para melhor visualização */
        }

        .msg {
            position: fixed;
            top: 20px;
            right: 10px;
            padding: 10px 20px;
            color: white;
        }
        #msg-erro {
            background-color: red;
        }
        #msg-sucesso {
            background-color: green;
        }
    </style>
</head>
<body>
    <form enctype="multipart/form-data" action="./teste.php" method="post">
        <h3>Galeria de Fotos</h3>
        <span id="error-gallery-photos"></span>
        <div class="form-step-group" id="gallery-photos">
            <button type="button" id="add-foto" >Adicionar Foto</button>
            <div id="inputs-gallery"></div>
            <div id="preview-gallery"></div>
        </div>

        <label for="id">Id do Usuário</label>
        <input type="text" name="id" id="id">

        <button type="submit" id="btn-enviar">Enviar</button>
    </form>

    <script>
        function validateFile(file, erro) {
            const fileTypes = ["image/jpeg", "image/png", "image/jpg"];

            if (!file) {
                erro.innerHTML = "Imagem é obrigatória";
                return false;
            } else if (!fileTypes.includes(file.type)) {
                erro.innerHTML = "Esse arquivo não é uma imagem.";
                return false;
            }
            
            erro.innerHTML = "";
            return true;
        }

        function mostrarFotoInserida(fotos, preview) {
            const erroFotos = document.getElementById('error-gallery-photos');

            const foto = fotos[0]; 

            if (!foto || !validateFile(foto, erroFotos)) {
                return; 
            }

            const previewDiv = document.createElement('div');
            previewDiv.classList.add('layout-preview-gallery');
            const img = document.createElement('img');
            img.src = URL.createObjectURL(foto); 
            previewDiv.appendChild(img);
            preview.appendChild(previewDiv); 
        }

        function removerFotoVazia() {
            let inputs = document.querySelectorAll('.fotos');
            let inputsGaleria = document.getElementById('inputs-gallery');

            inputs.forEach(foto => {
                if (foto.value === '') {inputsGaleria.removeChild(foto);}
            });
        }

        function adicionarInputFoto() {
            const previewGaleria = document.getElementById('preview-gallery');
            const inputsGaleria = document.getElementById('inputs-gallery');

            const input = document.createElement('input');

            input.type = 'file';
            input.name = 'fotos[]';
            input.style.display = 'none';
            input.classList.add('fotos');
            input.accept = 'image/png, image/jpeg, image/jpg';

            inputsGaleria.appendChild(input);

            input.click();

            input.addEventListener('change', function(event) {
                const fotos = event.target.files;
                
                mostrarFotoInserida(fotos, previewGaleria);
            });
        }


        const addFoto = document.getElementById('add-foto');
            addFoto.addEventListener('click', ()=>{
            removerFotoVazia();
            adicionarInputFoto();
        });

        const enviar = document.getElementById('btn-enviar');
    </script>

    <?php
        if (isset($_GET['status'])) {
            $stts = $_GET['status'];
            if ($stts == 'erro') {
                echo '<p id="msg-erro" class="msg">Erro para enviar fotos</p>';
            } else if ($stts == 'sucesso') {
                echo '<p id="msg-sucesso" class="msg">Fotos enviadas ao banco</p>';
            }
        }
    ?>

</body>
</html>


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
    </style>
</head>
<body>
    <form enctype="multipart/form-data" action="./teste.php" method="post">
        <label for="arquivo">
            <input type="file" name="arquivo" id="arquivo" accept="image/png, image/jpeg, image/jpg"> 
        </label>
        <button type="submit" id="upload">Enviar Arquivo</button>
    </form>

    <div id="preview"></div>

    <script>
        document.getElementById('arquivo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            // Limpa a área de visualização antes de mostrar uma nova imagem
            preview.innerHTML = '';

            // Verifica se há um arquivo selecionado
            if (file) {
                const reader = new FileReader();
                
                // Define o que acontece quando o arquivo é lido com sucesso
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result; // A imagem lida
                    preview.appendChild(img); // Adiciona a imagem à área de visualização
                };

                // Lê o arquivo como uma URL de dados
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>

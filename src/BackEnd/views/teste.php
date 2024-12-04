<?php

// Verificando se há múltiplos arquivos
if (isset($_FILES['fotos']) && is_array($_FILES['fotos']['name'])) {
    $totalFiles = count($_FILES['fotos']['name']);
    echo '<p>'.$totalFiles.'</p>';
} elseif (isset($_FILES['fotos'])) {
    echo '<p>1</p>'; // Para o caso de um único arquivo
} else {
    echo '<p>0</p>';
}

// Verificando se há um único arquivo
if (isset($_FILES['foto']) && is_array($_FILES['foto']['name'])) {
    $totalFile = count($_FILES['foto']['name']);
    echo '<p>'.$totalFile.'</p>';
} elseif (isset($_FILES['foto'])) {
    echo '<p>1</p>'; // Para o caso de um único arquivo
}

?>

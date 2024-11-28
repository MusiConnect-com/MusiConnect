document.addEventListener("DOMContentLoaded", function () {
    // Verifica se algum tema foi previamente definido (em localStorage ou cookies)
    if (!localStorage.getItem('tema')) {
        document.documentElement.classList.add('tema-claro'); // Define o tema claro como padrão
    } else {
        document.documentElement.classList.add(localStorage.getItem('tema')); // Caso tenha um tema salvo
    }
});

const btnMenu = document.getElementById('btn-menu');
const lista = document.getElementById('lista');

btnMenu.addEventListener('click', () => {
    lista.classList.toggle('open');
});

let fontPadrao = 1; // Tamanho inicial da fonte (em pixels)
const fontMin = 0.75;  // Tamanho mínimo
const fontMax = 1.25;  // Tamanho máximo

// Botões de controle
const maisFont = document.getElementById('mais-fonte');
const menosFont = document.getElementById('menos-fonte');
const resetFont = document.getElementById('reset-fonte');

// Função para atualizar o tamanho da fonte
function atualizarTamanhoFont() {
    document.documentElement.style.fontSize = `${fontPadrao}rem`; // Atualiza o tamanho no <html>
    localStorage.setItem('fontSize', fontPadrao); // Salva no LocalStorage
}

// Aumentar a fonte
maisFont.addEventListener('click', () => {
    if (fontPadrao < fontMax) {
        fontPadrao += 0.1; // Incrementa 0.1rem (1.6px)
        fontPadrao = parseFloat(fontPadrao.toFixed(2)); // Arredonda para evitar problemas de precisão
        atualizarTamanhoFont();
    }
});

// Diminuir a fonte
menosFont.addEventListener('click', () => {
    if (fontPadrao > fontMin) {
        fontPadrao -= 0.1; // Incrementa 0.1rem (1.6px)
        fontPadrao = parseFloat(fontPadrao.toFixed(2)); // Arredonda para evitar problemas de precisão
        atualizarTamanhoFont();
    }
});

// Redefinir para tamanho padrão
resetFont.addEventListener('click', () => {
    fontPadrao = 1; // Define o tamanho padrão (16px)
    atualizarTamanhoFont();
});

// Aplicar fonte salva ao carregar a página
const fontSizeSalva = localStorage.getItem('fontSize');
if (fontSizeSalva) {
    fontPadrao = parseFloat(fontSizeSalva);
    atualizarTamanhoFont();
}

function setTheme(tema) {
    document.documentElement.className = tema; // Altera a classe do <html>
    localStorage.setItem('tema', tema); // Salva o tema escolhido no localStorage
}

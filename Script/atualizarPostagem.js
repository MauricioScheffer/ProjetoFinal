document.addEventListener('DOMContentLoaded', function () {
    const inicio = document.getElementById('inicio');
    const explorar = document.getElementById('explorar');

    inicio.addEventListener('click', function (event) {
        event.preventDefault(); // Evita o comportamento padrão do link

        // Requisição AJAX para ler postagens por seguidor
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `atualizarPostagens.php?tipo=seguidor&idUsuario=${idUsuario}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Sucesso na requisição
                var response = xhr.responseText;
                document.querySelector('.middle').innerHTML = response; // Atualiza a área das postagens
            } else {
                // Tratar erro
                console.error('Erro ao carregar postagens por seguidor. Status: ' + xhr.status);
            }
        };
        xhr.send();
    });

    explorar.addEventListener('click', function (event) {
        event.preventDefault(); // Evita o comportamento padrão do link

        // Requisição AJAX para ler todas as postagens
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'atualizarPostagens.php?tipo=todas', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Sucesso na requisição
                var response = xhr.responseText;
                document.querySelector('.middle').innerHTML = response; // Atualiza a área das postagens
            } else {
                // Tratar erro
                console.error('Erro ao carregar todas as postagens. Status: ' + xhr.status);
            }
        };
        xhr.send();
    });
});


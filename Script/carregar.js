let currentOffset = offset;

// Função para carregar mais postagens
function loadMorePosts() {
    const loadMoreButton = document.getElementById('load-more');
    const postsContainer = document.getElementById('posts-container');
    const loadMoreContainer = document.getElementById('load-more-container');

    // Desabilitar o botão para evitar múltiplos cliques
    loadMoreButton.disabled = true;

    // Fazer a requisição AJAX
    const xhr = new XMLHttpRequest();
    xhr.open(
        'GET',
        `carregar_postagens.php?tipo=${encodeURIComponent(tipo)}&idUsuario=${encodeURIComponent(idUsuario)}&offset=${currentOffset}&limit=${limit}`,
        true
    );

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText;

            // Adicionar as novas postagens no container
            postsContainer.innerHTML += response;

            // Atualizar o offset
            currentOffset += limit;

            // Se não houver mais postagens, esconder o botão
            if (response.trim() === "") {
                loadMoreContainer.style.display = 'none';
            } else {
                // Reabilitar o botão de carregar mais
                loadMoreButton.disabled = false;
            }
        } else {
            console.error(`Erro ao carregar postagens. Status: ${xhr.status}`);
        }
    };

    xhr.onerror = function () {
        console.error('Erro na requisição AJAX.');
    };

    xhr.send();
}


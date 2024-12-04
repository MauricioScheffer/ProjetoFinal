function likePost(postId, action) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "like_post.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                var postElement = document.getElementById('post-' + postId);
                var likeButton = postElement.getElementsByTagName('button')[0];
                var likeIcon = likeButton.getElementsByTagName('i')[0];

                // Atualiza o ícone e a ação
                if (action == 'curtir') {
                    likeButton.setAttribute('onclick', `likePost(${postId}, 'descurtir')`);
                    likeIcon.className = 'fa-solid fa-heart';
                } else {
                    likeButton.setAttribute('onclick', `likePost(${postId}, 'curtir')`);
                    likeIcon.className = 'fa-regular fa-heart';
                }

                // Atualiza o contador de likes
                var likesCount = postElement.getElementsByClassName('liked-by')[0].getElementsByTagName('p')[0];
                likesCount.innerHTML = '<b>' + response.likes + ' pessoa(s) curtiram isso</b>';
            }
        }
    };
    xhr.send("id=" + postId + "&acaoCurtida=" + action);
}
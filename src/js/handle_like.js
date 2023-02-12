let like_btn = Array.from(document.getElementsByName("like-btn"));

// aggiornamento numero like per ogni post al caricamento della pagina
showAllLikes();

// aggiornamento numero like di uno specifico post, al click del bottone like
like_btn.forEach(btn => {
    btn.addEventListener("click", async () => {
        let id_post = btn.value;
        let user = await axios.post("api_get_session_user.php").then(response => response.data);
        let likes = await axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => response.data);
        await axios.post("api_handle_like.php", { id_post: id_post, alreadyLiked: userAlreadyLiked(likes, user) });
        showCurrentLikes(id_post);
        let icon = btn.querySelector('em');
        if (icon.classList.contains('bi-hand-thumbs-up')) {
          icon.classList.remove('bi-hand-thumbs-up');
          icon.classList.add('bi-hand-thumbs-up-fill');
        } else {
          icon.classList.remove('bi-hand-thumbs-up-fill');
          icon.classList.add('bi-hand-thumbs-up');
        }
    });
});

function userAlreadyLiked(likes, user) {
    return likes.some(like => like.username === user.username);
}

function showCurrentLikes(id_post) {
    axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => {
        document.getElementById(id_post+"-like-count").innerHTML = response.data.length;
    });
}

function showAllLikes() {
    like_btn.forEach(btn => {
        let id_post = btn.value;
        showCurrentLikes(id_post);
    });
}


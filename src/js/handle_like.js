let like_btn = Array.from(document.getElementsByName("like-btn"));

// aggiornamento numero like per ogni post al caricamento della pagina
showAllLikes();

// aggiornamento numero like di uno specifico post, al click del bottone like
like_btn.forEach(btn => {
    btn.addEventListener("click", () => {
        // aggiornamento db like
        let id_post = btn.value;
        axios.post("api_get_session_user.php").then(response => {
            let user = response.data;
            axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => {
                let likes = response.data;
                console.log(likes);
                axios.post("api_handle_like.php", { id_post: id_post, alreadyLiked: userAlreadyLiked(likes, user) }); // potrei anche mettere l'update dei like qua
            });
        });

        // aggiornamento interfaccia 
        showCurrentLikes(id_post);
    });
});

function userAlreadyLiked(likes, username) {
    console.log(likes.some(like => like.username === username));
    return likes.some(like => like.username === username);
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

setInterval(() => { showAllLikes() }, 1000); // get user status once every 5 seconds


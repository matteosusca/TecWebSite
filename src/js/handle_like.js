let like_btn = Array.from(document.getElementsByName("like-btn"));
like_btn.forEach(btn => {
    btn.addEventListener("click", () => {
        let id_post = btn.value;
        axios.post("api_get_session_user.php").then(response => {
            let user = response.data;
            axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => {
                let likes = response.data;
                axios.post("api_handle_like.php", { id_post: id_post, alreadyLiked: userAlreadyLiked(likes, user) }); // potrei anche mettere l'update dei like qua
            });
        });
    });
});

function userAlreadyLiked(likes, username) {
    console.log(likes.some(like => like.username === username));
    return likes.some(like => like.username === username);
}


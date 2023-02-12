let like_btns = Array.from(document.getElementsByName("like-btn"));

like_btns.forEach(btn => {
    let id_post = btn.value;
    let users = axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => response.data);
    console.log(users);
    tippy(btn, {
        onLoad(instance) {
           users.length > 0 ? instance.setContent(users.map(user => user.username).join("<br>")) : instance.disable();
        }, 
        allowHTML: true,
        placement: "bottom",
        arrow: true,
        interactive: true
    });
});
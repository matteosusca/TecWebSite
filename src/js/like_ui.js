let like_btns = Array.from(document.getElementsByName("like-btn"));

like_btns.forEach(btn => {
    let id_post = btn.value;
    let isLoading = true;
    let dots = ".";
    tippy(btn, {
        content: "Loading" + dots,
        onShow(instance) {
            if (isLoading) {
                let interval = setInterval(() => {
                  dots = dots.length >= 3 ? "." : dots + ".";
                  instance.setContent("Loading" + dots);
            }, 500);
            axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => {
                let likes = response.data;
                instance.setContent(showUsersHTML(likes));
                isLoading = false;
                clearInterval(interval);
            })
        }},
        allowHTML: true,
        placement: "bottom",
        arrow: true,
        interactive: true
    });
});

function showUsersHTML(users) {
    let html = `<div class="list-group list-group-flush offcanvas-body">`;
    users.forEach(user => {
        html += `<a class="list-group-item list-group-item-action" href="profile.php?user=${user.username}">
                    <div class="d-flex align-items-center">
                        <img src=${user.profile_picture} alt="${user.username} profile picture"  width="16" height="16" class="rounded-circle">
                        ${user.username}
                    </div>
                </a>`;
    });
    html += `</div>`;
    return html;
}
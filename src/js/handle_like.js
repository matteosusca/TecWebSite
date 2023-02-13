const like_btn = Array.from(document.getElementsByName("like-btn"));

// aggiornamento numero like per ogni post al caricamento della pagina
showAllLikes();

// aggiornamento numero like di uno specifico post, al click del bottone like
like_btn.forEach(btn => {
    let tippy = createTippy(btn);
    btn.addEventListener("click", async () => {
        await updateBackend(btn);
        updateFrontend(tippy, btn);
    });
});

//controlla se un utente ha già messo like ad un post
function userAlreadyLiked(likes, user) {
    return likes.some(like => like.username === user.username);
}

//chiede al server il numero di like di un post
function showCurrentLikes(id_post) {
    axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => {
        document.getElementById(id_post+"-like-count").innerHTML = response.data.length;
        document.getElementById(id_post+"-notification-like-count").innerHTML = response.data.length;
    });
}

//chiede al server il numero di like di tutti i post
function showAllLikes() {
    like_btn.forEach(btn => {
        let id_post = btn.value;
        showCurrentLikes(id_post);
    });
}

//aggiorna il server con il like o il dislike di un post
async function updateBackend(btn) {
    let id_post = btn.value;
    let user = await axios.post("api_get_session_user.php").then(response => response.data);
    let likes = await axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => response.data);
    await axios.post("api_like_event.php", { id_post: id_post, alreadyLiked: userAlreadyLiked(likes, user) });
}

//aggiorna l'interfaccia
function updateFrontend(tippy, btn) {
    showCurrentLikes(btn.value);
    let icon = btn.querySelector('em');
    icon.classList.toggle('bi-hand-thumbs-up');
    icon.classList.toggle('bi-hand-thumbs-up-fill');
    updateTippyContent(tippy, btn.value)
}


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

function createTippy(btn) {
    let id_post = btn.value;
    return tippy(btn, {
        content: getLoadingHTML(),
        onShow(instance) {
            updateTippyContent(instance, id_post);    
        },
        allowHTML: true,
        placement: "bottom",
        arrow: true,
        interactive: true
    });
}

function getLoadingHTML() {
    return `<div class="spinner-border spinner-border-sm" role="status"></div>`;
}

function updateTippyContent(tippy, id_post) {
    axios.post("api_get_post_likes.php", { id_post: id_post }).then(response => {
        let likes = response.data;
        tippy.setContent(showUsersHTML(likes));
    });
}